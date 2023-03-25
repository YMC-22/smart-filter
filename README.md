![This is an image](/inc/front/assets/images/YMC-logos.png)

#  Documentation for SMART FILTER
> Plugin Smart Filters - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has a different filter and post layouts. The plugin allows you to create multiple filters on one page. To use custom templates for the filter bar and plugin postcards, you need a basic understanding of technologies: HTML JavaScript, CSS and PHP. This plugin allows you to customize your post and filter templates, giving you total freedom in your presentation. JS API interface allows you to interact with the filter from the outside. This allows you to develop all sorts of complex post filtering interfaces.

### Usage
- Activate Plugin or upload the entire 'ymc-smart-filters' folder to the '/wp-content/plugins/' directory.
- Add new YMC Smart Filter
- Copy YMC Smart Filter shortcode and paste to any page or post
- Set setting for each post 

### List Filters
Add code to `function.php` to your theme

`FilterID` is ID of the filter inside Smart Filter Admin Panel Shortcode tab [ymc_filter id='165']

`LayoutID` is serial number of the custom filter layout on the page. Can be find by inspecting the filter css class like: data-target-ymc545-1


**Change previous or next numbered paginator arrows:**
```php
add_filter('ymc_pagination_prev_text_FilterID_LayoutID', $ymc_pagination_prev_text, 10, 1);
add_filter('ymc_pagination_next_text_FilterID_LayoutID', $ymc_pagination_next_text, 10, 1);

Usage example:
add_filter('ymc_pagination_next_text_ID', function() {
   return 'My Text';
}, 10, 1);

```
**Change button text Load More**
```php
add_filter('ymc_pagination_load_more_FilterID_LayoutID', $ymc_pagination_load_more, 10, 1);

Usage example:
add_filter('ymc_pagination_load_more_FilterID_LayoutID', function ($load){
    $load = 'Button More';
    return $load;
}, 10, 1);
```
**Change publication date of a post in grid of cards**
```php
add_filter('ymc_post_date_format_FilterID_LayoutID', $ymc_post_date_format, 10, 1);

Usage example:
add_filter('ymc_post_date_format_FilterID_LayoutID', function () {
   return 'Y-m-d';
}, 10, 1);
```
**Change post text length (excerpt)**
```php
add_filter('ymc_post_excerpt_length_FilterID_LayoutID', $ymc_post_excerpt_length, 10, 1);

Usage example:
add_filter('ymc_post_excerpt_length_FilterID_LayoutID', function () {
   return 10;
}, 10, 1);
```
**Change button text in post card**
```php
add_filter('ymc_post_read_more_FilterID_LayoutID', $ymc_post_read_more, 10, 1);

Usage example:
add_filter('ymc_post_read_more_FilterID_LayoutID', function () {
    return 'Read...';
}, 10, 1);
```

**Change result text: "# posts selected". Parameters: $layouts, $found_posts**
```php
add_filter('ymc_posts_selected_FilterID_LayoutID', 'ymc_posts_selected', 10, 2);

Usage example:
function ymc_posts_selected($layouts, $founded_post) {
    $layouts = 'Posts found: ' . $founded_post .'';
    return $layouts;
}
add_filter('ymc_posts_selected_FilterID_LayoutID', 'ymc_posts_selected', 10, 2);
```

**Change list of post sort items**
```php
add_filter('ymc_sort_posts_by_FilterID_LayoutID', '$ymc_sort_posts', 10, 1);

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
add_filter('ymc_sort_posts_by_FilterID_LayoutID', 'ymc_sort_posts', 10, 1);
```


**Change text of Show All button in filter panel**
```php
add_filter('ymc_button_show_all_FilterID_LayoutID', $ymc_button_show_all, 10, 1);

Usage example:
add_filter('ymc_button_show_all_FilterID_LayoutID', function () {
    return 'My All';
}, 10, 1);
```
**Add your content before or after the filter bar**
```php
add_action("ymc_before_filter_layout_FilterID_LayoutID");
add_action("ymc_after_filter_layout_FilterID_LayoutID");
```

### Layouts
**This filter allows you to change the post template**
```php
add_filter('ymc_post_custom_layout_FilterID_LayoutID', 'custom_post_layout', 10, 5);

Important! Keep HTML structure with all attributes as in the example below.
```
**Required ID:**
- `FilterID & LayoutID (Number)`

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
   $layout .= '<a href="'.get_the_permalink($post_id).'">Read More</a>';   
   return $layout;
}
add_filter('ymc_post_custom_layout_FilterID_LayoutID', 'my_custom_post_layout', 10, 5);
```  

**This action allows you to change the post grid template**
```php
add_action('ymc_before_custom_layout_FilterID_LayoutID', 'my_before_custom_layout', 10, 2);
add_action('ymc_after_custom_layout_FilterID_LayoutID', 'my_after_custom_layout', 10, 2);
```
It will be possible to insert any content in the place you need (before or after the selected post).

**Required ID:**
- `Filter & ID_LayoutID (Number)`
 
**Example add custom action after selected post**
```php
/**
 * Add custom content after every second post
 * @param {int} increment_post - post counter
 * @param {array} arrOptions - array of additional post parameters. It includes: 
     - arrOptions['paged'] - page number
     - arrOptions['per_page'] - number of posts per page
     - arrOptions['total'] - number of all posts
 * @returns {string} HTML markup card post
 */
 function ymc_after_custom_layout( $increment, $arrOptions ) {
    if( $increment === 2 || $increment === ( 2 + $arrOptions['per_page'] ) ) {
      echo '<article class="post-item">
              <h3>My Header</h3>
	      <div>Custom text</div> 
            </article>';
    }
}
add_action( 'ymc_after_custom_layout_FilterID_LayoutID', 'ymc_after_custom_layout', 10, 2 ); 
```

**This filter allows you to change the filter template**
```php
add_filter('ymc_filter_custom_layout_FilterID_LayoutID', 'custom_filter_layout', 10, 3);
```
If you need to create your custom filter bar, you can use the filter which will allow you to create your filter bar. This requires a basic understanding of HTML JavaScript, CSS and PHP languages. In the example, it is indicated how you can use the settings and output of a custom filter. ***For your filter to work correctly, follow the following class and attribute names in your HTML markup:***

Important! Keep HTML structure with all attributes as in the example below.
Use, for example, following WordPress functions to get the required data: get_taxonomy(), get_term().

**Required ID:**
- `FilterID & LayoutID (Number)`

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

add_filter('ymc_filter_custom_layout_FilterID_LayoutID', 'my_custom_filter_layout', 10, 5);
```




### JS API SMART FILTER

To control the post filter via javascript, use the following methods of the Filter's global YMCTools object. All parameters, their name and values that are passed to the object, are built on the principles and rules of the global WP_Query object in the WordPress core. Therefore, please, refer to the relevant documentation for using the WP_Query object for clarification. All of these methods should be used when creating event handlers. but for example, when clicking on a button or link, call one or another method.

**This method allows to get posts by ID terms of different taxonomies.**

```php
YMCTools({target: ".data-target-ymcFilterID-LayoutID", terms: "termID"}).apiTermUpdate();
```
**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `termID - ID term (String). It is a string data type and is enclosed in quotes. Can set several ID terms separated by commas, for example: "11,35,47"`

**Optional params:**
- `taxRel - define the interaction between different taxonomies in the query. The default is "AND". If set "all" will match the relation "OR". Installed in the admin panel Filter -> Tab Ganeral -> Taxonomy Relation.`

```php
Usage example:

     YMCTools({
         target: '.data-target-ymcFilterID-LayoutID',
         terms: 'termID'            
     }).apiTermUpdate();  

```

**This method allows to get posts by meta fields.**

```php
YMCTools({target: ".data-target-ymcFilterID-LayoutID", meta: [params]}).apiTermUpdate();
```
All parameters correspond to the parameters of the global WP_Query object. 
To make a correct request, specify all the necessary parameters in JSON format. All parameters in double quotes.

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `meta - (Array) is an array of objects that include in the request settings. All objects must be in josn data format.`

**Optional params:**
- `relation - defines a logical relationship between nested arrays. Default is "AND"`

```php
Usage example:

    YMCTools({
	target: '.data-target-ymcFilterID-LayoutID',
        meta : [
                 { "relation" : "OR" },
                 { "key" : "color", "value" : "blue" },
                 { "key" : "price", "value" : "10", "compare": "LIKE" }
               ]
	}).apiMetaUpdate();

```

**This method allows to get posts by date.**

```php
YMCTools({target: ".data-target-ymcFilterID-LayoutID", date: [params]}).apiDateUpdate();
```
All parameters correspond to the parameters of the global WP_Query object. 
To make a correct request, specify all the necessary parameters in JSON format. All parameters in double quotes.

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `date - (Array) is an array of objects that include in the request settings. All objects must be in josn data format.`

**Optional params:**
- `relation - defines a logical relationship between nested arrays. Default is "AND"`

```php
Usage example:

      YMCTools({
	  target: '.data-target-ymcFilterID-LayoutID',
          date : [                  
                   { "monthnum" : "1", "compare" : "=" },
                   { "year" : "2023", "compare" : "=" },
                   { "day" : "10", "compare" : ">=" }
                ]
	 }).apiDateUpdate();
     
</script>	 
```

**This method allows to clear query parameters in the filter by terms.**

```php
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiTermClear();
```

**This method allows to clear query parameters in the filter by meta fields.**

```php
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiMetaClear();
```

**This method allows to clear query parameters in the filter by date.**

```php
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiDateClear();
```

### Hooks JS.

Note: hooks should be used in: 

**Vanilla javascript**
- addEventListener('DOMContentLoaded', (event) => {});
 
**jQuery**
- $(document).on('ready', function() {});

**Stop loading posts on page load.**

```php
wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', 'callback(elem)');
```
Set the selected filter's data-loading attribute to false ( data-loading="false" )

**Params function callback:**
- `elem - DOM container filter.`

```php
Usage example:

wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(elem) {
     if( elem.classList.contains('data-target-ymc80-1') ) {
            elem.dataset.loading = 'false';
         }
    });
```


**Before loaded all posts.**

```php
wp.hooks.addAction('ymc_before_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name)');
```

Hook works before loading all posts.

**Params function callback:**
- `class_name - is the name of the filter container class.`

```php
Usage example:

wp.hooks.addAction('ymc_before_loaded_data_80_1', 'smartfilter', function(class_name){
       console.log('Before loading all posts: ' + class_name);
   });
```



**After loaded all posts.** 

```php
wp.hooks.addAction('ymc_after_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name)');
```

Hook works after loading all posts.

**Params function callback:**
- `class_name - is the name of the filter container class.`

```php
Usage example:

wp.hooks.addAction('ymc_after_loaded_data_80_1', 'smartfilter', function(class_name){
      console.log('After loading all posts:' + class_name);
   });
```

**Complete loaded all data.**

This hook is called regardless of if the request was successful, or not. 
You will always receive a complete callback, even for synchronous requests.

```php
wp.hooks.addAction('ymc_complete_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name, status)');
```

**Params function callback:**
- `class_name - is the name of the filter container class.`
- `status - a string categorizing the status of the request ("success", "notmodified", "nocontent", "error", "timeout", "abort", or "parsererror").`

```php
Usage example:

wp.hooks.addAction('ymc_complete_loaded_data_80_1', 'smartfilter', function(class_name, status){
      console.log('Complete loaded all data:' + class_name + ' status:' + status);
   });
```

**An example of using hooks in combination with the YMCTools object and its methods**

Stop loading posts for the selected filter and then load posts for the selected term

```php       
    wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(el){
        if( el.classList.contains('data-target-ymc80-1') ) {
            el.dataset.loading = 'false';
        }
    });    
    
    window.addEventListener("load", (event) => {
         YMCTools({
             target: '.data-target-ymc80-1',
             terms: '7'
         }).apiTermUpdate();
     });
```

### Support
For support questions, please write to: wss.office21@gmail.com

### Youtube
https://www.youtube.com/watch?v=FIBNE0Ix6Vg



