<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$cpost_types = $variable->display_cpt(['attachment', 'popup']);
$output      = $variable->output;
$cpt         = explode(',', $ymc_cpt_value);
$tax         = $variable->tax;
$tax_sel     = $tax_selected;
$terms_sel   = $terms_selected;

?>


<div class="header">
	<?php echo esc_html__('General', 'ymc-smart-filter'); ?>
</div>

<div class="content">

	<header class="sub-header" data-class-name="query-settings">
		<i class="fas fa-sliders-h"></i>
		<?php echo esc_html__('Query Options', 'ymc-smart-filter'); ?>
		<i class="fas fa-chevron-down form-arrow"></i>
	</header>

	<div class="form-wrapper query-settings">

		<div class="form-group wrapper-cpt">

			<label for="ymc-cpt-select" class="form-label">
				<?php echo esc_html__('Post Types','ymc-smart-filter'); ?>
				<span class="information" style="margin-bottom: 10px;">
        <?php echo esc_html__('Select one ore more posts. To select multiple posts, hold down the key Ctrl.
                                   For a more complete display of posts in the grid, set the "Taxonomy Relation" option to OR.','ymc-smart-filter'); ?>
        </span>
			</label>

			<select class="form-select" multiple id="ymc-cpt-select" name="ymc-cpt-select[]" data-postid="<?php echo esc_attr($post->ID); ?>">
			<?php
				foreach( $cpost_types as $cpost_type ) {

					$sel = ( array_search($cpost_type, $cpt) !== false ) ? 'selected' : '';

					echo "<option value='" . esc_attr($cpost_type) ."' ". esc_attr($sel) .">" . esc_html( str_replace(['-','_'],' ', $cpost_type) ) . "</option>";
				}
			?>
			</select>

		</div>

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

				foreach ( $data_object as $val ) {
					$taxo[$val->label] = $val->name;
				}

				if( $taxo ) {

					if( !is_null($tax_sort) && is_array($tax_sort) ) {

						$result_tax = [];
						foreach($tax_sort as $val) {
							$result_tax[array_search($val, $taxo)] = $val;
						}
					}
					else {
						$result_tax = $taxo;
					}

					foreach( $result_tax as $label => $slug ) {

						$sl0 = '';

						if( array_search($slug, $arr_exclude_slugs) === false ) {

							if( is_array($tax_sel) && count($tax_sel) > 0 ) {

								if (in_array($slug, $tax_sel)) {
									$sl0 = 'checked';
								}
								else{
									$sl0 = '';
								}
							}

							echo '<div id="'. esc_attr($slug) .'" class="group-elements">
                            <input id="id-'. esc_attr($slug) .'" type="checkbox" name="ymc-taxonomy[]" value="'. esc_attr($slug) .'" '. esc_attr($sl0) .'>
                            <label for="id-'. esc_attr($slug) .'">'.  esc_html($label) . '</label></div>';
						}
					}

					unset($result_tax);
				}
				else {
					echo '<span class="notice">'. esc_html__('No data for taxonomies', 'ymc-smart-filter') .'</span>';
				}
			?>
			</div>
			<span class="ymc-btn-reload tax-reload" title="Update taxonomies. The current texonomies and terms settings will be reset."><i class="fas fa-redo"></i></span>

		</div>

		<div class="form-group wrapper-terms <?php echo empty($tax_sel) ? 'hidden' : ''; ?>">

			<label for="ymc-terms" class="form-label">
				<?php echo esc_html__('Terms','ymc-smart-filter'); ?>
				<span class="information"><?php echo esc_html__('Select terms. Sortable with Drag and Drop feature. Set the Sort Filter Terms option to Manual sort in the Appearance section.','ymc-smart-filter'); ?></span>
			</label>

			<div class="category-list" id="ymc-terms" data-postid="<?php echo esc_attr($post->ID); ?>">

				<?php
				if( is_array($cpt) ) {

					$is_cpt = true;

					foreach ($cpt as $pt) {
						if( !in_array($pt, $cpost_types) ) {
							$is_cpt = false;
						}
					}

					if( $is_cpt ) {
						if( is_array($tax_sel) && count($tax_sel) > 0 ) {

							foreach ( $tax_sel as $tax ) :

								$terms = get_terms([
									'taxonomy' => $tax,
									'hide_empty' => false,
								]);

								if( is_array($terms) )
								{

									// Variables: Options Term
									$bg_term          = '';
									$color_term       = '';
									$class_term       = '';
									$default_term     = '';
									$name_term        = '';

									// Variables: Options Icon
									$color_icon   = '';
									$class_icon   = '';

									// Variables: Set Selected Icon
									$terms_icons  = '';

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

										// Set Options Icon
										if( !empty($ymc_terms_align) ) {

											$flag_terms_align = false;

											foreach ( $ymc_terms_align as $sub_terms_align ) {

												foreach ( $sub_terms_align as $key => $val) {

													if ( $key === 'termid' && $term->term_id === (int) $val ) {
														$flag_terms_align = true;
													}
													if ( $key === 'alignterm' && $flag_terms_align ) {
														$class_terms_align = $val;
													}
													if ( $key === 'coloricon' && $flag_terms_align ) {
														$color_icon = $val;
													}
													if ( $key === 'classicon' && $flag_terms_align ) {
														$class_icon = $val;
													}
												}

												if( $flag_terms_align ) {break;}
											}
										}

										// Set Options Term
										if( !empty($ymc_terms_options) ) {

											$flag_terms_option = false;

											foreach ( $ymc_terms_options as $terms_opt ) {

												foreach ( $terms_opt as $key => $val) {

													if ( $key === 'termid' && $term->term_id === (int) $val ) {
														$flag_terms_option = true;
													}
													if ( $key === 'bg' && $flag_terms_option ) {
														$bg_term = $val;
													}
													if ( $key === 'color' && $flag_terms_option ) {
														$color_term =  $val;
													}
													if ( $key === 'class' && $flag_terms_option ) {
														$class_term = $val;
													}
													if ( $key === 'default' && $flag_terms_option ) {
														$default_term = $val;
													}
													if ( $key === 'name' && $flag_terms_option ) {
														$name_term = $val;
													}
												}

												if( $flag_terms_option ) {break;}
											}
										}

										// Set Selected Icon
										if( !empty($ymc_terms_icons) ) {
											foreach ( $ymc_terms_icons as $key => $val ) {
												if( $term->term_id === (int) $key ) {
													$style_color_icon = ( !empty($color_icon) ) ? 'style="color: '.$color_icon.'"' : '';
													$terms_icons = '<i class="'. $val .'" '. $style_color_icon .'"></i><input name="ymc-terms-icons['. $key .']" type="hidden" value="'. $val .'">';
													break;
												}
											}
										}

										$class_terms_align = ( !empty($class_terms_align ) ) ? $class_terms_align : 'left-icon';

										$style_bg_term = ( !empty($bg_term) ) ? 'background-color:'.$bg_term.';' : '';
										$style_color_term = ( !empty($color_term) ) ? 'color:'.$color_term.';' : '';
										$name_term = ( !empty($name_term) ) ? $name_term : $term->name;


										echo '<div class="item-inner" style="'. esc_attr($style_bg_term) . esc_attr($style_color_term) .'" 
			                  data-termid="'. esc_attr($term->term_id) .'" 
			                  data-alignterm="'. esc_attr($class_terms_align) .'" 
			                  data-bg-term="'. esc_attr($bg_term) .'" 
			                  data-color-term="'. esc_attr($color_term) .'" 
			                  data-custom-class="'. esc_attr($class_term) .'" 
			                  data-color-icon="'. esc_attr($color_icon) .'"
			                  data-class-icon="'. esc_attr($class_icon) .'"
			                  data-status-term="'. esc_attr($sl1) .'"  
			                  data-name-term="'. esc_attr($name_term) .'"  
			                  data-default-term="'. esc_attr($default_term) .'">
                              <input name="ymc-terms[]" class="category-list" id="category-id-'. esc_attr($term->term_id) .'" type="checkbox" value="'. esc_attr($term->term_id) .'" '. esc_attr($sl1) .'>';

										echo '<label for="category-id-'. esc_attr($term->term_id) .'" class="category-list-label">
							  <span class="name-term">' . esc_html($name_term) .'</span>'. ' ('. esc_attr($term->count) .')</label>						  						  
							  <i class="far fa-cog choice-icon" title="Setting Term"></i><span class="indicator-icon">'. $terms_icons .'</span></div>';


										$terms_icons = '';
										$class_icon = '';
										$name_term = '';

									endforeach;

									$res_terms = null;

									echo '</div>';

									echo '</article>';
								}

							endforeach;
						}
					}
				}
				else {
					echo '<span class="notice">'. esc_html__('No data for terms', 'ymc-smart-filter') .'</span>';
				}
				?>

			</div>

		</div>

		<div class="form-group wrapper-selection">

			<?php if( $is_cpt ) : ?>

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

				<br/>

				<label class="form-label">
					<?php echo esc_html__('Add posts', 'ymc-smart-filter'); ?>
					<span class="information">
        <?php echo esc_html__('Include / Exclude posts in the post grid on the frontend. To exclude posts, check option "Exclude posts". By default, posts are included in the grid. Drag and Drop posts for custom sorting', 'ymc-smart-filter');?>
        </span>
				</label>

				<div class="search-posts">
					<input class="input-field" type="search" placeholder="Search..." />
				</div>

				<div class="selection-posts" id="selection-posts">

					<div class="choices">
						<ul class="list choices-list">
							<?php

							$tmp_post = $post;

							$arg = [
								'post_type' => $cpt,
								'orderby' => 'title',
								'order' => 'ASC',
								'posts_per_page' => -1
							];

							if( is_array($tax_sel) && count($tax_sel) > 0 && !empty($terms_sel) ) {

								$params_choices = [
									'relation' => 'OR'
								];

								foreach ( $tax_sel as $tax ) :

									$terms = get_terms([
										'taxonomy' => $tax,
										'hide_empty' => false
									]);

									if( $terms ) {

										$arr_terms_ids = [];

										foreach( $terms as $term ) :

											if( in_array($term->term_id, $terms_sel) ) {
												array_push($arr_terms_ids, $term->term_id);
											}

										endforeach;

										$params_choices[] = [
											'taxonomy' => $tax,
											'field'    => 'id',
											'terms'    => $arr_terms_ids
										];

										$arr_terms_ids = null;
									}

								endforeach;

								$arg['tax_query'] = $params_choices;
							}

							$query = new \WP_query($arg);

							if ( $query->have_posts() ) {

								$class_disabled = '';

								while ($query->have_posts()) : $query->the_post();
									if( is_array($ymc_choices_posts) &&  array_search(get_the_ID(), $ymc_choices_posts) !== false) {
										$class_disabled = 'disabled';
									}
									echo '<li><span class="ymc-rel-item ymc-rel-item-add '.$class_disabled.'" data-id="'.get_the_ID().'">ID: '.get_the_ID().'<br>'.get_the_title(get_the_ID()).'</span></li>';
									$class_disabled = null;
								endwhile;

							}
							else {
								echo '<li class="notice">'.esc_html__('No posts', 'ymc-smart-filter').'</li>';
							}
							?>
						</ul>
						<?php
						echo '<span class="number-posts">'. $query->found_posts .'</span>';
						wp_reset_postdata();
						?>
					</div>

					<div class="values">

						<?php $class_choices = ( $ymc_exclude_posts === 'on' ) ? 'exclude-posts' : 'include-posts'; ?>

						<ul class="list values-list <?php echo $class_choices; ?>">
							<?php

							if( is_array($ymc_choices_posts) ) :

								$query = new \WP_query([
									'post_type' => $cpt,
									'orderby' => 'post__in',
									'post__in'  => $ymc_choices_posts,
									'posts_per_page' => -1
								]);

								while ($query->have_posts()) : $query->the_post();

									echo '<li><input type="hidden" name="ymc-choices-posts[]" value="'.get_the_ID().'">
							  <span  class="ymc-rel-item" data-id="'.get_the_ID().'">ID: '.get_the_ID().'<br>'.get_the_title(get_the_ID()).'
							  <a href="#" class="ymc-icon-minus remove_item"></a></span></li>';
								endwhile;

								echo '<span class="number-selected-posts">'. $query->found_posts .'</span>';

							else :

								echo '<span class="number-selected-posts">0</span>';

							endif;

							$post = $tmp_post;
							?>
						</ul>
						<?php wp_reset_postdata(); ?>
					</div>

				</div>

			<?php endif; ?>

		</div>

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

</div>

