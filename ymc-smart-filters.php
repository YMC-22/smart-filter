<?php

/**
 *
 * Plugin Name:       Filter & Grids
 * Description:       Filter posts by categories without reloading the page. Create posts grids.
 * Version:           2.6.6
 * Author:            YMC
 * Author URI:        https://github.com/YMC-22/smart-filter
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ymc-smart-filter
 *
 * Copyright 2022-2023 YMC (email : wss.office21@gmail.com)
 *
 * Filter & Grids is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Filter & Grids is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Password. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**-------------------------------------------------------------------------------
 *    DEFINES
 * -------------------------------------------------------------------------------*/

if ( ! defined('YMC_SMART_FILTER_VERSION') ) {

	define( 'YMC_SMART_FILTER_VERSION', '2.6.6' );
}

if ( ! defined('YMC_SMART_FILTER_DIR') ) {

	define( 'YMC_SMART_FILTER_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined('YMC_SMART_FILTER_URL') ) {

	define( 'YMC_SMART_FILTER_URL', plugins_url( '/', __FILE__ ) );
}


require_once( plugin_dir_path( __FILE__ ) . 'includes/Plugin.php' );


