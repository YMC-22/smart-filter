<?php
	defined( 'ABSPATH' ) or exit;
?>


<div id="search-layout" class="search-layout">

    <form class="search-form">

        <div class="form-inner">

            <div class="component-input">
                <input id="field-search" class="search-form__input field-search" type="text" name="search" autocomplete="off" value="" placeholder="<?php esc_attr_e($ymc_search_placeholder,'ymc-smart-filter'); ?>">
                <ul id="results"></ul>
                <span class="clear"><i class="fas fa-times"></i></span>
            </div>

            <button class="search-form__submit btn-submit">
                <?php esc_html_e($ymc_search_text_button, 'ymc-smart-filter'); ?>
            </button>

        </div>

    </form>

</div>








