<?php

class WCFM_Elementor_ConditionsBase {
  /**
	 * Runs after first instance
	 *
	 * @return void
	 */
	public function __construct() {
    $this->load_class('store-condition');
		add_action( 'elementor/theme/register_conditions', [ $this, 'register_conditions' ] );
	}

  /**
   * Register condition for the module
   *
   * @param \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager $conditions_manager
   *
   * @return void
   */
  public function register_conditions( $conditions_manager ) {
    global $WCFM, $WCFMem;
    $condition = new StoreCondition();
    $conditions_manager->get_condition( 'general' )->register_sub_condition( $condition );
  }

  public function load_class($class_name = '') {
		global $WCFM, $WCFMem;
		if ('' != $class_name && '' != $WCFMem->token) {
			require_once ( $WCFMem->plugin_path .  'includes/conditions/class-' . esc_attr($WCFMem->token) . '-condition-' . strtolower(esc_attr($class_name)) . '.php');
		} // End If Statement
	}
}