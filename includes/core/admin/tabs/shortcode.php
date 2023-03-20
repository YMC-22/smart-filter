<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>


<div class="header">
	<?php echo esc_html__('Shortcode Options', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <div class="form-group">
        <label for="ymc-shortcode" class="form-label">
			<?php echo esc_html__('Shortcode For Page / Post','ymc-smart-filter'); ?>
            <span class="information">
            <?php echo esc_html__('Directly paste this shortcode in your page','ymc-smart-filter'); ?>
            </span>
        </label>

        <input type="text" readonly value="[ymc_filter id='<?php echo esc_attr($post->ID); ?>']" onfocus="this.select()" class="random-shortcode">
    </div>

    <div class="form-group">
        <label for="ymc-shortcode" class="form-label">
			<?php echo esc_html__('Shortcode For Page Template','ymc-smart-filter'); ?>
            <span class="information">
            <?php echo esc_html__('Directly paste this shortcode in your page template','ymc-smart-filter'); ?>
            </span>
        </label>

		<?php $sh_code = "&lt;?php echo do_shortcode('[ymc_filter id=&quot;". esc_attr($post->ID) ."&quot;]'); ?&gt;"; ?>
        <input type="text" readonly value="<?php echo esc_attr($sh_code); ?>" onfocus="this.select()" class="random-shortcode">
    </div>

</div>

