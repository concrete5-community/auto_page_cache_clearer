<?php

namespace A3020\AutoPageCacheClearer;

use Concrete\Core\Application\ApplicationAwareInterface;
use Concrete\Core\Application\ApplicationAwareTrait;
use Concrete\Core\Database\DatabaseStructureManager;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Single;

class Installer implements ApplicationAwareInterface
{
    use ApplicationAwareTrait;

    /**
     * @var DatabaseStructureManager
     */
    private $structureManager;

    public function __construct(DatabaseStructureManager $structureManager)
    {
        $this->structureManager = $structureManager;
    }

    /**
     * @param \Concrete\Core\Package\Package $pkg
     */
    public function install($pkg)
    {
        $this->structureManager->refreshEntities();
        $this->dashboardPages($pkg);
    }

    private function dashboardPages($pkg)
    {
        $pages = [
            '/dashboard/system/optimization/auto_page_cache_clearer' => 'Auto Page Cache Clearer',
            '/dashboard/system/optimization/auto_page_cache_clearer/search' => 'Search',
        ];

        foreach ($pages as $path => $name) {
            /** @var Page $page */
            $page = Page::getByPath($path);
            if ($page && !$page->isError()) {
                continue;
            }

            $singlePage = Single::add($path, $pkg);
            $singlePage->update([
                'cName' => $name,
            ]);
        }
    }
}
