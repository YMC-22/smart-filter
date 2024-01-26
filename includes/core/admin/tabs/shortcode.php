<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="header">
	<?php echo esc_html__('Shortcode', 'ymc-smart-filter'); ?>
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

    <div class="form-group">
        <label for="ymc-shortcode" class="form-label">
            <?php echo esc_html__('Shortcode Location','ymc-smart-filter'); ?>
            <span class="information">
            <?php echo esc_html__('List of pages and posts where the current shortcode is installed','ymc-smart-filter'); ?>
            </span>
        </label>

        <?php
            $posts_array = get_posts([
                'posts_per_page' => -1,
                'post_status'    => 'any',
                'post_type'      => 'any',
                'orderby'        => 'title',
                'order'          => 'ASC',
            ]);

            if( !empty($posts_array) ) :

                $placeholderText = false;

                echo '<ul class="list-pages">';

                foreach( $posts_array as $post_single ) :

                    if( $this->ymc_is_shortcode($post_single->post_content, $post->ID) ) {

                        echo '<li><a href="' . get_the_permalink( $post_single->ID ) . '"  target="_blank">' . $post_single->post_title . '</a></li>';

                        $placeholderText = true;
                    }

                endforeach;

                 if( !$placeholderText )  {

                     echo __('<li style="color: #b32d2e;">Shortcode is not used anywhere</li>','ymc-smart-filter');
                 }

                echo '</ul>';

            endif;
        ?>

    </div>

</div>

