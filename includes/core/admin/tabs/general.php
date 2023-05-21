<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$cpost_types = $variable->display_cpt(['attachment', 'popup', 'product']);
$output      = $variable->output;
$cpt         = $variable->get_cpt( $post->ID );
$tax         = $variable->tax;
$tax_sel     = $variable->get_tax_sel( $post->ID );
$terms_sel   = $variable->get_terms_sel( $post->ID );
$tax_rel     = $variable->get_tax_rel( $post->ID );
$tax_sort    = $variable->get_tax_sort( $post->ID );
$term_sort   = $variable->get_term_sort( $post->ID );
$ymc_sort_terms  = $variable->get_sort_terms( $post->ID );
$ymc_choices_posts  = $variable->get_choices_posts( $post->ID );
$ymc_exclude_posts  = $variable->get_exclude_posts( $post->ID );
$ymc_terms_icons  = $variable->get_terms_icons( $post->ID );
$ymc_terms_align   = $variable->get_terms_align( $post->ID );

?>


<div class="header">
	<?php echo esc_html__('General Options', 'ymc-smart-filter'); ?>
</div>

<div class="content">

<div class="form-group wrapper-cpt">

	<label for="ymc-cpt-select" class="form-label">
		<?php echo esc_html__('Custom Post Type','ymc-smart-filter'); ?>
		<span class="information">
        <?php echo esc_html__('Select post type.','ymc-smart-filter'); ?>
        </span>
	</label>

	<select class="form-select" id="ymc-cpt-select" name="ymc-cpt-select" data-postid="<?php echo esc_attr($post->ID); ?>">
		<option value="post"><?php echo esc_html__('Post','ymc-smart-filter'); ?></option>
		<?php
            foreach( $cpost_types as $cpost_type ) {
                if( $cpt === $cpost_type ) {
                    $sel = 'selected';
                } else {
                    $sel = '';
                }
                echo "<option value='" . esc_attr($cpost_type) ."' ". esc_attr($sel) .">" . esc_html($cpost_type) . "</option>";
            }
		?>
	</select>

</div>

<hr/>

<div class="form-group wrapper-taxonomy">

	<label for="ymc-tax-checkboxes" class="form-label">
		<?php echo esc_html__('Taxonomy','ymc-smart-filter'); ?>
		<span class="information">
        <?php echo esc_html__('Select taxonomy. Sortable with Drag & Drop feature.','ymc-smart-filter'); ?>
        </span>
	</label>

    <div id="ymc-tax-checkboxes" class="ymc-tax-checkboxes" data-postid="<?php echo esc_attr($post->ID); ?>">

	<?php

	    $data_object = get_object_taxonomies($cpt, $output = 'objects');
	    $taxo = [];

	    // Exclude Taxonomies WooCommerce
	    $arr_exclude_slugs = ['product_type','product_visibility','product_shipping_class'];

	    foreach ($data_object as $val) {
		    $taxo[$val->label] = $val->name;
	    }

        if( $taxo ) {

            if( !is_null($tax_sort) ) {

                $result_tax = [];
                foreach($tax_sort as $val) {
                    $result_tax[array_search($val, $taxo)] = $val;
                }
            }
            else {
                $result_tax = $taxo;
            }

            foreach($result_tax as $label => $slug) :

                $sl0 = '';

                if(array_search($slug, $arr_exclude_slugs) === false ) {

	                if(is_array($tax_sel) && count($tax_sel) > 0) {

		                if (in_array($slug, $tax_sel)) {
			                $sl0 = 'checked';
		                }
		                else{
			                $sl0 ='';
		                }
	                }

	                echo '<div id="'. esc_attr($slug) .'" class="group-elements">
                    <input id="id-'. esc_attr($slug) .'" type="checkbox" name="ymc-taxonomy[]" value="'. esc_attr($slug) .'" '. esc_attr($sl0) .'>
                    <label for="id-'. esc_attr($slug) .'">'.  esc_html($label) . '</label></div>';
                }

            endforeach;

            unset($result_tax);
        }
        else {
          echo '<span class="notice">'. esc_html__('No data for Post Type / Taxonomy', 'ymc-smart-filter') .'</span>';
        }
	?>

    </div>

</div>

<hr/>

<div class="form-group wrapper-terms <?php echo empty($tax_sel) ? 'hidden' : ''; ?>">

	<label for="ymc-terms" class="form-label">
		<?php echo esc_html__('Terms','ymc-smart-filter'); ?>
		<span class="information"><?php echo esc_html__('Select terms. Sortable with Drag and Drop feature. Set the Sort Filter Terms option to Manual sort in the Appearance section.','ymc-smart-filter'); ?></span>
	</label>

	<div class="category-list" id="ymc-terms" data-postid="<?php echo esc_attr($post->ID); ?>">

		<?php

        if( is_array($tax_sel) && count($tax_sel) > 0 ) {

            foreach ( $tax_sel as $tax ) :

	            $terms = get_terms([
		            'taxonomy' => $tax,
		            'hide_empty' => false,
	            ]);

	            if( $terms ) {

					$terms_icons = '';

		            if( !is_null($term_sort) && $ymc_sort_terms === 'manual' ) {
			            $res_terms = [];
			            foreach( $terms as $term ) {
				            $key = array_search($term->term_id, $term_sort);
				            $res_terms[$key] = $term;
			            }
			            ksort($res_terms);
		            }
					else {
						$res_terms = $terms;
					}

                    echo '<article class="group-term item-'. esc_attr($tax) .'">';

                    echo '<div class="item-inner all-categories">
                          <input name="all-select" class="category-all" id="category-all-'.esc_attr($tax).'" type="checkbox">
                          <label for="category-all-'.esc_attr($tax).'" class="category-all-label">'. esc_html__('All [ '. get_taxonomy( $tax )->label .']', 'ymc-smart-filter') .'</label>                                                    
                          </div>';

					echo '<div class="entry-terms">';

		            foreach( $res_terms as $term ) :

			            $sl1 = '';

			            if(is_array($terms_sel) && count($terms_sel) > 0) {

                            if (in_array($term->term_id, $terms_sel)) {
                                $sl1 = 'checked';
                            }
                            else{ $sl1 = ''; }
			            }

			            // Choose icons
						if( !empty($ymc_terms_icons) ) {
							foreach ( $ymc_terms_icons as $key => $val ) {
								if( $term->term_id === (int) $key ) {
									$terms_icons = '<i class="'. $val .'"></i><input name="ymc-terms-icons['. $key .']" type="hidden" value="'. $val .'">';
									break;
								}
							}
						}

			            // Set align icons
			            if( !empty($ymc_terms_align) ) {

				            $flag_terms_align = false;

				            foreach ( $ymc_terms_align as $sub_terms_align ) {

					            foreach ( $sub_terms_align as $key => $val) {

						            if ( $key === 'termid' && $term->term_id === (int) $val ) {
							            $flag_terms_align = true;
						            }
						            if ( $key === 'alignterm' ) {
							            $class_terms_align = $val;
						            }
					            }

					            if( $flag_terms_align ) {
						            break;
					            }
				            }
			            }

			            $class_terms_align = ( !empty($class_terms_align) ) ? $class_terms_align : 'left-icon';

			            echo '<div class="item-inner" data-termid="'. $term->term_id .'" data-alignterm="'. $class_terms_align .'">
                              <input name="ymc-terms[]" class="category-list" id="category-id-'. esc_attr($term->term_id) .'" type="checkbox" value="'. esc_attr($term->term_id) .'" '. esc_attr($sl1) .'>';
			            echo '<label for="category-id-'. esc_attr($term->term_id) .'" class="category-list-label">' . esc_html($term->name) . '</label>						  						  
							  <i class="far fa-cog choice-icon" title="Setting term"></i><span class="indicator-icon">'. $terms_icons .'</span></div>';

			            $terms_icons = '';

                    endforeach;

		            $res_terms = null;

		            echo '</div>';

                   echo '</article>';
	            }

            endforeach;
        }

        ?>

	</div>

</div>

<hr/>

<div class="form-group wrapper-selection">

	<label class="form-label">
		<?php echo esc_html__('Exclude Posts', 'ymc-smart-filter'); ?>
		<span class="information">
        <?php echo esc_html__('Check to exclude the selected posts from the grid. Works on selected posts.', 'ymc-smart-filter');?>
        </span>
	</label>

	<div class="group-elements">
		<?php  $check_exclude_posts = ( $ymc_exclude_posts === 'on' ) ? 'checked' : '';  ?>
		<input type="hidden" name='ymc-exclude-posts' value="off">
		<input class="ymc-exclude-posts" type="checkbox" value="on" name="ymc-exclude-posts" id="ymc-exclude-posts" <?php echo esc_attr($check_exclude_posts); ?>>
		<label for="ymc-exclude-posts"><?php echo esc_html__('Enable', 'ymc-smart-filter'); ?></label>
	</div>

	<hr/>

	<label class="form-label">
		<?php echo esc_html__('Select Posts', 'ymc-smart-filter'); ?>
		<span class="information">
        <?php echo esc_html__('Include / Exclude posts in the post grid on the frontend. To exclude posts, check option "Exclude posts". By default, posts are included in the grid.', 'ymc-smart-filter');?>
        </span>
	</label>

	<div class="selection-posts" id="selection-posts">

		<div class="choices">
			<ul class="list choices-list">
			<?php

				$tmp_post = $post;

				$query = new \WP_query([
					'post_type' => $cpt,
					'orderby' => 'title',
					'order' => 'ASC',
					'posts_per_page' => -1
				]);

				if ( $query->have_posts() ) {

					$class_disabled = '';

					while ($query->have_posts()) : $query->the_post();
						if( is_array($ymc_choices_posts) &&  array_search(get_the_ID(), $ymc_choices_posts) !== false) {
							$class_disabled = 'disabled';
						}
						echo '<li><span class="ymc-rel-item ymc-rel-item-add '.$class_disabled.'" data-id="'.get_the_ID().'">'.get_the_title(get_the_ID()).'</span></li>';
						$class_disabled = null;
					endwhile;

					wp_reset_postdata();
				}
				else {
					echo '<li class="notice">No posts</li>';
				}
			?>
			</ul>
		</div>

		<div class="values">

			<?php $class_choices = ( $ymc_exclude_posts === 'on' ) ? 'exclude-posts' : 'include-posts'; ?>

			<ul class="list values-list <?php echo $class_choices; ?>">
			<?php

				if( is_array($ymc_choices_posts) ) :

					$query = new \WP_query([
						'post_type' => $cpt,
						'orderby' => 'title',
						'order' => 'ASC',
						'post__in'  => $ymc_choices_posts,
						'posts_per_page' => -1
					]);

					while ($query->have_posts()) : $query->the_post();

						echo '<li><input type="hidden" name="ymc-choices-posts[]" value="'.get_the_ID().'">
							  <span  class="ymc-rel-item" data-id="'.get_the_ID().'">'.get_the_title(get_the_ID()).'
							  <a href="#" class="ymc-icon-minus remove_item"></a></span></li>';

					endwhile;

					wp_reset_postdata();

				endif;

				$post = $tmp_post;
			?>
			</ul>
		</div>

	</div>

</div>

<hr/>

<div class="form-group wrapper-relation">

    <label for="ymc-terms" class="form-label">
		<?php echo esc_html__('Taxonomy Relation','ymc-smart-filter'); ?>
        <span class="information"><?php echo esc_html__('Select taxonomy relation','ymc-smart-filter'); ?></span>
    </label>

    <select class="form-select" id="ymc-tax-relation" name="ymc-tax-relation">
		<?php
            $tax_relations = array('AND', 'OR');
            foreach($tax_relations as $tax_val) {
                if($tax_rel === $tax_val) {
                    $sel_rel = 'selected';
                } else {
                    $sel_rel = '';
                }
                echo "<option value='". esc_attr($tax_val) ."' ". esc_attr($sel_rel) .">" . esc_html($tax_val) . "</option>";
            }
		?>
    </select>

</div>

</div>

