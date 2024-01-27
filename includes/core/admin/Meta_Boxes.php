<?php

namespace YMC_Smart_Filters\Core\Admin;

use YMC_Smart_Filters\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Meta_Boxes {

	public function __construct() {
		add_action( 'add_meta_boxes', array($this, 'add_post_metabox'));
		add_action( 'add_meta_boxes', array($this, 'ymc_attached_filters'));
		add_action( 'save_post', array($this, 'save_meta_box'), 10, 2);
		add_action( 'wp_dashboard_setup', array($this, 'register_filter_grids_widget'));
		// Run popup
		//add_thickbox();
	}


	public function ymc_attached_filters() {

		global $post;

		$filters_ids = [];
		$is_filters_ids = [];
		$is_shortcode = false;

		$posts_array = get_posts([
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'post_type'      => 'any',
			'orderby'        => 'title',
			'order'          => 'ASC'
		]);

		$filters_array = get_posts([
			'posts_per_page' => -1,
			'post_type'      => 'ymc_filters',
			'post_status'    => 'any'
		]);

		if( !empty($posts_array) && !empty($filters_array))
		{
			foreach ( $filters_array as $filter )
			{
				$filters_ids[] = $filter->ID;
			}

			foreach( $posts_array as $post_single )
			{
				if ($post->ID === $post_single->ID)
				{
					foreach ($filters_ids as $id)
					{
						if($this->ymc_is_shortcode($post_single->post_content, $id))
						{
							$is_filters_ids[] = $id;
							$is_shortcode = true;
						}
					}
				}
			}

			if( $is_shortcode )
			{
				add_meta_box(
					'ymc_filters_attached' ,
					__('Attached YMC Filters','ymc-smart-filter'),
					array($this,'ymc_attached_filters_callback'),
					Plugin::instance()->variables->display_cpt(['attachment', 'popup']),
					'side',
					'core',
					array( 'filter_ids' => $is_filters_ids )
				);
			}
		}
	}

	public function ymc_attached_filters_callback( $post, $metabox_args ) {

		global $post;

		echo '<ul class="ymc-filter-items">';

		foreach ( $metabox_args[ 'args' ][ 'filter_ids' ] as $id )
		{
			echo '<li><span class="dashicons dashicons-sticky"></span> <a href="'.get_edit_post_link( $id ).'" target="_blank" title="Edit Filter">'.
			           get_the_title( $id ) . ' (<i>ID: '.$id.'</i>) <span class="dashicons dashicons-edit"></span></a></li>';
		}
		echo '</ul>';
	}

	public function save_meta_box( $post_id, $post ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		// CPT
		if( isset($_POST['ymc-cpt-select']) ) {
			$cpt_values = $_POST['ymc-cpt-select'];
			$str_cpts = '';
			foreach ($cpt_values as $cpt) {
				$str_cpts .= $cpt.',';
			}
			$str_cpts = rtrim($str_cpts, ',');
			update_post_meta( $post_id, 'ymc_cpt_value', $str_cpts );
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
		else {
			update_post_meta( $post_id, 'ymc_terms', '' );
		}

		// Terms Icons
		if( isset($_POST['ymc-terms-icons']) ) {
			$terms_icons = $_POST['ymc-terms-icons'];
			update_post_meta( $post_id, 'ymc_terms_icons', $terms_icons );
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

		// Post Status
		if (isset($_POST['ymc-post-status'])) {
			$ymc_post_status = sanitize_text_field($_POST['ymc-post-status']);
			update_post_meta($post_id, 'ymc_post_status', $ymc_post_status);
		}

		// Meta Key by sort
		if (isset($_POST['ymc-meta-key'])) {
			$ymc_meta_key = sanitize_text_field($_POST['ymc-meta-key']);
			update_post_meta($post_id, 'ymc_meta_key', $ymc_meta_key);
		}

		// Meta Value by sort
		if (isset($_POST['ymc-meta-value'])) {
			$ymc_meta_value = sanitize_text_field($_POST['ymc-meta-value']);
			update_post_meta($post_id, 'ymc_meta_value', $ymc_meta_value);
		}

		// Multiple Sort
		if (isset($_POST['ymc-multiple-sort'])) {
			$ymc_multiple_sort = $_POST['ymc-multiple-sort'];
			update_post_meta($post_id, 'ymc_multiple_sort', $ymc_multiple_sort);
		}

		// Special Post CSS Class
		if (isset($_POST['ymc-special-post-class'])) {
			$ymc_special_post_class = sanitize_text_field($_POST['ymc-special-post-class']);
			update_post_meta($post_id, 'ymc_special_post_class', $ymc_special_post_class);
		}

		// Preloader Posts
		if (isset($_POST['ymc-preloader-icon'])) {
			$ymc_preloader_icon = sanitize_text_field($_POST['ymc-preloader-icon']);
			update_post_meta($post_id, 'ymc_preloader_icon', $ymc_preloader_icon);
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

		// Disable Autocomplete for Search Posts
		if( isset($_POST['ymc-autocomplete-state']) ) {
			$autocomplete_state = sanitize_text_field( $_POST['ymc-autocomplete-state']);
			update_post_meta( $post_id, 'ymc_autocomplete_state', $autocomplete_state );
		}

		// Disable Scroll Page
		if( isset($_POST['ymc-scroll-page']) ) {
			$ymc_scroll_page = sanitize_text_field( $_POST['ymc-scroll-page']);
			update_post_meta( $post_id, 'ymc_scroll_page', $ymc_scroll_page );
		}

		// Preloader Filters
		if( isset($_POST['ymc-preloader-filters']) ) {
			$ymc_preloader_filters = sanitize_text_field( $_POST['ymc-preloader-filters']);
			update_post_meta( $post_id, 'ymc_preloader_filters', $ymc_preloader_filters );
		}

		// Preloader Filters Rate
		if( isset($_POST['ymc-preloader-filters-rate']) ) {
			$ymc_preloader_filters_rate = sanitize_text_field( $_POST['ymc-preloader-filters-rate']);
			update_post_meta( $post_id, 'ymc_preloader_filters_rate', $ymc_preloader_filters_rate );
		}

		// Preloader Filters Custom
		if( isset($_POST['ymc-preloader-filters-custom']) ) {
			$ymc_preloader_filters_custom = sanitize_text_field( $_POST['ymc-preloader-filters-custom']);
			update_post_meta( $post_id, 'ymc_preloader_filters_custom', $ymc_preloader_filters_custom );
		}

		// Post Animation
		if( isset($_POST['ymc-post-animation']) ) {
			$ymc_post_animation = sanitize_text_field( $_POST['ymc-post-animation']);
			update_post_meta( $post_id, 'ymc_post_animation', $ymc_post_animation );
		}

		// Popup Status
		if( isset($_POST['ymc-popup-status']) ) {
			$ymc_popup_status = sanitize_text_field( $_POST['ymc-popup-status']);
			update_post_meta( $post_id, 'ymc_popup_status', $ymc_popup_status );
		}

		// Popup Animation
		if( isset($_POST['ymc-popup-animation']) ) {
			$ymc_popup_animation = sanitize_text_field( $_POST['ymc-popup-animation']);
			update_post_meta( $post_id, 'ymc_popup_animation', $ymc_popup_animation );
		}

		// Popup Animation Origin
		if( isset($_POST['ymc-popup-animation-origin']) ) {
			$ymc_popup_animation_origin = sanitize_text_field( $_POST['ymc-popup-animation-origin']);
			update_post_meta( $post_id, 'ymc_popup_animation_origin', $ymc_popup_animation_origin );
		}
		// Popup Settings
		if( isset($_POST['ymc_popup_settings']) ) {
			$ymc_popup_settings = $_POST['ymc_popup_settings'];
			update_post_meta( $post_id, 'ymc_popup_settings', $ymc_popup_settings );
		}

		// Search by Filtered Posts
		if( isset($_POST['ymc-search-filtered-posts']) ) {
			$ymc_search_filtered_posts = $_POST['ymc-search-filtered-posts'];
			update_post_meta( $post_id, 'ymc_search_filtered_posts', $ymc_search_filtered_posts );
		}

	}

	public function add_post_metabox() {

		add_meta_box( 'ymc_top_meta_box' , __('Settings','ymc-smart-filter'), array($this,'ymc_top_meta_box'), 'ymc_filters', 'normal', 'core');

		add_meta_box( 'ymc_side_meta_box' , __('Filter & Grids','ymc-smart-filter'), array($this,'ymc_side_meta_box'), 'ymc_filters', 'side', 'core');

	}

	public function register_filter_grids_widget() {

		add_meta_box( 'ymc_filter_grids_display',  __('Filter & Grids','ymc-smart-filter'), array($this,'ymc_filter_grids_display'), 'dashboard', 'side', 'high' );
	}

	public function ymc_top_meta_box() { ?>

		<header class="ymc__header">
			<div class="logo"><img src="<?php echo YMC_SMART_FILTER_URL . 'includes/assets/images/YMC-logos.png'; ?>"></div>
			<div class="manage-dash">
				<span class="dashicons dashicons-admin-tools"></span>
				<span class="title"><?php echo esc_html__('Settings','ymc-smart-filter'); ?></span>
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
							<span class="info"><?php echo esc_html__('Post, Filter, Popup, Pagination Settings','ymc-smart-filter'); ?></span>
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
							<span class="text"><?php echo esc_html__('Advanced','ymc-smart-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Add Extra Classes to Post','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-tag"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="shortcode-tab" href="#shortcode">
							<span class="text"><?php echo esc_html__('Shortcode','ymc-smart-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Get Your shortcode','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-shortcode"></span>
						</a>
					</li>
					<li class="nav-item">
						<a class="link" id="tools-tab" href="#tools">
							<span class="text"><?php echo esc_html__('Tools','ymc-smart-filter'); ?></span>
							<span class="info"><?php echo esc_html__('Export / Import Settings','ymc-smart-filter'); ?></span>
							<span class="dashicons dashicons-controls-repeat"></span>
						</a>
					</li>
				</ul>
			</div>

			<div class="tab-content">

				<?php

				    global $post;

                    $variable = Plugin::instance()->variables;

					require_once YMC_SMART_FILTER_DIR . '/includes/core/util/icons.php';

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

				<div class="tab-panel" id="tools">
					<div class="tab-entry">
						<?php require_once YMC_SMART_FILTER_DIR . '/includes/core/admin/tabs/tools.php'; ?>
					</div>
				</div>

			</div>

		</div>

	<?php }

	public function ymc_side_meta_box() { ?>
		<article>
			<img style="width:70px;float:left;margin:0 10px 0 0;" class="ymc-logo" src="<?php esc_attr_e(YMC_SMART_FILTER_URL . '/includes/assets/images/logo.png'); ?>">
			Filter & Grids posts/custom post types by category allows to solve
			a variety of tasks for displaying posts on site pages. Easy to use.
			Customization of card templates and filters templates will allow you to fine-tune the display of posts. For more detailed
			information, please see the <a target="_blank" href="https://github.com/YMC-22/smart-filter">documentation</a>  for using the plugin.<br/>
			<hr/>
			<strong style="font-weight: 500;line-height: 1.5;font-size: 16px;background: #098ab8;display: block;padding: 7px 15px;color: #fff;">
				Did you like or find our plugin helpful? To support the plugin, you can make a <a style="color: #ffee5d;font-size: 18px;text-decoration-thickness: 1px;text-underline-offset: 2px;text-transform: uppercase;}" target="_blank" href="https://www.paypal.com/donate/?hosted_button_id=B2MHM5LM29UGW">Donation</a></strong>.
		</article>
	<?php }

	public function ymc_filter_grids_display() {
		_e('<b>Welcome to Filter & Grids.</b> <br/>
		<p>This plugin will allow you to easily and quickly create all kinds of post grids with their filters.</p> 
		<p>Create your first grid of posts: <a href="'. site_url().'/wp-admin/post-new.php?post_type=ymc_filters">Create</a></p>
		<p>For more detailed information see <a target="_blank" href="https://github.com/YMC-22/smart-filter">documentation <span style="text-decoration: none;" class="dashicons dashicons-external"></span></a> on using this plugin.</p>','ymc-smart-filter');
	}

	public function ymc_is_shortcode( $content, $id ) {

		if ( strpos( $content, "[ymc_filter id='".$id."']" ) ||
		     strpos( $content, "[ymc_filter id=\"".$id."\"]" )
		) {
			return true;
		}
		return false;
	}

}