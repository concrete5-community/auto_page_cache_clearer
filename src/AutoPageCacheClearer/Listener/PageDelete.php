<?php

namespace A3020\AutoPageCacheClearer\Listener;

use A3020\AutoPageCacheClearer\Handler;
use Exception;
use Psr\Log\LoggerInterface;

class PageDelete
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var Handler
     */
    private $handler;

    public function __construct(LoggerInterface $logger, Handler $handler)
    {
        $this->logger = $logger;
        $this->handler = $handler;
    }

    /**
     * Triggered when a page is ABOUT TO BE deleted.
     *
     * @param \Concrete\Core\Page\DeletePageEvent $event
     */
    public function handle($event)
    {
        try {
            $this->handler->handle($event->getPageObject());
        } catch (Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
