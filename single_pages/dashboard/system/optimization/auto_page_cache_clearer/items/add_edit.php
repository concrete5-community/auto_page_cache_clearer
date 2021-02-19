<?php
defined('C5_EXECUTE') or die('Access Denied.');

/** @var \A3020\AutoPageCacheClearer\Entity\Item $item */
/** @var array $pageTypeOptions */
?>

<div class="ccm-dashboard-header-buttons btn-group">
    <?php
    if ($item->exists()) {
        ?>
        <a class="btn btn-danger" href="<?php echo $this->action('delete', $item->getId()); ?>">
            <?php echo t('Delete'); ?>
        </a>
        <?php
    }
    ?>
</div>

<div class="ccm-dashboard-content-inner">
    <form method="post" action="<?php echo $this->action('save'); ?>">
        <?php
        /** @var \Concrete\Core\Validation\CSRF\Token $token */
        echo $token->output('a3020.auto_page_cache_clearer.item');

        echo $form->hidden('id', $item->getId());
        ?>

        <div class="form-group">
            <?php echo $form->label('description', t('Description')); ?>
            <?php echo $form->text('description', $item->getDescription(), [
                'placeholder' => t('Optional'),
            ]); ?>
        </div>

        <div>
            <h3><?php echo t('When one of these pages change:'); ?></h3><br>

            <div class="form-group">
                <?php echo $form->label('source_pages', t('Pages with ID')); ?>
                <?php echo $form->text('source_pages', implode(', ', $item->getSourcePages()), [
                    'placeholder' => t('Optional'),
                ]); ?>
                <small class="help-block"><?php echo t('Separate multiple pages with a comma, if needed.'); ?></small>
            </div>

            <div class="form-group">
                <?php echo $form->label('source_page_types', t('And pages with page type')); ?>
                <div style="width: 100%">
                    <?php
                    echo $form->selectMultiple('source_page_types', $pageTypeOptions, $item->getSourcePageTypes(), [
                        'style' => 'width: 100%',
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <h3><?php echo t('Automatically flush the cache for:'); ?></h3><br>

            <div class="form-group">
                <?php echo $form->label('target_pages', t('Pages with ID')); ?>
                <?php echo $form->text('target_pages', implode(', ', $item->getTargetPages()), [
                    'placeholder' => t('Optional'),
                ]); ?>
                <small class="help-block"><?php echo t('Separate multiple pages with a comma, if needed.'); ?></small>
            </div>

            <div class="form-group">
                <?php echo $form->label('target_page_types', t('And pages with page type')); ?>
                <div style="width: 100%">
                    <?php
                    echo $form->selectMultiple('target_page_types', $pageTypeOptions, $item->getTargetPageTypes(), [
                        'style' => 'width: 100%',
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a class="btn btn-default" href="<?php echo $this->action(''); ?>">
                    <?php echo t('Cancel') ?>
                </a>

                <div class="pull-right">
                    <button class="btn btn-primary" name="save" type="submit">
                        <?php echo t('Save') ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
	$(function() {
		$('#source_page_types, #target_page_types').removeClass('form-control').select2();
	});
</script>
