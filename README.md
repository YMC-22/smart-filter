![This is an image](/inc/front/assets/images/YMC-logos.png)

#  PLUGIN YMC SMART FILTER
> Plugin YMC Smart Filters - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has different filter and post layouts.

### List Filters

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
### Layouts
**Add this code to `function.php` to your theme**

```php
add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);
```

**Example Custom Post Layout**
```php
/***
* @Parmas:
* $layouts - HTML markup
* $post_id - Post ID
* $cpt_id - Custom Posst Type ID
**/

function custom_post_layout($layouts, $post_id, $cpt_id) {  
   $layouts .= '<h2>'.get_the_title($post_id).'</h2>';
   $layouts .= '<p>'.wp_trim_words(get_the_content($post_id), 30).'</p>';
   $layouts .= '<a href="'.get_the_permalink($post_id).'">Read More</a>;   
   return $layouts;
}
add_filter('ymc_post_custom_layout', 'custom_post_layout', 10, 3);
```  


**Add your content before or after the filter bar**
```php
do_action("ymc_before_filter_layout");
do_action("ymc_after_filter_layout");
```
