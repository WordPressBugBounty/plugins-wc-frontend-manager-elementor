<?php
/**
 * WCFM Elementor plugin core
 *
 * Plugin intiate
 *
 * @author 		WC Lovers
 * @package 	wc-frontend-manager-elementor
 * @version   1.0.0
 */
 
final class WCFM_Elementor {
  	public $plugin_base_name;
	public $plugin_url;
	public $plugin_path;
	public $version;
	public $token;
	public $text_domain;
	public $file;

  public function __construct($file) {
		$this->file = $file;
		$this->plugin_base_name = plugin_basename( $file );
		$this->plugin_url = trailingslashit(plugins_url('', $plugin = $file));
		$this->plugin_path = trailingslashit(dirname($file));
		$this->token = WCFMem_TOKEN;
		$this->text_domain = WCFMem_TEXT_DOMAIN;
		$this->version = WCFMem_VERSION;
		
		add_action( 'elementor/init', array( &$this, 'wcfmem_init' ) );
		add_action( 'before_woocommerce_init', array(&$this, 'declare_hpos_compatibility') );
		
	}

	public function declare_hpos_compatibility() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', 'wc-frontend-manager-elementor/wc-frontend-manager-elementor.php', true );
		}
	}

	public function wcfmem_init() {
		$this->load_plugin_textdomain();
		require_once $this->plugin_path . 'helpers/wcfmem-elementor-position-controls.php';
		// Widgets Base Load
		$this->load_class( 'widgets' );
	  new WCFM_Elementor_WidgetBase();

		// Document Base Load
		$this->load_class( 'documents' );
	  new WCFM_Elementor_DocumentBase();

		// Controls
		$this->load_class( 'controls' );
		new WCFM_Elementor_ControlsBase();
		
		//Dynamic Tag Base Load
		$this->load_class( 'dynamic_tags' );
	  new WCFM_Elementor_DynamicTagsBase();

		$this->load_class( 'conditions' );
	  new WCFM_Elementor_ConditionsBase();

		// Templates
		$this->load_class( 'templates' );
	  new WCFM_Elementor_Templates();

		add_action( 'elementor/editor/footer', [ $this, 'add_editor_templates' ], 9 );
		add_filter( 'wcfmem_locate_store_template', [ $this, 'locate_template_for_store_page' ], 999 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
		
	}

	/**
	 * Add editor templates
	 *
	 * @return void
	 */
	public function add_editor_templates() {
		global $WCFM, $WCFMem;
		
		$template_names = [
				'sortable-list-row',
		];

		foreach ( $template_names as $template_name ) {
			$WCFMem->wcfmem_elementor()->common->add_template( $WCFMem->plugin_path . "views/editor-templates/$template_name.php" );
		}
	}

	/**
	 * Filter to show the elementor built store template
	 *
	 * @return string
	 */
	public static function locate_template_for_store_page( $template ) {
		global $WCFM, $WCFMem;
		
		if ( wcfmmp_is_store_page() ) {
			$documents = \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager()->get_documents_for_location( 'single' );

			if ( empty( $documents ) ) {
				return $template;
			}

			$page_templates_module = $WCFMem->wcfmem_elementor()->modules_manager->get_modules( 'page-templates' );

			$page_templates_module->set_print_callback( function() {
					\ElementorPro\Modules\ThemeBuilder\Module::instance()->get_locations_manager()->do_location( 'single' );
			} );

			$template_path = $page_templates_module->get_template_path( $page_templates_module::TEMPLATE_HEADER_FOOTER );

			return $template_path;
		}

		return $template;
	}


	/**
	 * Load Localisation files.
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present
	 *
	 * @access public
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = function_exists( 'get_user_locale' ) ? get_user_locale() : get_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'wc-frontend-manager-elementor' );
		
		//load_plugin_textdomain( 'wcfm-tuneer-orders' );
		//load_textdomain( 'wc-frontend-manager-elementor', WP_LANG_DIR . "/wc-frontend-manager-elementor/wc-frontend-manager-elementor-$locale.mo");
		load_textdomain( 'wc-frontend-manager-elementor', $this->plugin_path . "lang/wc-frontend-manager-elementor-$locale.mo");
		load_textdomain( 'wc-frontend-manager-elementor', ABSPATH . "wp-content/languages/plugins/wc-frontend-manager-elementor-$locale.mo");
	}

	/* Get instance of elementor Core Plugin */

	public function wcfmem_elementor() {
		return \Elementor\Plugin::instance();
	}

	/**
	 * Is editing or preview mode running
	 *
	 * @return bool
	 */
	public function is_edit_or_preview_mode() {
		$is_edit_mode    = $this->wcfmem_elementor()->editor->is_edit_mode();
		$is_preview_mode = $this->wcfmem_elementor()->preview->is_preview_mode();

		if ( empty( $is_edit_mode ) && empty( $is_preview_mode ) ) {
			if ( ! empty( $_REQUEST['action'] ) && ! empty( $_REQUEST['editor_post_id'] ) ) {
				$is_edit_mode = true;
			} else if ( ! empty( $_REQUEST['preview'] ) && $_REQUEST['preview'] && ! empty( $_REQUEST['theme_template_id'] ) ) {
				$is_preview_mode = true;
			}
		}

		if ( $is_edit_mode || $is_preview_mode ) {
			return true;
		}

		return false;
	}

	/**
	 * Social network name mapping to elementor icon names
	 *
	 * @return array
	 */
	public function get_social_networks_map() {
		$map = [
				'fb'        => 'fab fa-facebook',
				'gplus'     => 'fab fa-google-plus',
				'twitter'   => 'fab fa-twitter',
				'pinterest' => 'fab fa-pinterest',
				'linkedin'  => 'fab fa-linkedin',
				'youtube'   => 'fab fa-youtube',
				'instagram' => 'fab fa-instagram',
				'flickr'    => 'fab fa-flickr',
		];

		return apply_filters( 'wcfmem_elementor_social_network_map', $map );
	}

	/**
	 * Default store data for widgets
	 *
	 * @param string $prop
	 *
	 * @return mixed
	 */
	public function get_wcfmem_store_data( $prop = null ) {
		$this->load_class( 'wcfm-store-data' );
	  $default_store_data = new WCFM_Elementor_StoreData();

		return $default_store_data->get_data( $prop );
	}

	/**
	 * Enqueue scripts in editing or preview mode
	 *
	 * @return void
	 */
	public function enqueue_editor_scripts() {
		global $WCFM, $WCFMem;
		if ( $WCFMem->is_edit_or_preview_mode() ) {
			$scheme  = is_ssl() ? 'https' : 'http';
			$api_key = isset( $WCFMmp->wcfmmp_marketplace_options['wcfm_google_map_api'] ) ? $WCFMmp->wcfmmp_marketplace_options['wcfm_google_map_api'] : '';
			if ( $api_key ) {
				wp_enqueue_script( 'wcfmem-store-google-maps', $scheme . '://maps.googleapis.com/maps/api/js?key=' . $api_key . '&libraries=places' );
			}
		}
	}
	
	public function load_class($class_name = '') {
		if ('' != $class_name && '' != $this->token) {
			require_once ($this->plugin_path . 'core/class-' . esc_attr($this->token) . '-' . esc_attr($class_name) . '-manager.php');
		} // End If Statement
	}

}