<?php

namespace YMC_Smart_Filters\Core\Admin;

use YMC_Smart_Filters\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Meta_Boxes {

	public function __construct() {
		add_action( 'add_meta_boxes', array($this, 'add_post_metabox'));
		add_action( 'save_post', array($this, 'save_meta_box'), 10, 2);
		// Run popup
		//add_thickbox();
	}

	public function save_meta_box( $post_id, $post ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		// CPT
		if( isset($_POST['ymc-cpt-select']) ) {
			$cpt_val = sanitize_text_field( $_POST['ymc-cpt-select'] );
			update_post_meta( $post_id, 'ymc_cpt_value', $cpt_val );
		}

		// Taxonomy
		if( isset($_POST['ymc-taxonomy']) ) {
			$tax_val = sanitize_html_class( $_POST['ymc-taxonomy'] );
			update_post_meta( $post_id, 'ymc_taxonomy', $tax_val );
		}

		// Terms
		if( isset($_POST['ymc-terms']) ) {
			$terms = sanitize_html_class( $_POST['ymc-terms'] );
			update_post_meta( $post_id, 'ymc_terms', $terms );
		}

		// Choices Posts
		if( isset($_POST['ymc-choices-posts']) ) {
			$choices_posts = sanitize_html_class( $_POST['ymc-choices-posts'] );
			update_post_meta( $post_id, 'ymc_choices_posts', $choices_posts );
		}

		// Exclude Posts
		if( isset($_POST['ymc-exclude-posts']) ) {
			$exclude_posts = sanitize_html_class( $_POST['ymc-exclude-posts'] );
			update_post_meta( $post_id, 'ymc_exclude_posts', $exclude_posts );
		}

		// Taxonomy Relation
		if( isset($_POST['ymc-tax-relation']) ) {
			$tax_relation = sanitize_html_class( $_POST['ymc-tax-relation'] );
			update_post_meta( $post_id, 'ymc_tax_relation', $tax_relation );
		}

		// Filter Status (on/off)
		if( isset($_POST['ymc-filter-status']) ) {
			$filter_status = sanitize_text_field( $_POST['ymc-filter-status']);
			update_post_meta( $post_id, 'ymc_filter_status', $filter_status );
		}

		// Sort Posts on Frontend
		if( isset($_POST['ymc-sort-status']) ) {
			$sort_status = sanitize_text_field( $_POST['ymc-sort-status']);
			update_post_meta( $post_id, 'ymc_sort_status', $sort_status );
		}


		// Filter Layout
		if ( isset($_POST['ymc-filter-layout']) ) {
			$filter_layout = sanitize_text_field($_POST['ymc-filter-layout']);
			update_post_meta($post_id, 'ymc_filter_layout', $filter_layout);
		}

		// Filter Text Color
		if ( isset($_POST['ymc-filter-text-color']) ) {
			$filter_layout_text_color = sanitize_text_field($_POST['ymc-filter-text-color']);
			update_post_meta($post_id, 'ymc_filter_text_color', $filter_layout_text_color);
		}

		// Filter Background Color
		if ( isset($_POST['ymc-filter-bg-color']) ) {
			$filter_layout_bg_color = sanitize_text_field($_POST['ymc-filter-bg-color']);
			update_post_meta($post_id, 'ymc_filter_bg_color', $filter_layout_bg_color);
		}

		// Filter Active Color
		if ( isset($_POST['ymc-filter-active-color']) ) {
			$filter_layout_active_color = sanitize_text_field($_POST['ymc-filter-active-color']);
			update_post_meta($post_id, 'ymc_filter_active_color', $filter_layout_active_color);
		}

		// Multiple Filter
		if ( isset($_POST['ymc-multiple-filter']) ) {
			$ymc_multiple_filter = sanitize_text_field($_POST['ymc-multiple-filter']);
			update_post_meta($post_id, 'ymc_multiple_filter', $ymc_multiple_filter);
		}


		// Post Layout
		if ( isset($_POST['ymc-post-layout']) ) {
			$post_layout = sanitize_text_field($_POST['ymc-post-layout']);
			update_post_meta($post_id, 'ymc_post_layout', $post_layout);
		}

		// Post Text Color
		if ( isset($_POST['ymc-post-text-color']) ) {
			$post_layout_text_color = sanitize_text_field($_POST['ymc-post-text-color']);
			update_post_meta($post_id, 'ymc_post_text_color', $post_layout_text_color);
		}

		// Post Bg Color
		if ( isset($_POST['ymc-post-bg-color']) ) {
			$post_layout_bg_color = sanitize_text_field($_POST['ymc-post-bg-color']);
			update_post_meta($post_id, 'ymc_post_bg_color', $post_layout_bg_color);
		}

		// Post Active Color
		if ( isset($_POST['ymc-post-active-color']) ) {
			$post_layout_active_color = sanitize_text_field($_POST['ymc-post-active-color']);
			update_post_meta($post_id, 'ymc_post_active_color', $post_layout_active_color);
		}

		// Empty Text Post
		if ( isset($_POST['ymc-empty-post-result']) ) {
			$ymc_empty_post_result = sanitize_text_field($_POST['ymc-empty-post-result']);
			update_post_meta($post_id, 'ymc_empty_post_result', $ymc_empty_post_result);
		}

		// Link Target Post
		if ( isset($_POST['ymc-link-target']) ) {
			$ymc_link_target = sanitize_text_field($_POST['ymc-link-target']);
			update_post_meta($post_id, 'ymc_link_target', $ymc_link_target);
		}

		// Per Posts
		if (isset($_POST['ymc-per-page'])) {
			$ymc_per_page = sanitize_text_field($_POST['ymc-per-page']);
			update_post_meta($post_id, 'ymc_per_page', $ymc_per_page);
		}

		// Type Pagination
		if (isset($_POST['ymc-pagination-type'])) {
			$ymc_pagination_type = sanitize_text_field($_POST['ymc-pagination-type']);
			update_post_meta($post_id, 'ymc_pagination_type', $ymc_pagination_type);
		}

		// Hide Pagination
		if ( isset($_POST['ymc-pagination-hide']) ) {
			$ymc_pagination_hide = sanitize_text_field($_POST['ymc-pagination-hide']);
			update_post_meta($post_id, 'ymc_pagination_hide', $ymc_pagination_hide);
		}

		// Sort Terms Filter
		if (isset($_POST['ymc-sort-terms'])) {
			$ymc_sort_terms = sanitize_text_field($_POST['ymc-sort-terms']);
			update_post_meta($post_id, 'ymc_sort_terms', $ymc_sort_terms);
		}

		// Type Order Post By
		if (isset($_POST['ymc-order-post-by'])) {
			$ymc_order_post_by = sanitize_text_field($_POST['ymc-order-post-by']);
			update_post_meta($post_id, 'ymc_order_post_by', $ymc_order_post_by);
		}

		// Type Order Post Type
		if (isset($_POST['ymc-order-post-type'])) {
			$ymc_order_post_type = sanitize_text_field($_POST['ymc-order-post-type']);
			update_post_meta($post_id, 'ymc_order_post_type', $ymc_order_post_type);
		}

		// Special Post CSS Class
		if (isset($_POST['ymc-special-post-class'])) {
			$ymc_special_post_class = sanitize_text_field($_POST['ymc-special-post-class']);
			update_post_meta($post_id, 'ymc_special_post_class', $ymc_special_post_class);
		}

		// Filter Font
		if (isset($_POST['ymc-filter-font'])) {
			$ymc_filter_font = sanitize_text_field($_POST['ymc-filter-font']);
			update_post_meta($post_id, 'ymc_filter_font', $ymc_filter_font);
		}

		// Post Font
		if (isset($_POST['ymc-post-font'])) {
			$ymc_filter_font = sanitize_text_field($_POST['ymc-post-font']);
			update_post_meta($post_id, 'ymc_post_font', $ymc_filter_font);
		}

		// Search Posts Status (on/off)
		if( isset($_POST['ymc-filter-search-status']) ) {
			$search_status = sanitize_text_field( $_POST['ymc-filter-search-status']);
			update_post_meta( $post_id, 'ymc_filter_search_status', $search_status );
		}

		// Text Search Button
		if( isset($_POST['ymc-search-text-button']) ) {
			$search_text_button = sanitize_text_field( $_POST['ymc-search-text-button']);
			update_post_meta( $post_id, 'ymc_search_text_button', $search_text_button );
		}

		// Change Placeholder Field Search
		if( isset($_POST['ymc-search-placeholder']) ) {
			$search_placeholder = sanitize_text_field( $_POST['ymc-search-placeholder']);
			update_post_meta( $post_id, 'ymc_search_placeholder', $search_placeholder );
		}
	}

	public function add_post_metabox() {

		add_meta_box( 'ymc_top_meta_box' , __('Settings','ymc-smart-filter'), array($this,'ymc_top_meta_box'), 'ymc_filters', 'normal', 'core');

		add_meta_box( 'ymc_side_meta_box' , __('YMC SF Features','ymc-smart-filter'), array($this,'ymc_side_meta_box'), 'ymc_filters', 'side', 'core');

	}

	public function ymc_top_meta_box() { ?>

		<header class="ymc__header">
			<div class="logo"><img src="<?php echo YMC_SMART_FILTER_URL . 'includes/assets/images/YMC-logos.png'; ?>"></div>
			<div class="manage-dash">
				<span class="dashicons dashicons-admin-generic"></span>
				<span class="title"><?php echo esc_html__('General Settings','ymc-smart-filter'); ?></span>
			</div>
		</header>

		<div class="ymc__container-settings">

			<div class="tab-sidebar">
				<ul class="nav-tabs" id="ymcTab">
					<li class="nav-item">
						<a class="link active" id="general-tab" href="#general">
							<span class="text"><?php echo esc_html__('General','ymc-smart-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Post Type, Categories','ymc-smart-filter'); ?> </span>
							<span class="dashicons dashicons-admin-tools"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="layouts-tab" href="#layouts">
							<span class="text"><?php echo esc_html__('Layouts','ymc-smart-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Post Layout, Filter Layout','ymc-smart-filter'); ?> </span>
							<span class="dashicons dashicons-editor-table"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="appearance-tab" href="#appearance">
							<span class="text"><?php echo esc_html__('Appearance','ymc-smart-filter');?></span>
							<span class="info"><?php echo esc_html__('Post Layout, Filter Layout','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-visibility"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="search-tab" href="#search">
							<span class="text"><?php echo esc_html__('Search','ymc-smart-filter');?></span>
							<span class="info"><?php echo esc_html__('Post search','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-search"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="typography-tab" href="#typography">
							<span class="text"><?php echo esc_html__('Typography','ymc-smart-filter');?></span>
							<span class="info"><?php echo esc_html__('Title, Description Fonts','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-editor-spellcheck"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="advanced-tab" href="#advanced">
							<span class="text"><?php echo esc_html__('Advanced','category-ajax-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Add Extra Classes to Post','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-tag"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="shortcode-tab" href="#shortcode">
							<span class="text"><?php echo esc_html__('Shortcode','category-ajax-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Get Your shortcode','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-shortcode"></span>
						</a>
					</li>
				</ul>
			</div>

			<div class="tab-content">

				<?php

				    global $post;

                    $variable = Plugin::instance()->variables;

                ?>

				<div class="tab-panel active" id="general">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/general.php'; ?>
					</div>
				</div>

				<div class="tab-panel" id="layouts">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/layouts.php'; ?>
					</div>
				</div>

				<div class="tab-panel" id="appearance">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/appearance.php'; ?>
					</div>
				</div>

				<div class="tab-panel" id="search">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/search.php'; ?>
					</div>
				</div>

				<div class="tab-panel" id="typography">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/typography.php'; ?>
					</div>
				</div>

				<div class="tab-panel" id="advanced">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/advanced.php'; ?>
					</div>
				</div>

				<div class="tab-panel" id="shortcode">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/shortcode.php'; ?>
					</div>
				</div>

			</div>

		</div>

	<?php }

	public function ymc_side_meta_box() { ?>
		<article>
			<img style="width:70px;float:left;margin:0 10px 0 0;" class="ymc-logo" src="<?php esc_attr_e(YMC_SMART_FILTER_URL . '/includes/assets/images/logo.png'); ?>">
			YMC Smart Filter posts/custom post types by category allows to solve
			a variety of tasks for displaying posts on site pages. Easy to use.
			Customization of card templates and filters templates will allow you to fine-tune the display of posts. For more detailed
			information, please see the <a target="_blank" href="https://github.com/YMC-22/smart-filter">documentation</a>  for using the plugin.
		</article>
	<?php }

}