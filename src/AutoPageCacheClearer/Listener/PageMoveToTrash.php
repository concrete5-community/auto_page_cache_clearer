<?php

namespace A3020\AutoPageCacheClearer\Listener;

use A3020\AutoPageCacheClearer\Handler;
use Concrete\Core\Logging\Logger;
use Exception;

class PageMoveToTrash
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var Handler
     */
    private $handler;

    public function __construct(Logger $logger, Handler $handler)
    {
        $this->logger = $logger;
        $this->handler = $handler;
    }

    /**
     * Triggered when a page is moved to the trash but not yet deleted.
     *
     * @param \Concrete\Core\Page\Event $event
     */
    public function handle($event)
    {
        try {
            $this->handler->handle($event->getPageObject());
        } catch (Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
    }
}
