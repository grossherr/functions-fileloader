<?php
/*
 Plugin Name:  Functions Fileloader
 Plugin URI:   https://github.com/grossherr/functions-fileloader
 GitHub Plugin URI: grossherr/functions-fileloader
 Description:  WordPress Plugin for loading files from the functions.php
 Version:      0.6
 Author:       Nicolai
 Author URI:   https://ngcorp.de
 License:      GPL3
 License URI:  https://www.gnu.org/licenses/gpl-3.0.html
 */

//Load Class
require_once( dirname( __FILE__ ) . '/includes/class-file-loader.php' );
//Load Function
require_once( dirname( __FILE__ ) . '/includes/function-file-loader.php' );
