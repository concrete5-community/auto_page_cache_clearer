<?php

namespace Concrete\Package\AutoPageCacheClearer;

use Concrete\Core\Package\Package;
use Concrete\Core\Support\Facade\Package as PackageFacade;
use A3020\AutoPageCacheClearer\Installer;
use A3020\AutoPageCacheClearer\Provider;

final class Controller extends Package
{
    protected $pkgHandle = 'auto_page_cache_clearer';
    protected $appVersionRequired = '8.3.1';
    protected $pkgVersion = '0.9.6';
    protected $pkgAutoloaderRegistries = [
        'src/AutoPageCacheClearer' => '\A3020\AutoPageCacheClearer',
    ];

    public function getPackageName()
    {
        return t('Auto Page Cache Clearer');
    }

    public function getPackageDescription()
    {
        return t('Invalidates the cache of certain pages when another page is modified.');
    }

    public function on_start()
    {
        /** @var Provider $provider */
        $provider = $this->app->make(Provider::class);
        $provider->register();
    }

    public function install()
    {
        $pkg = parent::install();

        /** @var Installer $installer */
        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }

    public function upgrade()
    {
        parent::upgrade();

        /** @see \Concrete\Core\Package\PackageService */
        $pkg = PackageFacade::getByHandle($this->pkgHandle);

        /** @var Installer $installer */
        $installer = $this->app->make(Installer::class);
        $installer->install($pkg);
    }
}
