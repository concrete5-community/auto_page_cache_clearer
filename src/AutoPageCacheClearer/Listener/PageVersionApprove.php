<?php

namespace A3020\AutoPageCacheClearer\Listener;

use A3020\AutoPageCacheClearer\Handler;
use Exception;
use Psr\Log\LoggerInterface;

class PageVersionApprove
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
     * Triggered when a page version is approved and the changes become public.
     *
     * @param \Concrete\Core\Page\Collection\Version\Event $event
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
