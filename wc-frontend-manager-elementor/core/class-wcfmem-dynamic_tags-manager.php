<?php

class WCFM_Elementor_DynamicTagsBase {

  /**
	 * Runs after first instance
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'elementor/dynamic_tags/register', [ $this, 'wcfmem_init_dynamic_tags' ] );
		
	}

  /**
	 * Module widgets
	 *
	 * @return array
	 */
  public function wcfmem_get_tags() {
    global $WCFM, $WCFMem;
    $tags = [
      'StoreBanner',
      'StoreName',
      'StoreLogo',
      'StoreInfo',
      'StoreRating',
      'StoreTabs',
      'StoreDummyProducts',
      'StoreSocial',
      'StoreInquiry',
      // 'StoreCoupons'
    ];
    
    if( WCFM_Dependencies::wcfmu_plugin_active_check() ) {
     	$tags[] = 'StoreFollow';
    	$tags[] = 'StoreChat';
      $tags[] = 'StoreVacationMessage';
    }
     
    return $tags;
  }

   /**
     * Register module tags
     *
     * @return void
     */
  public function wcfmem_init_dynamic_tags($dynamic_tags_manager) {
    global $WCFM, $WCFMem;
    //print_r('xxxx'); die;

    if ( version_compare( '3.5.0', ELEMENTOR_VERSION, '<' ) ) {
      $dynamic_tags_manager = $WCFMem->wcfmem_elementor()->dynamic_tags;
    }
    

    $dynamic_tags_manager->register_group( WCFM_ELEMENTOR_GROUP, [
        'title' => esc_html__( 'WCFM', $WCFMem->token ),
    ] );

    foreach ( $this->wcfmem_get_tags() as $tag ) {
      $this->load_class( $tag );
      $class_name = "WCFM_Elementor_Tag_{$tag}";

      if ( class_exists( $class_name ) ) {
        $dynamic_tags_manager->register( new $class_name() );
      }
    }
  }

  public function load_class($class_name = '') {
    global $WCFM, $WCFMem;
    if ('' != $class_name && '' != $WCFMem->token) {
      require_once ( $WCFMem->plugin_path .  'includes/dynamic-tags/class-' . esc_attr($WCFMem->token) . '-tag-' . strtolower(esc_attr($class_name)) . '.php');
    } // End If Statement
  }

}
