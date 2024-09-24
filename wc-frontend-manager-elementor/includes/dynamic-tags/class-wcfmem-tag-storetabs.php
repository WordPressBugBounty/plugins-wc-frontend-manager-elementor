<?php

use Elementor\Controls_Manager;
use \Elementor\Core\DynamicTags\Tag;

class WCFM_Elementor_Tag_StoreTabs extends Tag {

    /**
     * Tag name
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_name() {
        return 'wcfmem-store-tabs';
    }

    /**
     * Tag title
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_title() {
        return esc_html__( 'Store Tabs', 'wc-frontend-manager-elementor' );
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
     * Render Tag
     *
     * @since 1.0.0
     *
     * @return void
     */
    protected function get_value() {
        $store_id = 0;

        if ( wcfmmp_is_store_page() ) {
					$store = wcfmmp_get_store( get_query_var( 'author' ) );

					if ( $store->id ) {
						$store_id = $store->id;
					}
        } else {
        	$store = wcfmmp_get_store( 0 );
        }

        $store_tab_items = $store->get_store_tabs();

        $tab_items = [];

        foreach( $store_tab_items as $store_tab_key => $store_tab_label ) {
            $url = $store->get_store_tabs_url( $store_tab_key );

            if ( empty( $url ) && ! $store_id ) {
                $url = '#';
            }

            $tab_items[] = [
                'key'         => $store_tab_key,
                'title'       => $store_tab_label,
                'text'        => $store_tab_label,
                'url'         => $url,
                'icon'        => '',
                'show'        => true,
                '__dynamic__' => [
                    'text' => $store_tab_label,
                    'url'  => $url,
                ]
            ];
        }

        /**
         * Filter to modify tag values
         *
         * @since 1.0.0
         *
         * @param array $tab_items
         */
        return apply_filters( 'wcfmem_elementor_tags_store_tab_items_value', $tab_items );
    }

    protected function render() {
        echo json_encode( $this->get_value() );
    }
}
