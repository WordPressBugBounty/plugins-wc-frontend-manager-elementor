<?php
/**
 * Plugin Name: WCFM - WooCommerce Multivendor Marketplace - Elementor
 * Plugin URI: https://wclovers.com/
 * Description: Create your marketplace store pages using Elementor with your own design. Easily and Beatifully.
 * Author: WC Lovers
 * Version: 3.0.4
 * Author URI: https://wclovers.com
 *
 * Text Domain: wc-frontend-manager-elementor
 * Domain Path: /lang/
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 9.3.0
 * 
 * Elementor tested up to: 3.24.2
 * Elementor Pro tested up to: 3.24.1
 *
 */

if(!defined('ABSPATH')) exit; // Exit if accessed directly

if ( ! class_exists( 'WCFMem_Dependencies' ) )
	require_once 'helpers/class-wcfmem-dependencies.php';

require_once 'wc-frontend-manager-elementor-config.php';
require_once 'helpers/wcfmem-core-functions.php';


/**
 * WCFM Elementor plugin core Dependency check and load
 *
 * @since 1.0.0
 *
 * @return void
 */

add_action( 'plugins_loaded', 'wcfmem_load_plugin' , 9 );
function wcfmem_load_plugin() {

	
	if( !WCFMem_Dependencies::woocommerce_plugin_active_check() ) {
		add_action( 'admin_notices', 'wcfmem_fail_load_for_woocemmerce' );
		return;
	}

	if( !WCFMem_Dependencies::wcfm_plugin_active_check() ) {
		add_action( 'admin_notices', 'wcfmem_fail_load_for_wcfm' );
		return;
	}

	if( !WCFMem_Dependencies::wcfmmp_plugin_active_check() ) {
		add_action( 'admin_notices', 'wcfmem_fail_load_for_wcfmmp' );
		return;
	}
	
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'wcfmem_fail_load_for_elementor' );
		return;
	}

	// Check for required Elementor version
	if ( ! version_compare( ELEMENTOR_VERSION, WCFMem_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
		add_action( 'admin_notices', 'wcfmem_fail_minimum_elementor_version' );
		return;
	}

	if( !WCFMem_Dependencies::elementor_pro_plugin_active_check() ) {
		add_action( 'admin_notices', 'wcfmem_fail_load_for_elementor_pro' );
		return;
	}

	if(!class_exists('WCFM_Elementor')) {
		
		include_once( 'core/class-wcfmem.php' );
		global $WCFM, $WCFMem, $WCFM_Query;
		$WCFMem = new WCFM_Elementor( __FILE__ );
		$GLOBALS['WCFMem'] = $WCFMem;
	}

}