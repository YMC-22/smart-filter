<?php

namespace YMC_Smart_Filters;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Autoloader {

	public static function run() {

		spl_autoload_register(function( $class_name ) {

			if ( false === strpos( $class_name, 'YMC_Smart_Filters' ) ) return;

			$file_parts = explode( '\\', $class_name );

			$namespace = '';

			for ( $i = count( $file_parts ) - 1; $i > 0; $i-- ) {

				$current =  $file_parts[ $i ];

				if ( count( $file_parts ) - 1 === $i ) {
					$file_name = $current . ".php";
				}
				else {
					$namespace = DIRECTORY_SEPARATOR . $current . $namespace;
				}
			}

			$filepath  = YMC_SMART_FILTER_DIR . 'includes' . strtolower($namespace) . DIRECTORY_SEPARATOR;
			$filepath .= $file_name;

			if ( is_readable( $filepath ) ) {
				require $filepath;
			}

		});

	}

}