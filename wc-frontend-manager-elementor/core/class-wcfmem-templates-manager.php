<?php

class WCFM_Elementor_Templates {

	public function __construct() {
		add_filter( 'elementor/api/get_templates/body_args', [ self::class, 'add_http_request_filter' ] );
		add_filter( 'option_' . \Elementor\Api::LIBRARY_OPTION_KEY, [ self::class, 'add_template_library' ] );
		
		/**
		 * Including wcfm elementor template library to transient.
		 */
		if ( defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, '3.10.0', '>=' ) ) {
			$templates_data_cache_key = \Elementor\TemplateLibrary\Source_Remote::TEMPLATES_DATA_TRANSIENT_KEY_PREFIX . ELEMENTOR_VERSION;

			add_filter( 'transient_' . $templates_data_cache_key, [ self::class, 'add_template_library_data_to_transient' ] );
		}

		add_action( 'woocommerce_api_wcfmem-template-preview-9000001', [ self::class, 'template_preview_9000001' ] );
		add_action( 'woocommerce_api_wcfmem-template-preview-9000002', [ self::class, 'template_preview_9000002' ] );
	}


	/**
	 * Filter elementor https request
	 *
	 * @param array $body_args
	 */
	// public static function add_http_request_filter( $body_args ) {
	// 	add_filter( 'pre_http_request', [ self::class, 'pre_http_request' ], 1000, 3 );

	// 	return $body_args;
	// }
	public static function add_http_request_filter( $body_args ) {
		add_filter( 'pre_http_request', [ self::class, 'pre_http_request' ], 10, 3 );

		return $body_args;
	}

	/**
	 * Returns WCFM Marketplace Store templates for related request
	 *
	 * @param bool   $pre
	 * @param array  $r
	 * @param string $url
	 *
	 * @return bool|array
	 */
	public static function pre_http_request( $pre, $r, $url ) {
		global $WCFM, $WCFMem;
		
		// @see elementor/includes/api.php $api_get_template_content_url
		//if ( preg_match( '/https\:\/\/my\.elementor\.com\/api\/v1\/templates\/900000(\d+)/', $url, $matches ) ) {
		  //$json_file = $WCFMem->plugin_path . '/templates/' . $matches[1] . '.json';
		  
		  
	  if ( preg_match( '/https\:\/\/my\.elementor\.com\/api\/connect\/v1\/library\/(get_template_content)/', $url, $matches ) ) {
	  	if( isset( $matches[1] ) && ( $matches[1] == 'get_template_content' ) ) {
				if( isset( $r['body'] ) && isset( $r['body']['id'] ) ) {
					$template_id = $r['body']['id'];
					if( in_array( $template_id, array( 9000001, 9000002, 9000003, 9000004, 9000005 ) ) ) {
						$json_file = $WCFMem->plugin_path . '/templates/' . $template_id . '.json';
		
						if ( file_exists( $json_file ) ) {
							$content = json_decode( file_get_contents( $json_file ), true );
			
							return [
									'response' => [
											'code' => 200,
									],
									'body' => json_encode( $content )
							];
						}
					}
				}
			}
		}

		return $pre;
	}

	/**
	 * Add WCFM Marketplace Store templates as remote template source
	 *
	 * @param array $value
	 */
	public static function add_template_library( $value ) {
		global $WCFM, $WCFMem;
		
		if ( 'string' === gettype($value['categories']) ) {
			$categories          = json_decode( $value['categories'], true );
			$categories[]        = 'single store';
			$value['categories'] = wp_json_encode( $categories );
		} else {
			$value['categories'][] = 'single store';
		}
		$store_templates    = self::get_wcfmem_elementor_templates();

		$value['templates'] = array_merge( $value['templates'], $store_templates );
		
		return $value;
	}

	public static function add_template_library_data_to_transient( $data ) {
		if ( false === $data ) {
				return $data;
		}

		$store_templates = self::get_wcfmem_elementor_templates();
		$data            = array_merge( $store_templates, $data );

		return $data;
	}

	/**
	 * Template preview
	 *
	 * @return void
	 */
	public static function template_preview_9000001() {
		global $WCFM, $WCFMem;
		include $WCFMem->plugin_path . 'views/template-preview-9000001.php';
	}
	
	public static function template_preview_9000002() {
		global $WCFM, $WCFMem;
		include $WCFMem->plugin_path . 'views/template-preview-9000002.php';
	}

	/**
     * Get wcfm elementor templates.
     *
     * @since 3.0.0
     *
     * @return array $templates_data Elementor templates data
     */
  public static function get_wcfmem_elementor_templates() {
		global $WCFMem;
		$templates_data = [
			[
					'id'                => "9000001",
					'source'            => "remote",
					'type'              => "block",
					'subtype'           => "single store",
					'title'             => "Store Page Layout",
					'thumbnail'         => $WCFMem->plugin_url . 'assets/images/store-header-9000001.png',
					'tmpl_created'      => "1486569564",
					'author'            => "WC Lovers",
					'tags'              => '',
					'is_pro'            => false,
					'popularity_index'  => 1,
					'trend_index'       => 1,
					'favorite'          => false,
					'has_page_settings' => false,
					'url'               => home_url( '/?wc-api=wcfmem-template-preview-9000001' ),
			],
			[
					'id'                => "9000002",
					'source'            => "remote",
					'type'              => "block",
					'subtype'           => "single store",
					'title'             => "Store Page Layout",
					'thumbnail'         => $WCFMem->plugin_url . 'assets/images/store-header-9000002.png',
					'tmpl_created'      => "1486569564",
					'author'            => "WC Lovers",
					'tags'              => '',
					'is_pro'            => false,
					'popularity_index'  => 1,
					'trend_index'       => 1,
					'favorite'          => false,
					'has_page_settings' => false,
					'url'               => home_url( '/?wc-api=wcfmem-template-preview-9000002' ),
			]
		];
		return $templates_data;
	}
}