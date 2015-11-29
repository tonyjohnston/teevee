<?php
/*
Plugin Name: AppleTV Bridge
Plugin URI: https://github.com/ohryan/teevee
Version: 1.0
Author: Ryan Neudorf
Author URI: https://ohryan.ca/
License: MIT
*/

namespace ohryan\TeeVee;

require_once 'classes/TeeVee_Core.php';
// require_once 'classes/TeeVee_Admin.php';
require_once 'classes/TeeVee.php';

/**
 * Initialize the metabox class.
 */
add_action( 'init', __NAMESPACE__.'\\cmb_initialize_cmb_meta_boxes', 9999 );
function cmb_initialize_cmb_meta_boxes() {
	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'lib/cmb2/init.php';
}

// set up custom post type stuff
$TVC = new TeeVee_Core();
register_activation_hook( __FILE__, array($TVC, 'activation') );
register_deactivation_hook( __FILE__, array($TVC, 'deactivation') );
add_action( 'init', array($TVC, 'init'), 0 );


add_filter( 'send_headers', __NAMESPACE__.'\\teeveesendheaders' );

function teeveesendheaders() {
	if ( WP_DEBUG == true) { 
		header( 'Cache-Control: max-age=1' ); // 1 minute cache if we're debugging.
	} else {
		header( 'Cache-Control: max-age=15'); // maybe make this configurable?
	}
	
}


add_filter( 'template_include', __NAMESPACE__.'\\template_loader');

function template_loader( $template ) {

	if ( get_query_var('teeveeclient', false) ) {
		if ( get_query_var('teevee-template', false) ) {

			$TeeVee = new TeeVee();

			switch (get_query_var('teevee-template', false)) {
				case 'index.xml.js':
					$series = $TeeVee->get_series(); 
					$template = $TeeVee->load_template( 'menubar.xml', $series );
					break;

				case 'list.xml.js':
					if ( intval($_GET['id']) || $_GET['id'] == 'latest' ) {
						if ( $_GET['id'] == 'latest' ) {
							$episodes = $TeeVee->get_latest_episodes();
							$list_title = 'Latest Episodes';
						} else {
							$term_id = intval($_GET['id']);
							$list_title = $TeeVee->get_series_title( $term_id );
							if ( $list_title ) {
								$list_title = $list_title->name;
								$episodes = $TeeVee->get_episodes_by_series( $term_id );	
							} else {
								$template = $TeeVee->http_error();
							}
							
						}

						if ( is_array( $episodes ) && count( $episodes) > 0 ) {
							$template = $TeeVee->load_template( 'list.xml', $episodes, $list_title );		
						} else {
							$template = $TeeVee->http_error();
						}

						
					} else {
						$template = $TeeVee->http_error();
					}
					break;
				
				default:
					$template = $TeeVee->http_error();
					break;
			}
		} else if ( get_query_var('teevee-js', false ) ) {
			$js_file_php = strtolower(get_query_var('teevee-js')).'.php';

			if ( in_array( $js_file_php, array('application.js.php','presenter.js.php','resourceloader.js.php') ) ) {
				include(plugin_dir_path(__FILE__).'js/'.$js_file_php);
				$template = '';
			} else {
				header('HTTP/1.0 404 Not Found');
				exit;
			}
		}

	}
	return $template;	
}

?>