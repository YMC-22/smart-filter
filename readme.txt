===  Smart Filter ===
Plugin Name: Smart Filter
Contributors: YMC, Roman
Version: 2.2.5
Donate link: https://www.paypal.com/donate/?hosted_button_id=B2MHM5LM29UGW
Tags: filters, posts, mind, ajax posts, category posts, taxonomy, custom taxonomy, woocommerce
Requires at least: 4.8
Tested up to: 6.2
Stable tag: 2.2.4
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Filter posts or custom post types by custom taxonomy / category without page reload with different pagination types.

== Description ==

Filter posts or custom post types by custom taxonomy / category without page reload with different pagination types. Plugin allows to solve a variety of tasks for displaying posts on site pages. For advanced developers, there is an opportunity to independently develop layouts for filters and post cards, which makes the plugin universal.

== Custom Post Type & Taxonomies Support ==
The plugin supports custom post types. You can filter custom post types with the AJAX filter. You can select specific custom taxonomies and their terms to showcase. If you need to create your custom filter bar or custom post card, you can use the filters which will allow you to create your templates. This requires a basic understanding of HTML JavaScript, CSS and PHP languages. You can find more details <a href='https://github.com/YMC-22/smart-filter' target='_blank'>here.</a>

== Plugin Features ==
The plugin provides the following functionality:
- Sorting taxonomies and terms.
- Installation of different types of pagination (Numeric, Load more, Scroll infinity).
- Choice of different templates for filters and post cards.
- Sorting posts on the frontend
- Manual sorting of terms
- Customization of the color palette.
- Adding a post search bar.
- Typography customization.
- Ability to independently develop templates for filters and post cards and add them to the filter (requires basic knowledge of WordPress, HTML JavaScript, CSS and PHP).
- Flexible filter management via Javascript API
- JS hooks. Ability to manage asynchronous filter operations.
- Support Masonry Layout

== Installation ==

1. Activate Plugin or upload the entire 'ymc-smart-filters' folder to the '/wp-content/plugins/' directory.
2. Add new YMC Smart Filter
3. Copy YMC Smart Filter shortcode and paste to any page or post
4. Set setting for each post


== ScreenShots ==
1. Individual Setting Filter
2. Use Shortcode Filter with search filed
3. Display filter on the page
4. Example work filter


== Frequently Asked Questions ==

=  Is YMC Smart Filter free? =

Yes, YMC Smart Filter is a free WordPress plugin.

= Where can I find the Documentation for the plugin? =

Detailed information can be found on GitHub at this <a target="_blank" href="https://github.com/YMC-22/smart-filter">link</a>.

== Changelog ==

= 1.1.1 =
* Added ability to filter Products from WooCommerce plugin.
= 1.2.0 =
* Added sorting of posts on the frontend
= 1.2.2 =
* Add filter ymc_posts_selected_ID
= 1.2.3 =
* Add filter ymc_sort_posts_by_ID
= 1.2.4 =
* Fixed file js (frontend)
= 1.2.5 =
* Added criteria for filtering posts by the criterion Menu Order (backeend)
= 1.2.6 =
* Added the ability to customize posts (filter: ymc_post_custom_layout_ID)
= 1.2.7 =
Fixed all filters on the plugin. Changed numbering in filter names. See documentation.
= 1.2.8 =
Added the ability to interact with the filter through javascript. Implemented API methods of YMCTools object for filtering posts by criteria:
- meta fields
- date fields
- taxonomy terms
= 1.2.9 =
Added the ability to hide / show the pagination panel in the admin panel
= 1.3.0 =
Javascript hooks added
= 1.3.1 =
Fixed css in layouts posts
= 2.1.0 =
Plugin core updated. Before updating. Create a backup copy of website.
= 2.1.1 =
Fixed css
= 2.1.2 =
Fixed js
= 2.1.3 =
Added the ability to display posts by masonry grid
= 2.1.4 =
Fixed css
= 2.1.5 =
Fixed results search
= 2.2.1 =
Implemented the ability to manually sort terms in the context of taxonomy
= 2.2.4 =
Fixed js
= 2.2.5 =
Add API JS search posts


== Video ==
https://www.youtube.com/watch?v=FIBNE0Ix6Vg