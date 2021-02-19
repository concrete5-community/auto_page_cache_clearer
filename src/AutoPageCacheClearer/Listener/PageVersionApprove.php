<?php

namespace A3020\AutoPageCacheClearer\Listener;

use A3020\AutoPageCacheClearer\Handler;
use Concrete\Core\Logging\Logger;
use Exception;

class PageVersionApprove
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
     * Triggered when a page version is approved and the changes become public.
     *
     * @param \Concrete\Core\Page\Collection\Version\Event $event
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
