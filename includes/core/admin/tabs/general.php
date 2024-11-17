<?php if ( ! defined( 'ABSPATH' ) ) exit;

// Set variables
$cpost_types = $variable->display_cpt(['attachment', 'popup']);
$output      = $variable->output;
$cpt         = explode(',', $ymc_cpt_value);
$tax         = $variable->tax;
$tax_sel     = $tax_selected;
$terms_sel   = $terms_selected;
$ymc_hierarchy_terms = (bool) $ymc_hierarchy_terms;

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
				<?php echo esc_html__('Post Type(s)','ymc-smart-filter'); ?>
				<span class="information" style="margin-bottom: 10px;">
        <?php echo esc_html__('Select one ore more posts. To select multiple posts, hold down the key Ctrl.
                                   For a more complete display of posts in the grid, set the "Taxonomy Relation" option to OR.','ymc-smart-filter'); ?>
        </span>
			</label>

			<select class="form-select" multiple id="ymc-cpt-select" name="ymc-cpt-select[]" data-postid="<?php echo esc_attr($post->ID); ?>"
			        data-previous-value="<?php echo esc_attr(implode(',',$cpt)); ?>">
			<?php
				foreach( $cpost_types as $cpost_type ) {

					$sel = ( array_search($cpost_type, $cpt) !== false ) ? 'selected' : '';

					echo "<option value='" . esc_attr($cpost_type) ."' ". esc_attr($sel) .">" . esc_html( get_post_type_object( $cpost_type )->label ) . "</option>";
				}
			?>
			</select>

		</div>

		<div class="form-group wrapper-taxonomy">

			<div class="multi-buttons">
				<span class="ymc-btn-reload tax-reload" title="<?php esc_attr_e('Update taxonomy(s).','ymc-smart-filter'); ?>"><i class="fas fa-redo"></i></span>
				<span class="ymc-btn-delete tax-delete" title="<?php esc_attr_e('Delete taxonomy(s).','ymc-smart-filter'); ?>"><i class="far fa-trash-alt"></i></span>
			</div>

			<label for="ymc-tax-checkboxes" class="form-label">
				<?php echo esc_html__('Taxonomy(s)','ymc-smart-filter'); ?>
				<span class="information">
                <?php echo esc_html__('Select taxonomy. Sortable with Drag & Drop feature.','ymc-smart-filter'); ?>
                </span>
			</label>

			<div id="ymc-tax-checkboxes" class="ymc-tax-checkboxes" data-postid="<?php echo esc_attr($post->ID); ?>">
			<?php
				$data_object = get_object_taxonomies($cpt, $output = 'objects');
				$taxo = [];

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

						if( is_array($tax_sel) && count($tax_sel) > 0 ) {

							if (in_array($slug, $tax_sel)) {
								$sl0 = 'checked';
							}
							else{
								$sl0 = '';
							}
						}

						echo '<div id="'. esc_attr($slug) .'" class="group-elements">
						<i class="fas fa-grip-vertical handle"></i>
                        <input id="id-'. esc_attr($slug) .'" type="checkbox" name="ymc-taxonomy[]" value="'. esc_attr($slug) .'" '. esc_attr($sl0) .'>
                        <label for="id-'. esc_attr($slug) .'">'.  esc_html($label) . '</label></div>';

					}

					unset($result_tax);
				}
				else {
					echo '<span class="notice">'. esc_html__('No data for taxonomies', 'ymc-smart-filter') .'</span>';
				}
			?>
			</div>

		</div>

		<div class="form-group wrapper-terms <?php echo empty($tax_sel) ? 'hidden' : ''; ?>">

			<label for="ymc-terms" class="form-label">
				<?php echo esc_html__('Term(s)','ymc-smart-filter'); ?>
				<span class="information"><?php echo __('Select terms. Sortable with Drag and Drop feature. 
			    Set the Sorting terms option to Manual Sort in the Appearance - Filter Settings.','ymc-smart-filter'); ?></span>
			</label>

			<div class="info-panel">
				<span class="info-panel__text">
					<?php echo esc_html__('Post Type:','ymc-smart-filter'); ?>
					<i>
					<?php
						if( is_array($cpt) ) {
							$cpt_list = '';
							foreach ( $cpt as $value ) {
								$cpt_list .= get_post_type_object( $value )->label.', ';
							}
							echo rtrim($cpt_list,', ');
						}
					?>
					</i>
				</span>
				<span class="info-panel__text">
					<?php echo esc_html__('Layout:','ymc-smart-filter'); ?>
					<i><?php
						$arrayFilterLayouts = \YMC_Smart_Filters\Plugin::instance()->filters->ymc_filter_layouts($ymc_filter_layout);
						if ( array_key_exists($ymc_filter_layout, $arrayFilterLayouts) ) {
							echo $arrayFilterLayouts[$ymc_filter_layout];
						} ?>
					</i>
				</span>
				<span class="info-panel__text">
					<?php echo esc_html__('Type:','ymc-smart-filter'); ?>
					<i><?php echo ( $ymc_hierarchy_terms ) ? esc_html('Hierarchy') : esc_html('List'); ?></i>
				</span>
				<span class="info-panel__text">
					<?php echo esc_html__('Multiple Taxonomy:','ymc-smart-filter'); ?>
					<i><?php echo ( (bool) $ymc_multiple_filter ) ? esc_html('Enabled') : esc_html('Disabled'); ?></i>
				</span>
				<span class="info-panel__text">
					<?php echo esc_html__('Sorting:','ymc-smart-filter'); ?>
					<i><?php echo esc_html($ymc_sort_terms); ?></i>
				</span>
			</div>

			<div class="category-list <?php echo ( $ymc_hierarchy_terms ) ? esc_html('hierarchy') : esc_html('list'); ?>" id="ymc-terms" data-postid="<?php echo esc_attr($post->ID); ?>">

			<?php
				if( is_array($cpt) ) {

					$is_cpt = true;

					foreach ($cpt as $pt) {
						if( !in_array($pt, $cpost_types) ) {
							$is_cpt = false;
						}
					}

					if( $is_cpt )
					{
						if( is_array($tax_sel) && count($tax_sel) > 0 )
						{
							foreach ( $tax_sel as $tax ) :

								$argsTerms = [
									'taxonomy' => $tax,
									'hide_empty' => false
								];

								// Set Sort Terms
							    $order_terms = ( $ymc_sort_terms === 'desc' && $ymc_sort_terms !== 'manual' ) ? 'desc' : 'asc';
								$argsTerms['order'] = $order_terms;

								// Set parent for terms (Hierarchy Terms Tree)
								( $ymc_hierarchy_terms ) ? $argsTerms['parent'] = 0 : '';

								$terms = get_terms($argsTerms);

								if( is_array( $terms ) && ! is_wp_error( $terms ) )
								{

									// Options Taxonomy
									$tacBg = '';
									$taxColor = '';
									$taxName = '';

									if( !empty($ymc_taxonomy_options) )
									{
										$taxonomyStylesArray = taxonomyStylesConfig($tax, $ymc_taxonomy_options);

										if( !empty($taxonomyStylesArray) )
										{
											$tacBg = $taxonomyStylesArray['bg'];
											$taxColor = $taxonomyStylesArray['color'];
											$taxName = $taxonomyStylesArray['name'];
										}
									}

									$style_tax_bg = !empty( $tacBg ) ? 'background-color:'.$tacBg.';' : '';
									$style_tax_color = !empty($taxColor) ? 'color:'.$taxColor.';' : '';
									$tax_name = !empty($taxName) ? $taxName : get_taxonomy( $tax )->label;


									// Options Term
									$bg_term = '';
									$color_term = '';
									$class_term = '';
									$default_term = '';
									$name_term  = '';
									$hide_term  = '';

									// Options Icon
									$color_icon   = '';
									$class_icon   = '';

									// Set Selected Icon
									$terms_icons  = '';

									// Manual Sort Terms
									if( is_array($term_sort) && $ymc_sort_terms === 'manual' )
									{
										$temp_array = [];
										$temp_no_exist = [];
										foreach( $terms as $term ) {
											$key = array_search($term->term_id, $term_sort);
											if( $key !== false ) {
												$temp_array[$key] = $term;
											}
											else {
												$temp_no_exist[] = $term;
											}
										}
										if( count($temp_no_exist) > 0 ) {
											foreach ($temp_no_exist as $term) {
												array_push($temp_array, $term);
											}
										}

										ksort($temp_array);
										$terms = $temp_array;
									}

									echo '<article class="group-term item-'. esc_attr($tax) .'">';

									echo '<div class="item-inner all-categories" data-tax-slug="'. esc_attr($tax) .'" data-tax-color="'.esc_attr($taxColor).'" data-tax-bg="'.esc_attr($tacBg).'" data-tax-name="'.esc_attr($tax_name).'" 
									      data-tax-original-name="'. esc_attr(get_taxonomy( $tax )->label) .'" style="'.esc_attr($style_tax_bg) . esc_attr($style_tax_color).'">
			                              <input name="all-select" class="category-all" id="category-all-'.esc_attr($tax).'" type="checkbox">
			                              <label for="category-all-'.esc_attr($tax).'" class="category-all-label">'. esc_html__('All [ '. $tax_name .']', 'ymc-smart-filter') .'</label>                                                    
			                              <i class="far fa-ellipsis-v choice-icon" title="Taxonomy settings"></i>
			                              </div>';

									echo '<div class="entry-terms">';

									foreach( $terms as $term ) :

										$sl1 = '';
										$hierarchy_terms_html = '';

										if( is_array($terms_sel) && count($terms_sel) > 0 )
										{
											if ( in_array($term->term_id, $terms_sel) ) {
												$sl1 = 'checked';
											}
											else{ $sl1 = ''; }
										}

										// Set Options Icon
										if( !empty($ymc_terms_align) )
										{
											$iconStylesArray = iconStylesConfig($term->term_id, $ymc_terms_align);

											if( !empty($iconStylesArray) ) {
												$class_terms_align = $iconStylesArray['class_terms_align'];
												$color_icon = $iconStylesArray['color_icon'];
												$class_icon = $iconStylesArray['class_icon'];
											}
										}

										// Set Options Term
										if( !empty($ymc_terms_options) )
										{
											$termStylesArray = termStylesConfig( $term->term_id, $ymc_terms_options );

											if( !empty($termStylesArray) )
											{
												$bg_term          = $termStylesArray['bg_term'];
												$color_term       = $termStylesArray['color_term'];
												$class_term       = $termStylesArray['class_term'];
												$default_term     = $termStylesArray['default_term'];
												$name_term        = $termStylesArray['name_term'];
												$hide_term        = !empty($termStylesArray['hide_term']) ? $termStylesArray['hide_term'] : '';
											}
										}

										// Set Selected Icon
										if( !empty($ymc_terms_icons) )
										{
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

										// Hierarchy Terms Tree
										if( $ymc_hierarchy_terms )
										{
											$arrayTermsOptions = [
												'style_icon' => $ymc_terms_align,
												'selected_icon' => $ymc_terms_icons,
												'style_term' => $ymc_terms_options,
												'selected_terms' => $terms_sel,
												'order_terms' => $ymc_sort_terms,
												'manual_sort' => $term_sort
											];

											$hierarchy_terms_html = hierarchyTermsOutput($term->term_id, $tax, 0, $arrayTermsOptions);
										}

										// Generate HTML
										echo '<div class="item">';
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
						                    data-hide-term="'. esc_attr($hide_term) .'"  
						                    data-default-term="'. esc_attr($default_term) .'">';

							            echo '<i class="fas fa-grip-vertical handle"></i>';
                                        echo '<input name="ymc-terms[]" class="category-list" id="category-id-'. esc_attr($term->term_id) .'" type="checkbox" value="'. esc_attr($term->term_id) .'" '. esc_attr($sl1) .'>';

									    echo '<label for="category-id-'. esc_attr($term->term_id) .'" class="category-list-label">
									    <span class="name-term">' . esc_html($name_term) .'</span>'. ' ['. esc_html($term->count) .']</label>						  						  
									    <i class="far fa-ellipsis-v choice-icon" title="Term settings"></i><span class="indicator-icon">'. $terms_icons .'</span>';

							            echo '</div>'; // end item-inner
										echo $hierarchy_terms_html; // Added hierarchy terms tree
							            echo '</div>'; // end item

										$terms_icons = '';
										$class_icon = '';
										$name_term = '';

									endforeach;

									echo '</div>'; // end entry-terms

									echo '</article>'; // end group-term
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

			<br/>

			<label class="form-label">
				<?php echo esc_html__('Hierarchical Tree of Terms', 'ymc-smart-filter'); ?>
				<span class="information">
                    <?php echo __('Check to display the hierarchy tree of terms. The depth of nesting 
                     of terms is 3 levels. If the nesting depth exceeds 3 levels, then terms with a nesting level greater than three will not be displayed in filters.
                     This applies to the following filter layouts: <b>Default Filter, Dropdown Filter, Sidebar Filter.</b>', 'ymc-smart-filter');?>
                    </span>
			</label>

			<div class="group-elements">
				<?php  $check_hierarchy_terms = ( $ymc_hierarchy_terms ) ? 'checked' : '';  ?>
				<input type="hidden" name='ymc_hierarchy_terms' value="0">
				<input class="ymc-hierarchy-terms" type="checkbox" value="1" name="ymc_hierarchy_terms" id="ymc-hierarchy-terms" <?php echo esc_attr($check_hierarchy_terms); ?>>
				<label for="ymc-hierarchy-terms"><?php echo esc_html__('Enable', 'ymc-smart-filter'); ?></label>
			</div>

		</div>

		<div class="form-group wrapper-selection">

			<?php if( $is_cpt ) : ?>

				<label class="form-label">
					<?php echo esc_html__('Exclude Post(s)', 'ymc-smart-filter'); ?>
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
					<?php echo esc_html__('Add Post(s)', 'ymc-smart-filter'); ?>
					<span class="information">
                    <?php echo esc_html__('Include / Exclude posts in the post grid on the frontend. To exclude posts, check option "Exclude posts". By default, posts are included in the grid. Drag and Drop posts for custom sorting', 'ymc-smart-filter');?>
                    </span>
				</label>

				<div class="search-posts">
                    <div class="search-inner">
                        <input class="input-field" type="text" placeholder="Search..." />
                        <i class="clear-button" title="Clear">x</i>
                    </div>
                    <button class="btn-submit">Search</button>
				</div>

                <div class="button-expand"><a href="#" class="button-expand__link"><?php esc_html_e('expand', 'ymc-smart-filter') ?></a></div>

				<div class="selection-posts" id="selection-posts">

					<div class="choices">
						<ul class="list choices-list" data-loading="true">
							<?php

							$tmp_post = $post;

							$arg = [
								'post_type' => $cpt,
								'orderby' => 'title',
								'order' => 'ASC',
								'posts_per_page' => 20
							];

							/*if( is_array($tax_sel) && count($tax_sel) > 0 && !empty($terms_sel) ) {

								$params_choices = [
									'relation' => 'OR'
								];

								foreach ( $tax_sel as $tax ) :

									$terms = get_terms([
										'taxonomy' => $tax,
										'hide_empty' => false
									]);

									if( $terms  && ! is_wp_error( $terms )) {

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
							}*/

							$query = new \WP_query($arg);

							if ( $query->have_posts() ) {

								$class_disabled = '';

								while ($query->have_posts()) : $query->the_post();
									if( is_array($ymc_choices_posts) &&  array_search(get_the_ID(), $ymc_choices_posts) !== false) {
										$class_disabled = 'disabled';
									}
									echo '<li><div class="ymc-rel-item ymc-rel-item-add '.$class_disabled.'" data-id="'.get_the_ID().'">
									<span class="postID">ID: '.get_the_ID().'</span> <span class="postTitle">'.get_the_title(get_the_ID()).'</span></div></li>';
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

									echo '<li class="item"><input type="hidden" name="ymc-choices-posts[]" value="'.get_the_ID().'">
							        <span  class="ymc-rel-item" data-id="'.get_the_ID().'">'.get_the_title(get_the_ID()).'
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

