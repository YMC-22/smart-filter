![This is an image](/includes/assets/images/YMC-logos.png)

#  Filter & Grids
> <a href="https://wordpress.org/plugins/ymc-smart-filter/">Plugin Filter & Grids</a> - Filter posts/custom post types by custom taxonomy/category without page reload and with pagination too. It has a different filter and post layouts. The plugin allows you to create multiple filters on one page. To use custom templates for the filter bar and plugin postcards, you need a basic understanding of technologies: HTML JavaScript, CSS and PHP. This plugin allows you to customize your post and filter templates, giving you total freedom in your presentation. JS API interface allows you to interact with the filter from the outside. This allows you to develop all sorts of complex post filtering interfaces.

### Usage
- Activate Plugin or upload the entire 'ymc-smart-filter' folder to the '/wp-content/plugins/' directory.
- Add new Filter & Grids
- Copy Filter & Grids shortcode and paste to any page or post
- Set setting for each post 

### List Filters
Add code to `function.php` to your theme

`FilterID` is ID of the filter inside Filter & Grids Admin Panel Shortcode tab [ymc_filter id='545']

`LayoutID` is serial number of the custom filter layout on the page. Can be find by inspecting the filter css class like: data-target-ymc545-1


**Change previous or next numbered paginator arrows:**
```php
add_filter('ymc_pagination_prev_text_FilterID_LayoutID', $ymc_pagination_prev_text, 10, 1);
add_filter('ymc_pagination_next_text_FilterID_LayoutID', $ymc_pagination_next_text, 10, 1);

// Usage example:
add_filter('ymc_pagination_next_text_545_1', function() {
   return 'My Text';
}, 10, 1);

```
**Change button text Load More**
```php
add_filter('ymc_pagination_load_more_FilterID_LayoutID', $ymc_pagination_load_more, 10, 1);

// Usage example:
add_filter('ymc_pagination_load_more_545_1', function ($load){
    $load = 'Button More';
    return $load;
}, 10, 1);
```
**Change publication date of a post in grid of cards**
```php
add_filter('ymc_post_date_format_FilterID_LayoutID', $ymc_post_date_format, 10, 1);

// Usage example:
add_filter('ymc_post_date_format_545_1', function () {
   return 'Y-m-d';
}, 10, 1);
```
**Change post text length (excerpt)**
```php
add_filter('ymc_post_excerpt_length_FilterID_LayoutID', $ymc_post_excerpt_length, 10, 1);

// Usage example:
add_filter('ymc_post_excerpt_length_545_1', function () {
   return 10;
}, 10, 1);
```
**Change button text in post card**
```php
add_filter('ymc_post_read_more_FilterID_LayoutID', $ymc_post_read_more, 10, 1);

// Usage example:
add_filter('ymc_post_read_more_545_1', function () {
    return 'Read...';
}, 10, 1);
```

**Change result text: "# posts selected". Parameters: $layouts, $found_posts**
```php
add_filter('ymc_posts_selected_FilterID_LayoutID', 'ymc_posts_selected', 10, 2);

// Usage example:
function ymc_posts_selected($layouts, $founded_post) {
    $layouts = 'Posts found: ' . $founded_post .'';
    return $layouts;
}
add_filter('ymc_posts_selected_545_1', 'ymc_posts_selected', 10, 2);
```

**Change list of post sort items**
```php
add_filter('ymc_sort_posts_by_FilterID_LayoutID', '$ymc_sort_posts', 10, 1);

// Usage example:
// List of fields for sorting posts: ID, author, title, name, date, modified, type, parent, rand, comment_count
// Important! Keep HTML structure with all attributes as in the example below.
// Add a new item for sorting posts by the 'name' field:

function ymc_sort_posts($layouts) {
   $layouts .= '<div class="menu-passive__item">
                <a class="menu-link" data-order="'.esc_attr('desc').'" data-orderby="'.esc_attr('name').'" href="#">'.
                esc_html__('Sort by Name', 'ymc-smart-filter').'</a></div>';
   return $layouts;
}
add_filter('ymc_sort_posts_by_545_1', 'ymc_sort_posts', 10, 1);
```


**Change text of Show All button in filter panel**
```php
add_filter('ymc_button_show_all_FilterID_LayoutID', $ymc_button_show_all, 10, 1);

// Usage example:
add_filter('ymc_button_show_all_545_1', function () {
    return 'My All';
}, 10, 1);
```

**Change the placeholder "All" for the filter named Dropdown Filter Compact**
```php
add_filter('ymc_placeholder_dropdown_FilterID_LayoutID', $ymc_placeholder_all, 10, 1);

// Usage example:
add_filter('ymc_placeholder_dropdown_545_1', function () {
    return 'My Taxonomy';
}, 10, 1);
```

**Change the "All" placeholder for the filter named "Compact Dropdown Filter" individually for each taxonomy**
```php
add_filter('ymc_placeholder_dropdown_FilterID_LayoutID_tax-slug', $ymc_placeholder_all, 10, 1);

// Usage example:
add_filter('ymc_placeholder_dropdown_72_1_post_tag', function () {
	return 'My Tags';
}, 10, 1);

add_filter('ymc_placeholder_dropdown_72_1_category', function () {
	return 'My Category';
}, 10, 1);
```

**Change the text of the “Sort” button on the sort panel**
```php
add_filter('ymc_sort_text_FilterID_LayoutID', $ymc_button_show_all, 10, 1);

// Usage example:
add_filter('ymc_sort_text_545_1', function () {
    return 'My Sort';
}, 10, 1);
```

**Change the name of the category (taxonomy) in the dropdown list button filters on the filter panel.**
```php
add_filter('ymc_tax_name_FilterID_LayoutID_slugTax', $ymc_button_show_all, 10, 1);
- slugTax - category (taxonomy) slug

// Usage example:
add_filter('ymc_tax_name_545_1_category', function () {
    return 'My Tax Name';
}, 10, 1);
```

**Add your content before or after the filter bar**
```php
add_action("ymc_before_filter_layout_FilterID_LayoutID");
add_action("ymc_after_filter_layout_FilterID_LayoutID");
```
**Add your content before or after the post grid layout**
```php
add_action("ymc_before_post_layout_FilterID_LayoutID");
add_action("ymc_after_post_layout_FilterID_LayoutID");
```

### Shortcodes
**The plugin provides a list of shortcodes to display different components of the plugin. This allows you to separately place plugin components in different places on the page without being tied to the current grid of posts, which makes the plugin more flexible and compact. The entire list of shortcodes can be found in the Shortcodes section.**

**The plugin has the following shortcodes:**

#### `[ymc_extra_filter id="545"]`

**Shortcode for displaying the "Filter" component. It includes all standard plugin layouts (Default Filter, Grouped Filter, Dropdown Filter, Sidebar Filter, Alphabetical Navigation, Custom Filter Extra Layout). To select the filter layout type use: Advanced  ->  Extra Filter Layout**

#### `[ymc_extra_search id='545']`

**Shortcode for displaying the "Search" component.**

#### `[ymc_extra_sort id='545']`

**Shortcode for displaying the "Sorting" component.**


### Layouts
**This filter allows you to change the post template**
```php
add_filter('ymc_post_custom_layout_FilterID_LayoutID', 'custom_post_layout', 10, 5);

Important! Keep HTML structure with all attributes as in the example below.
```
**Required ID:**
- `FilterID & LayoutID (Number)`

Usage example:
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
     - arrOptions['class_popup'] - class btn popup. Set for btn post. Value: string or empty
     - arrOptions['terms_settings'] - array of all terms with their settings. Value: object with the following properties. Default empty array.            
        - termid - ID term
        - bg - background term. Hex Color Codes (ex: #dd3333)
        - color - color term. Hex Color Codes (ex: #dd3333)
        - class - custom name class of the term
        - status - selected term. Value: checked or empty
        - alignterm - align icon in term
        - coloricon - color icon
        - classicon - name class icon (Font Awesome Icons. ex. far fa-arrow-alt-circle-down) 
        - status - term status (checked)
        - default - (string) default term (checked)
        - name - (string) custom term name
 * @returns {string} HTML markup card post
 */
function my_custom_post_layout($layout, $post_id, $filter_id, $increment_post, $arrOptions) {  
   $layout  = '<h2>'.get_the_title($post_id).'</h2>';
   $layout .= '<p>'.wp_trim_words(get_the_content($post_id), 30).'</p>';
   $layout .= '<a href="'.get_the_permalink($post_id).'">Read More</a>'; 
   // $layout .= '<a class="'.esc_attr($arrOptions['class_popup']).'" data-postid="'.esc_attr($post_id).'" href="#">Open Popup</a>';  
   return $layout;
}
add_filter('ymc_post_custom_layout_545_1', 'my_custom_post_layout', 10, 5);
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
     - arrOptions['terms_settings'] - array of all terms with their settings. See options in filter ymc_post_custom_layout.
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
add_action( 'ymc_after_custom_layout_545_1', 'ymc_after_custom_layout', 10, 2 ); 
```

**This filter allows you to change the Filter Custom Layout**
```php
add_filter('ymc_filter_custom_layout_FilterID_LayoutID', 'custom_filter_layout', 10, 6);
```
If you need to create your custom filter bar, you can use the filter which will allow you to create your filter bar. In the example, it is indicated how you can use the settings and output of a custom filter. 
***For your filter to work correctly, follow the following class and attribute names in your HTML markup:***

Important! Keep HTML structure with all attributes as in the example below.
Use, for example, following WordPress functions to get the required data: get_taxonomy(), get_term() and etc.

**Required ID:**
- `FilterID & LayoutID - Filter ID and Filter Counter`

**Required Classes:**
- `all`
- `active`

**Required Date Attributes:**
- `data-selected`
- `data-termid`

Usage example:

```php
/**
 * Creating a Custom Filter Layout
 * @param {string} layout - HTML markup filter
 * @param {array} terms - list ids terms
 * @param {array} taxonomy - list sorted slugs taxonomies
 * @param {int} multiple - multiple or single selection of posts (0/1)
 * @param {string} target - name class target element
 * @param {array} options - array of all terms with their settings. Value: object with the following properties. Default empty array.
      - termid - (string) ID term
      - bg - (string) background term. Hex Color Codes (ex: #dd3333)
      - color - (string) color term. Hex Color Codes (ex: #dd3333)
      - class - (string) custom name class of the term
      - status - (string) selected term. Value: checked or empty
      - alignterm - (string) align icon in term
      - coloricon - (string) color icon
      - classicon - (string) name class icon (Font Awesome Icons. ex. far fa-arrow-alt-circle-down) 
      - status - (string) term status (checked)
      - default - (string) default term (checked)
      - name - (string) custom term name
 * @returns {string} HTML markup filter bar
 */
 
function my_custom_filter_layout( $layout, $terms, $taxonomy, $multiple, $target, $options ) { ?>

<script>   
   window.addEventListener('DOMContentLoaded', () => {   
         let _target = "<?php echo $target; ?>";
         
         document.querySelectorAll( _target + ' [data-termid]' ).forEach((el) => {         
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
  if( !empty($terms) ) {
  
      $multiple = ( $multiple ) ? 'multiple' : '';
      $terms_list = implode(",", $terms);
      $layout  = '<ul>';
      $layout .= '<li><a class="all active" href="#" data-selected="all" data-termid="'. esc_attr($terms_list) .'">'.esc_html__('ALL','theme').'</a></li>';
    
    foreach ($taxonomy as $tax) {
      $layout .= '<li>';
      $layout .= '<header>'.get_taxonomy( $tax )->label.'</header>';
      $layout .= '<ul>';
      foreach ( $terms as $term ) {
      if( $tax === get_term( $term )->taxonomy ) {      
        $class_icon = '';
        $color_icon = '';
        
        // Optional
        foreach ( $options as $obj ) {
            if( $obj->termid === $term ) {
                  $class_icon = $obj->classicon;
                  $color_icon = $obj->coloricon;
                  break;
                }
             }     
             $layout .= '<li><a class="'. $multiple .'" href="#" data-selected="'. esc_attr(get_term($term)->slug).'" data-termid="'. esc_attr($term) .'">'.
             '<i class="'. esc_attr($class_icon) .'" style="color:'. esc_attr($color_icon) .'"></i>'. esc_html(get_term($term)->name) .'</a></li>';
         }
     }
     $layout .= '</ul></li>';   
   }
    $layout .= '</ul>';
    $layout .= '<div class="posts-found"></div>';
 }
 return $layout;
}
add_filter('ymc_filter_custom_layout_545_1', 'my_custom_filter_layout', 10, 6);
```

**This filter allows you to change the Extra Filter Custom Layout**
```php
add_filter('ymc_filter_custom_extra_layout_FilterID_LayoutID', 'custom_extra_filter_layout', 10, 6);
```
This filter allows you to change the layout of an extra filter outside of the main filter. All parameters for extra filter are the same as for the custom filter layout.

Usage example:
```php
function custom_filter_extra_layout( $layout, $terms, $taxonomy, $multiple, $target, $options ) { ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
        
            let extraFilter = "<?php echo $target; ?>";
            let extraFilterCounter = document.querySelector(extraFilter).dataset.extraFilterCounter;
            let _target = `.data-target-ymc${extraFilterCounter}`;

            document.querySelectorAll( extraFilter + ' [data-termid]' ).forEach((el) => {            
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

	if( !empty($terms) ) {
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
				$class_icon = '';
				$color_icon = '';
				
				// Optional               
				foreach ( $options as $obj ) {
				    if( $obj->termid === $term ) {
				        $class_icon = $obj->classicon;
				        $color_icon = $obj->coloricon;
				        break;
				    }
			    }
			$layout .= '<li><a class="'. $multiple .'" href="#" data-selected="'. esc_attr(get_term($term)->slug).'" data-termid="'.esc_attr($term).'">' .
			           '<i class="'. esc_attr($class_icon) . '" style="color: '. esc_attr($color_icon) .';"></i>' . esc_html(get_term($term)->name).'</a></li>';
				}
			}
			$layout .= '</ul>';
			$layout .= '</li>';
		}

		$layout .= '</ul>';
	}

	return $layout;
}
add_filter('ymc_filter_custom_extra_layout_545_1', 'custom_filter_extra_layout', 10, 6);
```

**This filter allows you to change the popup custom layout**

```php
add_filter('ymc_popup_custom_layout_FilterID_LayoutID', 'func_custom', 10, 2);
```
Usage example:

```php
/**
 * @param {string} layout - HTML markup
 * @param {int} post_id - Post ID
 */
add_filter('ymc_popup_custom_layout_545_1', function ( $layout, $post_id ) {

    $output = '<h2>Custom Text: '. get_the_title($post_id) .'</h2>';
	return $output;
	
}, 10, 2);
```

**This filter allows you to change the carousel custom layout**
```php
add_filter('ymc_post_carousel_custom_FilterID_LayoutID', 'post_carousel_custom_layout', 10, 4);
```
Usage example:

```php
/**
 * Creating a Custom Carousel Layout
 * @param {string} layout - HTML markup
 * @param {int} post_id - Post ID
 * @param {int} filter_id - Filter ID 
 * @param {array} arrOptions - array of additional post parameters. It includes: 
     - arrOptions['total'] - number of all posts
     - arrOptions['class_popup'] - class btn popup. Set for btn post. Value: string or empty
     - arrOptions['terms_settings'] - array of all terms with their settings. Value: object with the following properties. Default empty array.            
        - termid - ID term
        - bg - background term. Hex Color Codes (ex: #dd3333)
        - color - color term. Hex Color Codes (ex: #dd3333)
        - class - custom name class of the term
        - status - selected term. Value: checked or empty
        - alignterm - align icon in term
        - coloricon - color icon
        - classicon - name class icon (Font Awesome Icons. ex. far fa-arrow-alt-circle-down) 
        - status - term status (checked)
        - default - (string) default term (checked)
        - name - (string) custom term name
 * @returns {string} HTML markup card post
 */
add_filter('ymc_post_carousel_custom_layout_545_1', function ( $layouts, $post_id, $filter_id, $arrOptions ) {
    $output =  '<h2>Header: '. get_the_title($post_id) .'</h2>';
    $output .= '<div>Content: '. get_the_content($post_id) .'</div>';
	return $output;	
}, 10, 4);
```

**This filter allows you to change the featured custom post layout**
```php
add_filter('ymc_featured_post_custom_layout_FilterID_LayoutID', 'func_custom', 10, 2);
```
Usage example:
```php
/**
 * Creating a featured custom post template
 * @param {string} layout - HTML markup
 * @param {int} post_id - Post ID
 * @param {int} filter_id - Filter ID
 * @param {array} arrOptions - array of additional post parameters. It includes:
- arrOptions['class_popup'] - string class btn popup
- arrOptions['terms_settings'] - (array) array terms settings. Default empty array. List of object properties:
- termid - ID term
- bg - background term. Hex Color Codes (ex: #dd3333)
- color - color term. Hex Color Codes (ex: #dd3333)
- class - custom name class of the term
- status - checked term
- alignterm - align icon in term
- coloricon - color icon
- classicon - name class icon (Font Awesome Icons. ex. far fa-arrow-alt-circle-down)
- status - term status (checked)
- default - (string) default term (checked)
- name - (string) custom term name
 * @returns {string} HTML markup card post
 */
add_filter('ymc_featured_post_custom_layout_545_1', function ( $layouts, $post_id, $filter_id, $arrOptions ) {
    $output =  '<h2>'. get_the_title($post_id) .'</h2>';
    $output .= '<div>'. get_the_content($post_id) .'</div>';
    return $output;	
}, 10, 4);
```


### JS API Filter & Grids

To control the post filter via javascript, use the following methods of the Filter's global YMCTools object. All parameters, their name and values that are passed to the object, are built on the principles and rules of the global WP_Query object in the WordPress core. Therefore, please, refer to the relevant documentation for using the WP_Query object for clarification. All of these methods should be used when creating event handlers. but for example, when clicking on a button or link, call one or another method.

**Note**: calling the YMCTools() object when the page is fully loaded should be placed in the block jQuery(document).on("ready", function () { });
In some cases, this object is used in handler function callbacks.



**This method allows to get posts by ID terms of different taxonomies.**

```js
YMCTools({target: ".data-target-ymcFilterID-LayoutID", terms: "termID"}).apiTermUpdate( option );
```
**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `termID - ID term (String). It is a string data type and is enclosed in quotes. Can set several ID terms separated by commas, for example: "11,35,47"`

**Optional params:**
- `taxRel - define the interaction between different taxonomies in the query. The default is "AND". If set "all" will match the relation "OR". Installed in the admin panel Filter -> Tab Ganeral -> Taxonomy Relation.`
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

Usage example:
```js
     YMCTools({
         target: '.data-target-ymc545-1',
         terms: 'termID'            
     }).apiTermUpdate();  

```

**This method allows to get posts by meta fields.**

```js
YMCTools({target: ".data-target-ymcFilterID-LayoutID", meta: [params]}).apiMetaUpdate( option );
```
All parameters correspond to the parameters of the global WP_Query object. 
To make a correct request, specify all the necessary parameters in JSON format. All parameters in double quotes.

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `meta - (Array) is an array of objects that include in the request settings. All objects must be in josn data format.`

**Optional params:**
- `relation - defines a logical relationship between nested arrays. Default is "AND"`
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

Usage example:
```js
    YMCTools({
	target: '.data-target-ymc545-1',
        meta : [
                 { "relation" : "OR" },
                 { "key" : "color", "value" : "blue" },
                 { "key" : "price", "value" : "10", "compare": "LIKE" },
                 { "key" : "grant_value", "value" : ["100", "200"], "compare": "BETWEEN", "type" : "NUMERIC" }
               ]
	}).apiMetaUpdate();

```

**This method allows to get posts by date.**

```js
YMCTools({target: ".data-target-ymcFilterID-LayoutID", date: [params]}).apiDateUpdate( option );
```
All parameters correspond to the parameters of the global WP_Query object. 
To make a correct request, specify all the necessary parameters in JSON format. All parameters in double quotes.

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `date - (Array) is an array of objects that include in the request settings. All objects must be in josn data format.`

**Optional params:**
- `relation - defines a logical relationship between nested arrays. Default is "AND"`
- `option - (bool) true / false - parameter allows to control sending of request. Default is true` 

Usage example:
```js
      YMCTools({
	  target: '.data-target-ymc545-1',
          date : [                  
                   { "monthnum" : "1", "compare" : "=" },
                   { "year" : "2023", "compare" : "=" },
                   { "day" : "10", "compare" : ">=" }
                ]
	 }).apiDateUpdate();     
	 
```

**This method allows to search for posts by keyword.**

```js
YMCTools({target: ".data-target-ymcFilterID-LayoutID", search: 'keyword'}).apiSearchPosts( option, terms );
```

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `search - (String) Phrase for which posts are searched.`

**Optional params:**
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`
- `terms - (array)  list ids terms. Default is empty`

Usage example:
```js
      YMCTools({
	    target: '.data-target-ymc545-1',
            search: 'keyword',
      }).apiSearchPosts(true, [7,11,15]); 	 
```

**This method allows Include / Exclude posts in the post grid.**

```js
YMCTools({target: ".data-target-ymcFilterID-LayoutID", choicesPosts: '7,9,11', excludePosts: 'off'}).apiChoicesPosts( option );
```

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `choicesPosts - (String) ID posts.`
- `excludePosts - (String) on / off. By default excludePosts is "off"". (Optional)`
**Optional params:**
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

Usage example:
```js
      YMCTools({
	    target: '.data-target-ymc545-1',
            choicesPosts: '7,9,11',
            excludePosts: 'off'
      }).apiChoicesPosts(); 	 
```


**This method allows to sort posts by different criteria.**

```js
YMCTools({target: ".data-target-ymcFilterID-LayoutID", sortOrder: 'asc', sortOrderBy: 'title'}).apiSortPosts( option );
```

**Required params:**
- `.data-target-ymcFilterID-LayoutID - class name of the filter container on the page.`
- `sortOrder - (String) asc / desc.`
- `sortOrderBy - (String) List of fields for sorting posts: ID, author, title, name, date, modified, type, parent, rand, comment_count. If set meta key set options: meta_value or meta_value_num (for numbers) to sort by meta field`
  
**Optional params:**
- `metaKey - (String) Value of meta_key parameter (field data key).`
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

Usage example:
```js
        YMCTools({
          target: '.data-target-ymc545-1',
          sortOrder: 'desc',
          sortOrderBy: 'meta_value_num',
          metaKey: 'amount'
        }).apiSortPosts(); 	 
```

**This method allows to clear query parameters in the filter by terms.**

```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiTermClear( option );
```
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

**This method allows to clear query parameters in the filter by meta fields.**

```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiMetaClear( option );
```
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

**This method allows to clear query parameters in the filter by date.**

```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiDateClear( option );
```
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

**This method allows to clear sort parameters in the filter by sort posts.**

```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiSortClear( option );
```
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

**This method allows you to clear the query parameters in the filter by the first letter of the alphabet.**
```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiLetterAlphabetClear( option );
```
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`

**This method allows you to make a request to receive posts by previously specified parameters.**

```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiGetPosts();
```

First we change the request parameters, and then we send the data. You should pass the value false to the methods parameters.

Usage example:
```js
YMCTools({
  target: '.data-target-ymc545-1',
  terms: '5,7,9'
}).apiTermUpdate(false);

YMCTools({
  target: '.data-target-ymc545-1',
  meta : [ { "key" : "amount", "value" : "100" } ]
}).apiMetaUpdate(false);        

YMCTools({target: '.data-target-ymc545-1'}).apiGetPosts();	 
```

**This method allows you to move to a specific page of posts in grid.**

```js
YMCTools({target: '.data-target-ymcFilterID-LayoutID'}).apiPageUpdated( page );
```
- `page - (Number) - page number in the grid Default is 1`

Usage example:
```js
YMCTools({ target: '.data-target-ymc545-1'}).apiPageUpdated(3); 
```

**This method allows you to open a popup post and load content into it.**

```js
YMCTools({ target: '.data-target-ymcFilterID-LayoutID' }).apiPopup( postID );
```
**Required params:**
- `postID - (Number) - post ID`

Usage example:
```js
YMCTools({ target: '.data-target-ymc545-1'}).apiPopup(15); 
```

**This method allows you to display different post types with their different taxonomies in a grid.**

**Required params:**
```js
YMCTools({ target: '.data-target-ymcFilterID-LayoutID' }).apiMultiplePosts( option, cpt = '', tax = '', terms = '' );
```
- `option - (bool) true / false - parameter allows to control sending of request. Default is true`
- `cpt - name of post types (String). Can set several post types separated by commas, for example: "blogs,books"`
- `tax - name of taxonomies (String). Can set several taxonomies separated by commas, for example: "people,science"`
- `terms - ID terms (String). Create a list of all terms related to all specified taxonomies, separated by commas, for example: “11,35,47,55,77,95”.`
- `IMPORTANT! Define the relationship between different taxonomies in a query. The default is "AND".
   Set the option to "OR" to display all posts in the grid. This can be configured in the admin panel Filter -> General Tab -> Taxonomy. `


`Let's override the global filter settings. To do this, stop loading posts and run the filter with new updated parameters:`

Usage example:
```js
wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(el) {
   if( el.classList.contains('data-target-ymc545-1') ) {
   el.dataset.loading = 'false';

   YMCTools({
      target: '.data-target-ymc545-1'
   }).apiMultiplePosts( 
          true,
          'post,books',
          'category,people,science',
          '5,6,19,15,20,7,55'
   );
}
});
```


### Hooks JS.

**Note**: hooks should be used in: 

**Vanilla javascript**
- addEventListener('DOMContentLoaded', (event) => {});
 
**jQuery**
- $(document).on('ready', function() {});

**Stop loading posts on page load.**

```js
wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', 'callback(elem)');
```
Set the selected filter's data-loading attribute to false ( data-loading="false" )

**Params function callback:**
- `elem - DOM container filter.`

Usage example:
```js
wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(elem) {
     if( elem.classList.contains('data-target-ymc545-1') ) {
            elem.dataset.loading = 'false';
     }
});
```

**Note**: this hook only works when the page is loaded. By default, it stops all posts from loading. Therefore, inside this hook, you must specify the class of the selected filter.


**Before loaded all posts.**

```js
wp.hooks.addAction('ymc_before_loaded_data', 'smartfilter', 'callback(class_name)');
wp.hooks.addAction('ymc_before_loaded_data_FilterID', 'smartfilter', 'callback(class_name)');
wp.hooks.addAction('ymc_before_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name)');
```

Hook works before loading all posts.

**Params function callback:**
- `class_name - is the name of the filter container class.`

Usage example:
```js
wp.hooks.addAction('ymc_before_loaded_data_545_1', 'smartfilter', function(class_name){
   console.log('Before loading all posts: ' + class_name);
});
```



**After loaded all posts.** 

```js
wp.hooks.addAction('ymc_after_loaded_data', 'smartfilter', 'callback(class_name, response)');
wp.hooks.addAction('ymc_after_loaded_data_FilterID', 'smartfilter', 'callback(class_name, response)');
wp.hooks.addAction('ymc_after_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name, response)');
```

Hook works after loading all posts.

**Params function callback:**
- `class_name - is the name of the filter container class.`
- `response - returned data object, includes the following properties:`
  - `post_count - number of displayed posts per page;`
  - `max_num_pages - maximum number of pages;`
  - `found - number of found posts;`
  - `post_type - post type name;`


Usage example:
```js
wp.hooks.addAction('ymc_after_loaded_data_545_1', 'smartfilter', function(class_name, response){
      console.log('Container class: ' + class_name);
      console.log('Post count: ' + response.post_count);
      console.log('Number of found posts: ' + response.found);
   });
```

**Complete loaded all data.**

This hook is called regardless of if the request was successful, or not. 
You will always receive a complete callback, even for synchronous requests.

```js
wp.hooks.addAction('ymc_complete_loaded_data', 'smartfilter', 'callback(class_name, status)');
wp.hooks.addAction('ymc_complete_loaded_data_FilterID', 'smartfilter', 'callback(class_name, status)');
wp.hooks.addAction('ymc_complete_loaded_data_FilterID_LayoutID', 'smartfilter', 'callback(class_name, status)');
```

**Params function callback:**
- `class_name - is the name of the filter container class.`
- `status - a string categorizing the status of the request ("success", "notmodified", "nocontent", "error", "timeout", "abort", or "parsererror").`

Usage example:
```js
wp.hooks.addAction('ymc_complete_loaded_data_545_1', 'smartfilter', function(class_name, status){
      console.log('Complete loaded all data:' + class_name + ' status:' + status);
   });
```

**An example of using hooks in combination with the YMCTools object and its methods**

Stop loading posts for the selected filter and then load posts for the selected term

Usage example:
```js 
    wp.hooks.addAction('ymc_stop_loading_data', 'smartfilter', function(el){
        if( el.classList.contains('data-target-ymc545-1') ) {
            el.dataset.loading = 'false';
           
            YMCTools({
               target: '.data-target-ymc545-1',
               terms: '7'
            }).apiTermUpdate();           
        }
    });    

```

**Calling a script point before / after opening a popup and loading content into it.**

This hook allows you to run any desired script after opening a popup for each post

```js
wp.hooks.addAction('ymc_before_popup_open', 'smartfilter', 'callback');
wp.hooks.addAction('ymc_before_popup_open_FilterID', 'smartfilter', 'callback');
wp.hooks.addAction('ymc_before_popup_open_FilterID_LayoutID', 'smartfilter', 'callback');

wp.hooks.addAction('ymc_after_popup_open', 'smartfilter', 'callback(data)');
wp.hooks.addAction('ymc_after_popup_open_FilterID', 'smartfilter', 'callback(data)');
wp.hooks.addAction('ymc_after_popup_open_FilterID_LayoutID', 'smartfilter', 'callback(data)');
```

**Change custom preloader:**

This filter allows you to override preloader when loading grid posts or other content into opening popups.
```js
wp.hooks.addFilter('ymc_custom_popup_preloader', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_custom_popup_preloader_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_custom_popup_preloader_FilterID_LayoutID', 'smartfilter', 'callback');

wp.hooks.addFilter('ymc_custom_grid_preloader', 'smartfilter', 'callback(data)');
wp.hooks.addFilter('ymc_custom_grid_preloader_FilterID', 'smartfilter', 'callback(data)');
wp.hooks.addFilter('ymc_custom_grid_preloader_FilterID_LayoutID', 'smartfilter', 'callback(data)');
```
Usage example:
```js 
wp.hooks.addFilter('ymc_custom_popup_preloader_545_1', 'smartfilter', function(stylePreloader) {
    stylePreloader = '/wp-content/themes/myTheme/images/icon.svg';
    return stylePreloader;
});
```

**Params function callback:**
- `data - data that is loaded into the popup container.`
  
Usage example:
```js 
wp.hooks.addAction('ymc_after_popup_open_545_1', 'smartfilter', function(data){
    console.log('Loaded data: '  + data);
}); 
```


### Masonry Layout.

To build post cards in Masonry form, use the ymc_after_loaded_data_FilterID_LayoutID hooks and the Masonry mini library MagicGrid. To do this, you need to use the following code:
The MagicGrid object has the following settings:

- `container: "#container", // Required. Can be a class, id, or an HTMLElement.`
- `static: false, // Required for static content. Default: false.`
- `items: 30, // Required for dynamic content. Initial number of items in the container.`
- `gutter: 30, // Optional. Space between items. Default: 25(px).`
- `maxColumns: 5, // Optional. Maximum number of columns. Default: Infinite.`
- `useMin: true, // Optional. Prioritize shorter columns when positioning items? Default: false.`
- `useTransform: true, // Optional. Position items using CSS transform? Default: True.`
- `animate: true, // Optional. Animate item positioning? Default: false.`
- `center: true, //Optional. Center the grid items? Default: true.`

To correctly display the grid, set styles for the post item, for example:

```css
    .data-target-ymc1 .container-posts .post-entry .post-item {
        width: 250px;
    }
```

Usage example:
```js
wp.hooks.addAction('ymc_after_loaded_data_545_1', 'smartfilter', function(class_name, response) {
    const magicGrid = new MagicGrid({
          container: '.' + class_name + ' .post-entry',
          items: response.post_count,
          center: false,
          gutter: 20                
   });    
   magicGrid.listen();
});
```

**List of Filters and Actions to override default settings of the Masonry Grid**
```js
// Space between items
wp.hooks.addFilter('ymc_magicGrid_gutter', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_gutter_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_gutter_FilterID_LayoutID', 'smartfilter', 'callback');

// Maximum number of columns
wp.hooks.addFilter('ymc_magicGrid_maxColumns', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_maxColumns_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_maxColumns_FilterID_LayoutID', 'smartfilter', 'callback');

// Prioritize shorter columns when positioning items
wp.hooks.addFilter('ymc_magicGrid_useMin', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_useMin_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_useMin_FilterID_LayoutID', 'smartfilter', 'callback');

// Position items using CSS transform
wp.hooks.addFilter('ymc_magicGrid_useTransform', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_useTransform_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_useTransform_FilterID_LayoutID', 'smartfilter', 'callback');

// Animate item positioning
wp.hooks.addFilter('ymc_magicGrid_animate', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_animate_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_animate_FilterID_LayoutID', 'smartfilter', 'callback');

// Center the grid items
wp.hooks.addFilter('ymc_magicGrid_center', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_center_FilterID', 'smartfilter', 'callback');
wp.hooks.addFilter('ymc_magicGrid_center_FilterID_LayoutID', 'smartfilter', 'callback');

// Adds a listener that executes a function once the grid is ready.
wp.hooks.addAction('ymc_magicGrid_ready', 'smartfilter', 'callback');
wp.hooks.addAction('ymc_magicGrid_ready_FilterID', 'smartfilter', 'callback');
wp.hooks.addAction('ymc_magicGrid_ready_FilterID_LayoutID', 'smartfilter', 'callback');

// Adds a listener that executes a function whenever positionItems is called. Note: positionItems is called during initial setup and whenever the container or window is resized
wp.hooks.addAction('ymc_magicGrid_position_complete', 'smartfilter', 'callback');
wp.hooks.addAction('ymc_magicGrid_position_complete_FilterID', 'smartfilter', 'callback');
wp.hooks.addAction('ymc_magicGrid_position_complete_FilterID_LayoutID', 'smartfilter', 'callback');
```
Usage example:
```js
wp.hooks.addFilter('ymc_magicGrid_gutter_545_1', 'smartfilter', function(gutter) {
    gutter = 30; // Change the space between items
    return gutter;
});

wp.hooks.addAction('ymc_magicGrid_ready_545_1', 'smartfilter', function() {
    console.log('Magic Grid Ready'); // Example function
});

wp.hooks.addAction('ymc_magicGrid_position_complete_545_1', 'smartfilter', function() {
    console.log("Grid Has Been Resized"); // Example function
});
```

### Advanced Query.
When using a plugin that displays different posts based on different criteria, there are built-in settings to control which posts are displayed, so you can choose how many to display, include or exclude terms, change the order, etc. However, if you need more complex queries, The plugin offers an "Advanced" query type that allows you to return exactly the arguments you need for your query.
To do this, you will need to enable the ability to use your own query based on the global WP_query object. Go to the Advanced -> Advanced Query tab and turn the slider to "ON".
Once this setting is enabled, you will see a new field called Query Type. From the drop-down list, select one of two ways to build a query:
- Advanced (custom arguments)
- Callback (theme function)

##### **Query String (custom arguments)**

A [query string](https://www.php.net/manual/en/function.http-build-query.php) is a string that contains parameters which looks something like this:
```php
posts_per_page=-1&post_type=portfolio&post_status=publish&orderby=title&tax_query[0][taxonomy]=portfolio_category&tax_query[0][field]=slug&tax_query[0][terms][]=inspiration
```
##### **Callback Function**
To use a callback for your query arguments simply enter your function name in the field and then add this function to your child theme's functions.php file. Your function should have a unique name and return an array of the arguments to pass onto WP_Query.
Whitelisting Callbacks - **Important!** Your callback functions must be whitelisted in order for them to work. This is an important security measure.
How to Whitelist Callback Functions for Elements? 
In order to white list functions you need to define the “YMC_CALLBACK_FUNCTION_WHITELIST” constant via your child theme.

```php
/*
 * White list functions for use in Theme Core functions.php shortcodes.
 */
 
 if ( ! defined( 'YMC_CALLBACK_FUNCTION_WHITELIST' ) ) { 
 
     define( 'YMC_CALLBACK_FUNCTION_WHITELIST', array(
        'my_custom_function_name_1',
        'my_custom_function_name_2',
        'my_custom_function_name_3',
    ) ); 
 }
 

```
Once you have defined the YMC_CALLBACK_FUNCTION_WHITELIST constant, you can register (define) a function from an existing list in an array.<br>
The $atts function argument is an array of dynamic data set in the plugin settings.
- $atts['cpt']  - ( Array ) array of selected post types
- $atts['tax']  - ( Array | Bool ) array of all selected taxonomies or false
- $atts['term'] - ( Array | Bool ) array of all taxonomy terms or false
- 
Example of use:
```php
function my_custom_function_name_1( $atts ) {

   	$term_ids = [];

    // Get all terms related to the post_tag taxonomy
	if( is_array($atts['term']) && ! empty($atts['term']) ) :

		foreach ( $atts['term'] as $term ) :
			if( 'post_tag' === get_term( $term )->taxonomy) :
				$term_ids[] = (int) $term;
			endif;
		endforeach;

	endif;

	return [
		'post_type' => ['post'],
		'posts_per_page' => 9,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => [6, 7, 15]
			),
			array(
				'taxonomy' => 'post_tag',
				'field' => 'id',
				'terms' => $term_ids
			),
		)
	];
}
```

After that, in the plugin settings, add the new function you registered to the list.
Building your queries: Check out the **[WordPress WP_Query Codex](https://developer.wordpress.org/reference/classes/wp_query/)** for all the different parameters you can use in the your query.

### Visual Hook Guide: Grid Posts
![This is an image](/includes/assets/images/Visual_Hook_Guide.png)

### Support
For support questions, please write to: wss.office21@gmail.com

### Youtube
https://www.youtube.com/watch?v=FIBNE0Ix6Vg


