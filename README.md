#  PLUGIN YMC SMART FILTER
Plugin YMC Smart Filters - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has different filter and post layouts.

####
List Filters:

<code>add_filter('ymc_pagination_prev_text', $ymc_pagination_prev_text, 3, 1);</code>

<code>add_filter('ymc_pagination_next_text', $ymc_pagination_next_text, 3, 1);</code>

<code>add_filter('ymc_pagination_load_more', $ymc_pagination_load_more, 3, 1);</code>

<code>add_filter('ymc_post_date_format', $ymc_post_date_format, 3, 1);</code>

<code>add_filter('ymc_post_excerpt_length', $ymc_post_excerpt_length, 3, 1);</code>

<code>add_filter('ymc_post_read_more', $ymc_post_read_more, 3, 1);</code>

<code>add_filter('ymc_button_show_all', $ymc_button_show_all, 3, 1);</code>

<code>add_filter('ymc_select_term_dropdown', $ymc_select_term_dropdown, 3, 1);</code>

=============================

Layouts:
Custom Post Layout

@parmas: 

$layouts - HTML markup

$post_id - Post ID

$cpt_id - Custom Posst Type ID

add_filter('ymc_post_custom_layout', $layouts, 10, 3);

Example:

function custom_post_layout($layouts, $post_id, $cpt_id) {  
   return $layouts;
}

add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);

===============================



===============================

Add Hooks:

Add custom content before or after filters panel

do_action("ymc_before_filter_layout");

do_action("ymc_after_filter_layout");




