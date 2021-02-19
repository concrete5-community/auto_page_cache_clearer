<?php

namespace A3020\AutoPageCacheClearer;

use A3020\AutoPageCacheClearer\Listener\PageDelete;
use A3020\AutoPageCacheClearer\Listener\PageMove;
use A3020\AutoPageCacheClearer\Listener\PageVersionApprove;
use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Config\Repository\Repository;
use Concrete\Core\Logging\Logger;
use Exception;

class Provider implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function register()
    {
        try {
            $this->listeners();
        } catch (Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
    }

    private function listeners()
    {
        $this->app['director']->addListener('on_page_version_approve', function($event) {
            /** @var \A3020\AutoPageCacheClearer\Listener\PageVersionApprove $listener */
            $listener = $this->app->make(PageVersionApprove::class);
            $listener->handle($event);
        });

        $this->app['director']->addListener('on_page_delete', function($event) {
            /** @var \A3020\AutoPageCacheClearer\Listener\PageDelete $listener */
            $listener = $this->app->make(PageDelete::class);
            $listener->handle($event);
        });

        $this->app['director']->addListener('on_page_move_to_trash', function($event) {
            /** @var \A3020\AutoPageCacheClearer\Listener\PageMoveToTrash $listener */
            $listener = $this->app->make(PageDelete::class);
            $listener->handle($event);
        });

        $this->app['director']->addListener('on_page_move', function($event) {
            /** @var \A3020\AutoPageCacheClearer\Listener\PageMove $listener */
            $listener = $this->app->make(PageMove::class);
            $listener->handle($event);
        });
    }
}
