![This is an image](/inc/front/assets/images/YMC-logos.png)

#  PLUGIN YMC SMART FILTER
> Plugin YMC Smart Filters - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has a different filter and post layouts. The plugin allows you to create multiple filters on one page. To use custom templates for the filter bar and plugin postcards, you need a basic understanding of technologies: HTML JavaScript, and PHP.

### Usage
- Activate Plugin or upload the entire 'ymc-smart-filters' folder to the '/wp-content/plugins/' directory.
- Add new YMC Smart Filter
- Copy YMC Smart Filter shortcode and paste to any page or post
- Set setting for each post 

### List Filters
**Add code to `function.php` to your theme**

**Change previous or next numbered paginator arrows:**
```php
add_filter('ymc_pagination_prev_text', $ymc_pagination_prev_text, 3, 1);
add_filter('ymc_pagination_next_text', $ymc_pagination_next_text, 3, 1);
```
**Change button text Load More**
```php
add_filter('ymc_pagination_load_more', $ymc_pagination_load_more, 3, 1);
```
**Change publication date of a post in grid of cards**
```php
add_filter('ymc_post_date_format', $ymc_post_date_format, 3, 1);
```
**Change post text length (excerpt)**
```php
add_filter('ymc_post_excerpt_length', $ymc_post_excerpt_length, 3, 1);
```
**Change button text in post card**
```php
add_filter('ymc_post_read_more', $ymc_post_read_more, 3, 1);
```
**Change text of Show All button in filter panel**
```php
add_filter('ymc_button_show_all', $ymc_button_show_all, 3, 1);
```
**Add your content before or after the filter bar**
```php
do_action("ymc_before_filter_layout");
do_action("ymc_after_filter_layout");
```

### Layouts
**This filter allows you to change the postcard template**
```php
add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);
```
**Example Custom Post Layout**
```php
/**
 * Creating a custom post template
 * @param {string} layout - HTML markup
 * @param {int} post_id - Post ID
 * @param {int} cpt_id - Custom Post Type ID
 * @returns {string} HTML markup card post
 */
function custom_post_layout($layout, $post_id, $cpt_id) {  
   $layout .= '<h2>'.get_the_title($post_id).'</h2>';
   $layout .= '<p>'.wp_trim_words(get_the_content($post_id), 30).'</p>';
   $layout .= '<a href="'.get_the_permalink($post_id).'">Read More</a>;   
   return $layout;
}
add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);
```  

**This filter allows you to change the filter bar template**
```php
add_filter('ymc_filter_custom_layout', 'custom_filter_layout', 10, 3);
```
If you need to create your custom filter bar, you can use the filter which will allow you to create your filter bar. This requires a basic understanding of HTML JavaScript and PHP languages. In the example, it is indicated how you can use the settings and output of a custom filter. ***For correct work, stick to the class names and attributes in the HTML markup when building the bar filter***.

**Example Custom Filter Layout**
```php
/**
 * Creating a custom filter template
 * @param {string} layout - HTML markup
 * @param {array} terms - list terms ids
 * @param {array} taxonomy - list taxonomy ids
 * @param {int} multiple - multiple or single selection of posts (0/1)
 * @param {string} target - name class target element
 * @returns {string} HTML markup filter bar
 */
function custom_filter_layout( $layout, $terms, $taxonomy, $multiple, $target ) { ?>

   <script type="application/javascript">
       window.addEventListener('DOMContentLoaded', () => {
          let _target = "<?php echo $target; ?>";
          document.querySelectorAll( _target + ' .filter-custom-layout .filter-link' ).forEach((el) => {
               el.addEventListener('click', function (e) {
               e.preventDefault();
               let settings = {
                   target: _target,
                   self: this
               }
               let ymc = YMCTools(settings);
               ymc.updateParams();
               ymc.getFilterPosts();
            });
         });
      });
   </script>

   <?php if( count($terms) > 0 ) {
    $layout = '<ul class="filter-entry">';
    $multiple = ( $multiple ) ? 'multiple' : '';
    $all_terms = implode(",", $terms);
    $layout .= '<li class="filter-item">
                <a class="filter-link all active" href="#" data-selected="all" data-termid="'. esc_attr($all_terms) .'">'.esc_html__('ALL','theme').'</a></li>';

    foreach ( $terms as $term ) {
        $layout .= '<li class="filter-item"><a class="filter-link '. $multiple .'" href="#" data-selected="'. esc_attr(get_term( $term )->slug).'" data-termid="'. esc_attr($term) .'">'.esc_html(get_term( $term )->name) .'</a></li>';
    }
    $layout .= '</ul><div class="posts-found"></div>';
  }
    return $layout;
}

add_filter('ymc_filter_custom_layout', 'custom_filter_layout', 10, 5);
```

### Support
For support questions, please write to: wss.office21@gmail.com



