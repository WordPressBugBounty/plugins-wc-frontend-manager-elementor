<?php
use \Elementor\Core\DynamicTags\Tag;

class WCFM_Elementor_Tag_StoreRating extends Tag {

    /**
     * Class constructor
     *
     * @since 1.0.0
     *
     * @param array $data
     */
    public function __construct( $data = [] ) {
        parent::__construct( $data );
    }

    /**
     * Tag name
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_name() {
        return 'wcfmem-store-rating-tag';
    }

    /**
     * Tag title
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_title() {
        return __( 'Store Rating', 'wc-frontend-manager-elementor' );
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
     * @since 1.0.0
     *
     * @return void
     */
    public function get_value() {
    		global $WCFM, $WCFMem;
        return $WCFMem->get_wcfmem_store_data( 'rating' );
    }
}
