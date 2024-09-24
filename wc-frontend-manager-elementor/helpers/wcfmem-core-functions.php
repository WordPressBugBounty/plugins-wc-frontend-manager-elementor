<?php
require_once 'class-wcfmem-dependencies.php';

if ( ! function_exists( 'wcfmem_fail_load_for_elementor' ) ) {
	function wcfmem_fail_load_for_elementor() {
		$screen = get_current_screen();
		$message = '';
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		$plugin = 'elementor/elementor.php';
		if ( WCFMem_Dependencies::wcfmem_is_elementor_installed() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$message = '<h3>' . esc_html__( 'Activate the Elementor Plugin', 'wc-frontend-manager-elementor' ) . '</h3>';
			$message .= '<p>' . esc_html__( 'Before you can use all the features of WCFM - WooCommerce Multivendor Marketplace - Elementor, you need to activate the Elementor plugin first.', 'wc-frontend-manager-elementor' ) . '</p>';
			$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Now', 'wc-frontend-manager-elementor' ) ) . '</p>';
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$message = '<h3>' . esc_html__( 'Install and Activate the Elementor Plugin', 'wc-frontend-manager-elementor' ) . '</h3>';
			$message .= '<p>' . esc_html__( 'Before you can use all the features of WCFM - WooCommerce Multivendor Marketplace - Elementor, you need to install and activate the Elementor plugin first.', 'wc-frontend-manager-elementor' ) . '</p>';
			$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor', 'wc-frontend-manager-elementor' ) ) . '</p>';
		}
		wcfmem_print_error( $message );
	}
}

if ( ! function_exists( 'wcfmem_fail_load_for_elementor_pro' ) ) {
	function wcfmem_fail_load_for_elementor_pro() {
		$screen = get_current_screen();
		$message = '';
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		//if ( !WCFMem_Dependencies::elementor_pro_plugin_active_check() ) {
			$message = '<h3>' . esc_html__( 'Activate the Elementor Pro Plugin', 'wc-frontend-manager-elementor' ) . '</h3>';
			$message .= '<p>' . esc_html__( 'Before you can use all the features of WCFM - WooCommerce Multivendor Marketplace - Elementor, you need to activate the Elementor Pro plugin first.', 'wc-frontend-manager-elementor' ) . '</p>';
		//}
		wcfmem_print_error( $message );
	}
}

if ( ! function_exists( 'wcfmem_fail_load_for_wcfmmp' ) ) {
	function wcfmem_fail_load_for_wcfmmp() {
		$screen = get_current_screen();
		$message = '';
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		// $message = '<h3>' . esc_html__( 'Activate the WCFM - WooCommerce Multivendor Marketplace Plugin', 'wc-frontend-manager-elementor' ) . '</h3>';
		// $message .= '<p>' . esc_html__( 'Before you can use all the features of WCFM - WooCommerce Multivendor Marketplace - Elementor, you need to activate the WCFM - WooCommerce Multivendor Marketplace plugin first.', 'wc-frontend-manager-elementor' ) . '</p>';
		$message = sprintf( __( '%sWooCommerce Multivendor Marketplace - Elementor is inactive.%s The %sWCFM Marketplace plugin%s must be active for the WooCommerce Multivendor Marketplace - Elementor to work. Please %sinstall & activate WCFM Marketplace%s', 'wc-frontend-manager-elementor' ), '<strong>', '</strong>', '<a target="_blank" href="https://wordpress.org/plugins/wc-multivendor-marketplace/">', '</a>', '<a href="' . admin_url( 'plugin-install.php?tab=search&s=wcfm-multivendor-marketplace' ) . '">', '&nbsp;&raquo;</a>' );
		wcfmem_print_error( $message );
	}
}

if ( ! function_exists( 'wcfmem_fail_load_for_wcfm' ) ) {
	function wcfmem_fail_load_for_wcfm() {
		$screen = get_current_screen();
		$message = '';
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		$message = sprintf( __( '%sWooCommerce Multivendor Marketplace - Elementor is inactive.%s The %sWooCommerce Frontend Manager plugin%s must be active for the WooCommerce Multivendor Marketplace - Elementor to work. Please %sinstall & activate WooCommerce Frontend Manager%s', 'wc-frontend-manager-elementor' ), '<strong>', '</strong>', '<a target="_blank" href="https://wordpress.org/plugins/wc-frontend-manager/">', '</a>', '<a href="' . admin_url( 'plugin-install.php?tab=search&s=wcfm-frontend-manager' ) . '">', '&nbsp;&raquo;</a>' );
		wcfmem_print_error( $message );
	}
}

if ( ! function_exists( 'wcfmem_fail_load_for_woocemmerce' ) ) {
	function wcfmem_fail_load_for_woocemmerce() {
		$screen = get_current_screen();
		$message = '';
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		$message = sprintf( __( '%sWooCommerce Multivendor Marketplace - Elementor is inactive.%s The %sWooCommerce plugin%s must be active for the WooCommerce Multivendor Marketplace - Elementor to work. Please %sinstall & activate WooCommerce%s', 'wc-frontend-manager-elementor' ), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/woocommerce/">', '</a>', '<a href="' . admin_url( 'plugin-install.php?tab=search&s=woocommerce' ) . '">', '&nbsp;&raquo;</a>' );
		wcfmem_print_error( $message );
	}
}
if ( ! function_exists( 'wcfmem_fail_minimum_elementor_version' ) ) {
	function wcfmem_fail_minimum_elementor_version() {
		$screen = get_current_screen();
		$message = '';
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		$message = sprintf( __( '%sWooCommerce Multivendor Marketplace - Elementor is inactive.%s The %sElementor plugin%s must be of version %s for the WooCommerce Multivendor Marketplace - Elementor to work.', 'wc-frontend-manager-elementor' ), '<strong>', '</strong>', '<a target="_blank" href="http://wordpress.org/extend/plugins/elementor/">', '</a>', WCFMem_MINIMUM_ELEMENTOR_VERSION );
			wcfmem_print_error( $message );
	}
}





function wcfmem_print_error( $message ) {
	if ( ! $message ) {
		return;
	}
	// PHPCS - $message should not be escaped
	echo '<div class="error"><p>' . $message . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}