<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>


<div class="header">
	<?php echo esc_html__('Tools', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header" data-class-name="export-settings">
        <i class="fas fa-file-export"></i>
        <?php echo esc_html__('Export', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper export-settings">

        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Export', 'ymc-smart-filter'); ?>
                <span class="information">
                 <?php echo esc_html__('Export settings to a file in format JSON.', 'ymc-smart-filter');?>
            </span>
            </label>

            <p class="ymc-actions">
                <button type="button" name="action" class="ymc-btn-ei ymc-btn-ei--primary button-export" value="download">
                    <?php echo esc_html__('Export As JSON', 'ymc-smart-filter'); ?>
                </button>
            </p>

        </div>

    </div>

    <header class="sub-header" data-class-name="import-settings">
        <i class="fas fa-upload"></i>
        <?php echo esc_html__('Import', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper import-settings">

        <div class="from-element">
            <label class="form-label">
                <?php echo esc_html__('Import', 'ymc-smart-filter');?>
                <span class="information">
               <?php echo esc_html__('Select a file JSON to import settings.', 'ymc-smart-filter');?>
            </span>
            </label>

            <p class="ymc-actions">
                <input type="file" name="ymc_import_file" id="ymc_import_file" accept="application/json">
            </p>

            <p class="ymc-actions">
                <button type="button" name="action" class="ymc-btn-ei ymc-btn-ei--primary button-import" value="json">
                    <?php echo esc_html__('Import JSON', 'ymc-smart-filter'); ?>
                </button>
            </p>

            <p class="info-uploaded"></p>

        </div>

    </div>

</div>

