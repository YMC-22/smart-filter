<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="header">
	<?php echo esc_html__('Shortcode', 'ymc-smart-filter'); ?>
</div>

<div class="content">

    <header class="sub-header" data-class-name="shortcode-grid-posts">
        <i class="dashicons dashicons-shortcode"></i>
		<?php echo esc_html__('Shortcode Grid Posts', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper shortcode-grid-posts">

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

    <header class="sub-header" data-class-name="shortcode-extra-components">
        <i class="dashicons dashicons-shortcode"></i>
		<?php echo esc_html__('Shortcode Extra Components', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper shortcode-extra-components">

        <div class="form-group">
            <label for="ymc-shortcode" class="form-label">
                <?php echo esc_html__('Shortcode Extra Filter','ymc-smart-filter'); ?>
                <span class="information">
            <?php echo esc_html__('Place shortcode filter posts anywhere on your page to filter posts in a grid.','ymc-smart-filter'); ?>
            </span>
            </label>

            <input type="text" readonly value="[ymc_extra_filter id='<?php echo esc_attr($post->ID); ?>']" onfocus="this.select()" class="random-shortcode">
        </div>

        <div class="form-group">
            <label for="ymc-shortcode" class="form-label">
                <?php echo esc_html__('Shortcode Extra Search','ymc-smart-filter'); ?>
                <span class="information">
            <?php echo esc_html__('Place shortcode search posts anywhere on your page to filter posts in a grid.','ymc-smart-filter'); ?>
            </span>
            </label>

            <input type="text" readonly value="[ymc_extra_search id='<?php echo esc_attr($post->ID); ?>']" onfocus="this.select()" class="random-shortcode">
        </div>

        <div class="form-group">
            <label for="ymc-shortcode" class="form-label">
                <?php echo esc_html__('Shortcode Extra Sort','ymc-smart-filter'); ?>
                <span class="information">
            <?php echo esc_html__('Place shortcode sort posts anywhere on your page to filter posts in a grid.','ymc-smart-filter'); ?>
            </span>
            </label>

            <input type="text" readonly value="[ymc_extra_sort id='<?php echo esc_attr($post->ID); ?>']" onfocus="this.select()" class="random-shortcode">
        </div>

    </div>

    <header class="sub-header" data-class-name="filter-location">
        <i class="dashicons dashicons-location"></i>
		<?php echo esc_html__('Filter Location ', 'ymc-smart-filter'); ?>
        <i class="fas fa-chevron-down form-arrow"></i>
    </header>

    <div class="form-wrapper filter-location">

        <div class="form-group">
            <label for="ymc-shortcode" class="form-label">
                <?php echo esc_html__('Shortcode Location','ymc-smart-filter'); ?>
                <span class="information">
            <?php echo esc_html__('List of pages or posts where the current shortcode is installed. 
             Post types are (publicly_queryable) public or not are also will displayed here.','ymc-smart-filter'); ?>
            </span>
            </label>

            <?php
            $posts_array = get_posts([
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'post_type'      => 'any',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);

            if( !empty($posts_array) ) :

                $is_shortcode = false;

                echo '<ul class="list-pages">';

                foreach( $posts_array as $post_single ) :

                    if( $this->ymc_is_shortcode($post_single->post_content, $post->ID) )
                    {
                        echo '<li></span> <a title="View Post/Page" href="' . get_the_permalink( $post_single->ID ) . '"  target="_blank">' .
                             $post_single->post_title . ' (<i>ID: '.$post_single->ID.'</i>) <span class="dashicons dashicons-visibility"></span></a></li>';

                        $is_shortcode = true;
                    }

                endforeach;

                if( !$is_shortcode )  {

                    echo __('<li style="color: #b32d2e;">Shortcode is not used anywhere</li>','ymc-smart-filter');
                }

                echo '</ul>';

            endif;
            ?>

        </div>

    </div>

</div>
