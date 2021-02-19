<?php

namespace A3020\AutoPageCacheClearer;

use Concrete\Core\Page\Page;

class Handler
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var Flusher
     */
    private $flusher;

    public function __construct(ItemRepository $itemRepository, Flusher $flusher)
    {
        $this->itemRepository = $itemRepository;
        $this->flusher = $flusher;
    }

    public function handle(Page $page)
    {
        foreach ($this->itemRepository->getAll() as $item) {
            // Check if this page ID should trigger a flush.
            if (in_array($page->getCollectionID(), $item->getSourcePages())) {
                $this->flusher->handle($item);
            }

            // Check if this page type ID should trigger a flush.
            if (in_array($page->getPageTypeID(), $item->getSourcePageTypes())) {
                $this->flusher->handle($item);
            }
        }
    }
}