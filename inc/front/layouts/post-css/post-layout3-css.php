<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Style
$post_css = ".container-posts .post-entry {color:red;}";

wp_add_inline_style($handle, $post_css);



