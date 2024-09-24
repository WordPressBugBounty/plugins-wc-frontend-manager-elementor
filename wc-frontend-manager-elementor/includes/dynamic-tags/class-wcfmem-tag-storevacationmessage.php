<?php
use \Elementor\Core\DynamicTags\Tag;

class WCFM_Elementor_Tag_StoreVacationMessage extends Tag {

    /**
     * Class constructor
     *
     * @since 2.0.0
     *
     * @param array $data
     */
    public function __construct( $data = [] ) {
        parent::__construct( $data );
    }

    /**
     * Tag name
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function get_name() {
        return 'wcfmem-store-vacation-message-tag';
    }

    /**
     * Tag title
     *
     * @since 2.0.0
     *
     * @return string
     */
    public function get_title() {
        return __( 'Store Vacation Message', 'wc-frontend-manager-elementor' );
    }

  /**
   * Tag Group
   *
   * @since 2.0.0
   *
   * @return string
   */

  public function get_group() {
    return WCFM_ELEMENTOR_GROUP;
  }

  /**
   * Tag Category
   *
   * @since 2.0.0
   *
   * @return string
   */

  public function get_categories() {
    return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
  }

    /**
     * Render tag
     *
     * @since 2.0.0
     *
     * @return void
     */
    public function render() {
      global $WCFM, $WCFMem;
      
      if( !apply_filters( 'wcfm_is_pref_vendor_vacation', true )  ) {
        echo esc_html__( 'Chat module is not active', 'wc-frontend-manager-elementor' );
        return;
      }

      if ( wcfmmp_is_store_page() ) {
        $vendor_id = $WCFMem->get_wcfmem_store_data( 'id' );
        
        $vendor_has_vacation = $WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $vendor_id, 'vacation' );
			  if( !$vendor_has_vacation ) return;
        

        echo $WCFMem->get_wcfmem_store_data( 'vacation_message' );
      } else {
        echo esc_html__( 'Store vacation message set in vendor dashboard will show here.', 'wc-frontend-manager-elementor' );
      }

    }
}
