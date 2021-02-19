<?php

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Support\Facade\Url;

/** @var \A3020\AutoPageCacheClearer\Entity\Item[] $items */
?>

<div class="ccm-dashboard-header-buttons btn-group">
    <a
        data-placement="bottom"
        class="btn btn-default"
        href="<?php echo $this->action('add') ?>">
        <?php echo t('Add item'); ?>
    </a>
</div>

<?php
if (count($items) === 0) {
    echo '<p>' . t('No items have been added yet.') . '</p>';
    return;
}
?>
<div class="ccm-dashboard-content-inner">
    <table class="table">
        <thead>
            <tr>
                <th><?php echo t('Description'); ?></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?php
        foreach ($items as $item) {
            ?>
            <tr>
                <td>
                    <a href="<?php echo $this->action('edit', $item->getId()); ?>">
                        <?php
                        $description = trim($item->getDescription());

                        echo $description ? h($description) : '<span class="text-muted">' . t('Not provided'). '</span>';
                        ?>
                    </a>
                </td>
                <td>
                    <a class="btn btn-xs btn-default" href="<?php echo $this->action('edit', $item->getId()); ?>"><?php echo t('Edit'); ?></a>
                </td>
            </tr>
            <?php
        }
        ?>

    </table>
</div>
