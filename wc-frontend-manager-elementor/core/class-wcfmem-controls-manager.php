<?php

class WCFM_Elementor_ControlsBase {

  private $controls;
  /**
	 * Runs after first instance
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'elementor/controls/register', [ $this, 'wcfmem_init_controls' ] );
		
	}

  /**
	 * Module widgets
	 *
	 * @return array
	 */
  public function wcfmem_get_controls() {
    global $WCFM, $WCFMem;
    $controls = [
      'SortableList',
      'DynamicHidden',
    ];
    
    return $controls;
  }

   /**
     * Register module controls
     *
     * @return void
     */
  public function wcfmem_init_controls($controls_manager) {
    global $WCFM, $WCFMem;
    	
    $controls = $this->wcfmem_get_controls();

    foreach ( $controls as $control ) {
      $this->load_class( $control );
      $control_class = "WCFM_Elementor_Control_{$control}";
      $controls_manager->register( new $control_class() );
    }
  }

  public function load_class($class_name = '') {
    global $WCFM, $WCFMem;
    if ('' != $class_name && '' != $WCFMem->token) {
      require_once ( $WCFMem->plugin_path .  'includes/controls/class-' . esc_attr($WCFMem->token) . '-control-' . strtolower(esc_attr($class_name)) . '.php');
    } // End If Statement
  }

}
