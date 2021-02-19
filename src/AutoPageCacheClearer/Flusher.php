<?php

namespace A3020\AutoPageCacheClearer;

use A3020\AutoPageCacheClearer\Entity\Item;
use Concrete\Core\Cache\Page\PageCache;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\PageList;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Flusher
{
    /** @var bool If one or more pages are flushed, this should toggle to true. */
    protected $needsRewarm = false;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var \Concrete\Core\Cache\Page\PageCache
     */
    private $cache;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(ItemRepository $itemRepository, EventDispatcherInterface $dispatcher)
    {
        $this->itemRepository = $itemRepository;
        $this->cache = PageCache::getLibrary();
        $this->dispatcher = $dispatcher;
    }

    public function handle(Item $item)
    {
        $this->needsRewarm = false;

        $this->flushByPageIds($item->getTargetPages());
        $this->flushByPageTypeIds($item->getTargetPageTypes());

        $this->fireEvent();
    }

    /**
     * Flush the cache for these pages.
     *
     * @param array $pageIds
     */
    private function flushByPageIds(array $pageIds)
    {
        foreach ($pageIds as $pageId) {
            $page = Page::getByID($pageId);
            if (!$page || $page->isError()) {
                continue;
            }

            $this->cache->purge($page);
            $this->needsRewarm = true;
        }
    }

    /**
     * Flush the cache for the page types.
     *
     * @param array $pageTypeIds
     */
    private function flushByPageTypeIds(array $pageTypeIds)
    {
        foreach ($pageTypeIds as $pageTypeId) {
            $pl = new PageList();
            $pl->filterByPageTypeID($pageTypeId);

            foreach ($pl->getResults() as $page) {
                $this->cache->purge($page);
                $this->needsRewarm = true;
            }
        }
    }

    /**
     * Make sure Cache Warmer is going to regenerate the cache.
     *
     * If Cache Warmer is not installed, nothing will happen.
     *
     * @see https://www.concrete5.org/marketplace/addons/cache-warmer/
     */
    private function fireEvent()
    {
        if (!$this->needsRewarm) {
            return;
        }

        $this->dispatcher->dispatch('on_cache_warmer_needs_rewarm');
    }
}
