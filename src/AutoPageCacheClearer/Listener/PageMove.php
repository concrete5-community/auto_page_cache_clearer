<?php

namespace A3020\AutoPageCacheClearer\Listener;

use A3020\AutoPageCacheClearer\Handler;
use Concrete\Core\Logging\Logger;
use Exception;

class PageMove
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
     * Triggered when a page is moved to another parent page.
     *
     * @param \Concrete\Core\Page\MovePageEvent $event
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
