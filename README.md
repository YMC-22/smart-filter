![This is an image](/inc/front/assets/images/YMC-logos.png)

#  PLUGIN YMC SMART FILTER
> Plugin YMC Smart Filters - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has a different filter and post layouts. The plugin allows you to create multiple filters on one page. To use custom templates for the filter bar and plugin postcards, you need a basic understanding of technologies: HTML JavaScript, CSS and PHP. This plugin allows you to customize your post and filter templates, giving you total freedom in your presentation.

### Usage
- Activate Plugin or upload the entire 'ymc-smart-filters' folder to the '/wp-content/plugins/' directory.
- Add new YMC Smart Filter
- Copy YMC Smart Filter shortcode and paste to any page or post
- Set setting for each post 

### List Filters
Add code to `function.php` to your theme

`ID` is serial number of the filter on the page

**Change previous or next numbered paginator arrows:**
```php
add_filter('ymc_pagination_prev_text_ID', $ymc_pagination_prev_text, 10, 1);
add_filter('ymc_pagination_next_text_ID', $ymc_pagination_next_text, 10, 1);

Usage example:
add_filter('ymc_pagination_next_text_ID', function() {
   return 'My Text';
}, 10, 1);

```
**Change button text Load More**
```php
add_filter('ymc_pagination_load_more_ID', $ymc_pagination_load_more, 10, 1);

Usage example:
add_filter('ymc_pagination_load_more_ID', function ($load){
    $load = 'Button More';
    return $load;
}, 10, 1);
```
**Change publication date of a post in grid of cards**
```php
add_filter('ymc_post_date_format_ID', $ymc_post_date_format, 10, 1);

Usage example:
add_filter('ymc_post_date_format_ID', function () {
   return 'Y-m-d';
}, 10, 1);
```
**Change post text length (excerpt)**
```php
add_filter('ymc_post_excerpt_length_ID', $ymc_post_excerpt_length, 10, 1);

Usage example:
add_filter('ymc_post_excerpt_length_ID', function () {
   return 10;
}, 10, 1);
```
**Change button text in post card**
```php
add_filter('ymc_post_read_more_ID', $ymc_post_read_more, 10, 1);

Usage example:
add_filter('ymc_post_read_more_ID', function () {
    return 'Read...';
}, 10, 1);
```

**Change result text: "# posts selected". Parameters: $layouts, $found_posts**
```php
add_filter('ymc_posts_selected_ID', '$ymc_posts_selected', 10, 2);

Usage example:
function ymc_posts_selected($layouts, $founded_post) {
    $layouts = 'Posts found: ' . $founded_post .'';
    return $layouts;
}
add_filter('ymc_posts_selected_ID', 'ymc_posts_selected', 10, 2);
```

**Change list of post sort items**
```php
add_filter('ymc_sort_posts_by_ID', '$ymc_sort_posts', 10, 1);

Usage example:
List of fields for sorting posts: ID, author, title, name, date, modified, type, parent, rand, comment_count
Important! Keep HTML structure with all attributes as in the example below.
Add a new item for sorting posts by the 'name' field:

function ymc_sort_posts($layouts) {
   $layouts .= '<div class="menu-passive__item">
                <a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('name').'" href="#">'.
                esc_html__('Sort by Name', 'ymc-smart-filter').'</a></div>';
   return $layouts;
}
add_filter('ymc_sort_posts_by_ID', 'ymc_sort_posts', 10, 1);
```


**Change text of Show All button in filter panel**
```php
add_filter('ymc_button_show_all_ID', $ymc_button_show_all, 10, 1);

Usage example:
add_filter('ymc_button_show_all_ID', function () {
    return 'My All';
}, 10, 1);
```
**Add your content before or after the filter bar**
```php
add_action("ymc_before_filter_layout_ID");
add_action("ymc_after_filter_layout_ID");
```

### Layouts
**This filter allows you to change the post template**
```php
add_filter('ymc_post_custom_layout_ID', 'custom_post_layout', 10, 3);

Important! Keep HTML structure with all attributes as in the example below.
```
**Required ID:**
- `ID filter container on the page (Number)`

**Example Custom Post Layout**
```php
/**
 * Creating a custom post template
 * @param {string} layout - HTML markup
 * @param {int} post_id - Post ID
 * @param {int} filter_id - Filter ID
 * @param {int} increment_post - post counter
 * @param {array} arrOptions - array of additional post parameters. It includes: 
     - arrOptions['paged'] - page number
     - arrOptions['per_page'] - number of posts per page
     - arrOptions['total'] - number of all posts
 * @returns {string} HTML markup card post
 */
function my_custom_post_layout($layout, $post_id, $filter_id, $increment_post, $arrOptions) {  
   $layout  = '<h2>'.get_the_title($post_id).'</h2>';
   $layout .= '<p>'.wp_trim_words(get_the_content($post_id), 30).'</p>';
   $layout .= '<a href="'.get_the_permalink($post_id).'">Read More</a>;   
   return $layout;
}
add_filter('ymc_post_custom_layout_ID', 'my_custom_post_layout', 10, 5);
```  

**This filter allows you to change the filter template**
```php
add_filter('ymc_filter_custom_layout_ID', 'custom_filter_layout', 10, 3);
```
If you need to create your custom filter bar, you can use the filter which will allow you to create your filter bar. This requires a basic understanding of HTML JavaScript, CSS and PHP languages. In the example, it is indicated how you can use the settings and output of a custom filter. ***For your filter to work correctly, follow the following class and attribute names in your HTML markup:***

Important! Keep HTML structure with all attributes as in the example below.
Use, for example, following WordPress functions to get the required data: get_taxonomy(), get_term().

**Required ID:**
- `ID filter container on the page (Number)`

**Required Classes:**
- `all`
- `active`

**Required Date Attributes:**
- `data-selected`
- `data-termid`

**Example Custom Filter Layout**
```php
/**
 * Creating a custom filter template
 * @param {string} layout - HTML markup
 * @param {array} terms - list ids terms
 * @param {array} taxonomy - list sorted slugs taxonomies
 * @param {int} multiple - multiple or single selection of posts (0/1)
 * @param {string} target - name class target element
 * @returns {string} HTML markup filter bar
 */
function my_custom_filter_layout( $layout, $terms, $taxonomy, $multiple, $target ) { ?>

<script type="application/javascript">   
   window.addEventListener('DOMContentLoaded', () => {
         let _target = "<?php echo $target; ?>";
         document.querySelectorAll( _target + ' .filter-custom-layout [data-termid]' ).forEach((el) => {
               el.addEventListener('click', function (e) {
               e.preventDefault();
               let ymc = YMCTools({
                   target: _target,
                   self: this
               });
               ymc.updateParams();
               ymc.getFilterPosts();
           });
       });
   });
</script>
   
<?php
  if( count($terms) > 0 ) {
  $multiple = ( $multiple ) ? 'multiple' : '';
  $terms_list = implode(",", $terms);
  $layout = '<ul>';
  $layout .= '<li><a class="all active" href="#" data-selected="all" data-termid="'. esc_attr($terms_list) .'">'.esc_html__('ALL','theme').'</a></li>';

  foreach ($taxonomy as $tax) {
    $layout .= '<li>';
    $layout .= '<header>'.get_taxonomy( $tax )->label.'</header>';
    $layout .= '<ul>';
    foreach ( $terms as $term ) {
	if( $tax === get_term( $term )->taxonomy ) {
	   $layout .= '<li><a class="'. $multiple .'" href="#" data-selected="'. esc_attr(get_term($term)->slug).'" data-termid="'.esc_attr($term).'">'.esc_html(get_term($term)->name).'</a></li>';
	}
   }
    $layout .= '</ul></li>';   
 }
    $layout .= '</ul>';
	 $layout .= '<div class="posts-found"></div>';
 }
 return $layout;
}

add_filter('ymc_filter_custom_layout_ID', 'my_custom_filter_layout', 10, 5);
```


**API JS**

To interact with the filter through JS, should use the chain of the following methods:

**Required Classes:**
- `ID - ID (Number) filter container on the page`
- `termID - ID term (Number). Example, number 7 is termID`

```php
<script type="application/javascript"> 
    let termID = document.querySelector('[data-termid="7"]');
    let ymc = YMCTools({
                   target: '.data-target-ymcID',
                   self: termID
               });
               ymc.updateParams();
               ymc.getFilterPosts();
   
</script>

```


### Support
For support questions, please write to: wss.office21@gmail.com

### Youtube
https://www.youtube.com/watch?v=FIBNE0Ix6Vg



