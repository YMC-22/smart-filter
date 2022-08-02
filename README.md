#  PLUGIN YMC SMART FILTER
Plugin YMC Smart Filters - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has different filter and post layouts.

```
function test() {
  console.log("notice the blank line before this function?");
}
```

<h3>List Filters</h3>

<code>add_filter('ymc_pagination_prev_text', $ymc_pagination_prev_text, 3, 1);</code>

<code>add_filter('ymc_pagination_next_text', $ymc_pagination_next_text, 3, 1);</code>

<code>add_filter('ymc_pagination_load_more', $ymc_pagination_load_more, 3, 1);</code>

<code>add_filter('ymc_post_date_format', $ymc_post_date_format, 3, 1);</code>

<code>add_filter('ymc_post_excerpt_length', $ymc_post_excerpt_length, 3, 1);</code>

<code>add_filter('ymc_post_read_more', $ymc_post_read_more, 3, 1);</code>

<code>add_filter('ymc_button_show_all', $ymc_button_show_all, 3, 1);</code>

<code>add_filter('ymc_select_term_dropdown', $ymc_select_term_dropdown, 3, 1);</code>

=============================

<h3>Layouts</h3>

Add this code to `function.php` to your theme

<code>add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);</code>

<h4>Custom Post Layout</h4>

<pre>
@parmas:
$layouts - HTML markup
$post_id - Post ID
$cpt_id - Custom Posst Type ID

function custom_post_layout($layouts, $post_id, $cpt_id) {  
   $layouts .= get_the_title($post_id);
   $layouts .= wp_trim_words(get_the_content($post_id), 30);
   $layouts .= get_the_permalink($post_id);   
   return $layouts;
}
add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);
   
</pre>

===============================

<h3>Add custom content before or after filters panel.</h3>

<code>do_action("ymc_before_filter_layout");</code>

<code>do_action("ymc_after_filter_layout");</code>




