<?php

class WCFM_Elementor_WidgetBase {

  /**
	 * Runs after first instance
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'wcfmem_add_widget_categories' ] );
		add_action( 'elementor/widgets/register', [ $this, 'wcfmem_init_widgets' ] );
		
	}

	/**
	 * Module widgets
	 *
	 * @return array
	 */
    public function wcfmem_get_widgets() {
    	global $WCFM, $WCFMem;
			
			$widgets = [
				'StoreBanner',
				'StoreName',
				'StoreLogo',
				'StoreInfo',
				'StoreRating',
				'StoreTabs',
				'StoreTabContents',
				'StoreSocial',
				'StoreInquiry',
				// 'StoreCoupons'
			];
			
			if( WCFM_Dependencies::wcfmu_plugin_active_check() ) {
				
				$widgets[] = 'StoreFollow';
				$widgets[] = 'StoreChat';
				$widgets[] = 'StoreVacationMessage';
			}
			 
			return $widgets;
    }

		/**
	 * Register module widgets
	 *
	 * @return void
	 */
	public function wcfmem_init_widgets($widget_manager) {
		global $WCFM, $WCFMem;
		if ( version_compare( '3.5.0', ELEMENTOR_VERSION, '<' ) ) {
			$widget_manager = $WCFMem->wcfmem_elementor()->widgets_manager;
		}

		foreach ( $this->wcfmem_get_widgets() as $widget ) {
			$this->load_class( $widget );
			
			$class_name = "WCFM_Elementor_Widget_{$widget}";

			if ( class_exists( $class_name ) ) {
				$widget_manager->register( new $class_name() );
			}
		}
	}

	public function wcfmem_add_widget_categories($elements_manager) {
		global $WCFM, $WCFMem;
		
		$elements_manager->add_category(
			'wcfmem-store-elements-single',
			[
				'title' => esc_html__( 'Marketplace', 'wc-frontend-manager-elementor' ),
				'icon' => 'fa fa-plug',
				'hideIfEmpty' => false,
			]
		);
	}

	public function load_class($class_name = '') {
		global $WCFM, $WCFMem;
		if ('' != $class_name && '' != $WCFMem->token) {
			require_once ( $WCFMem->plugin_path .  '/includes/widgets/class-' . esc_attr($WCFMem->token) . '-widget-' . strtolower(esc_attr($class_name)) . '.php');
		} // End If Statement
	}

}