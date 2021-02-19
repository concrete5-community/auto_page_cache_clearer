<?php

namespace Concrete\Package\AutoPageCacheClearer\Controller\SinglePage\Dashboard\System\Optimization;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Routing\Redirect;

final class AutoPageCacheClearer extends DashboardPageController
{
    public function view()
    {
        return Redirect::to('/dashboard/system/optimization/auto_page_cache_clearer/search');
    }
}
