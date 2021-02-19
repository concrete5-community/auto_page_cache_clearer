<?php

namespace Concrete\Package\AutoPageCacheClearer\Controller\SinglePage\Dashboard\System\Optimization\AutoPageCacheClearer;

use A3020\AutoPageCacheClearer\Entity\Item;
use A3020\AutoPageCacheClearer\ItemRepository;
use Concrete\Core\Http\Request;
use Concrete\Core\Http\ResponseAssetGroup;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Page\Type\Type;
use Concrete\Core\Routing\Redirect;

final class Search extends DashboardPageController
{
    public function on_before_render()
    {
        $ag = ResponseAssetGroup::get();
        $ag->requireAsset('select2');

        parent::on_before_render();
    }

    public function view()
    {
        $this->set('items', $this->getItems());
    }

    public function add()
    {
        $this->set('pageTitle', t('Add item'));

        $item = new Item();

        return $this->addEdit($item);
    }

    public function edit($id = null)
    {
        $item = $this->getRepository()->find($id);

        if (!$item) {
            $this->flash('error', 'Item not found');

            return Redirect::to('/dashboard/system/optimization/auto_page_cache_clearer/search');
        }

        $this->set('pageTitle', t('Edit item'));

        return $this->addEdit($item);
    }

    public function save()
     {
        if (!$this->token->validate('a3020.auto_page_cache_clearer.item')) {
            $this->flash('error', $this->token->getErrorMessage());

            return;
        }

        /** @var Request $request */
        $request = $this->app->make(Request::class);

        $item = $this->getRepository()->find($request->request->get('id'));
        if (!$item) {
            $item = new Item();
        }

        $item->setDescription($request->request->get('description'));
        $item->setSourcePages($this->splitText($request->request->get('source_pages')));
        $item->setSourcePageTypes($request->request->get('source_page_types', []));
        $item->setTargetPages($this->splitText($request->request->get('target_pages')));
        $item->setTargetPageTypes($request->request->get('target_page_types', []));

        $this->getRepository()->store($item);

        $this->flash('success', t('Item has been saved successfully'));

        return Redirect::to('/dashboard/system/optimization/auto_page_cache_clearer/search');
    }

    public function delete($id = null)
    {
        $item = $this->getRepository()->find($id);

        if (!$item) {
            $this->flash('error', 'Item not found');

            return Redirect::to('/dashboard/system/optimization/auto_page_cache_clearer/search');
        }

        $this->getRepository()->delete($item);

        $this->flash('success', t('Item has been removed successfully'));

        return Redirect::to('/dashboard/system/optimization/auto_page_cache_clearer/search');
    }

    private function addEdit(Item $item)
    {
        $this->set('item', $item);
        $this->set('pageTypeOptions', $this->getPageTypeOptions());

        return $this->render('/dashboard/system/optimization/auto_page_cache_clearer/items/add_edit');
    }

    private function getItems()
    {
        return $this->getRepository()->getAll();
    }

    private function getPageTypeOptions()
    {
        $options = [];
        foreach (Type::getList() as $pt) {
            $options[(int) $pt->getPageTypeID()] = h($pt->getPageTypeName());
        }

        return $options;
    }

    /**
     * @return \A3020\AutoPageCacheClearer\ItemRepository
     */
    private function getRepository()
    {
        return $this->app->make(ItemRepository::class);
    }

    /**
     * @param $string
     *
     * @return array
     */
    private function splitText($string)
    {
        return array_filter(
            array_map('trim', explode(',', $string))
        );
    }
}
