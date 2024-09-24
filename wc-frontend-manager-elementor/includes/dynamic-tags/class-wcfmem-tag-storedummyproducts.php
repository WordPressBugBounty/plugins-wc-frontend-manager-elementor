<?php
use \Elementor\Core\DynamicTags\Tag;

class WCFM_Elementor_Tag_StoreDummyProducts extends Tag {

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
      return 'wcfmem-store-dummy-products';
    }

    /**
     * Tag title
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_title() {
      return esc_html__( 'Store Dummy Products', 'wc-frontend-manager-elementor' );
    }

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
    public function render() {
        if ( wcfmmp_is_store_page() ) {
            return;
        }

        echo '<div class="site-main">';
        echo do_shortcode( '[products limit="12"]' );
        echo '</div>';
    }
}
