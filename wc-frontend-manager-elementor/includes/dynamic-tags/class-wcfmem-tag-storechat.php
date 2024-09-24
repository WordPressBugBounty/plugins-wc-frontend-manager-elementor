<?php

use \Elementor\Core\DynamicTags\Tag;

class WCFM_Elementor_Tag_StoreChat extends Tag {

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
        return 'wcfmem-store-chat-tag';
    }

    /**
     * Tag title
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function get_title() {
        return __( 'Store Chat Button', 'wc-frontend-manager-elementor' );
    }

    /**
     * Tag categories
     *
     * @since 1.0.0
     *
     * @return array
     */
    public function get_categories() {
      return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
    }

  /**
   * Tag groups
   *
   * @since 1.0.0
   *
   * @return array
   */
  public function get_group() {
    return WCFM_ELEMENTOR_GROUP;
  }

    /**
     * Render tag
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function render() {
      global $WCFM, $WCFMem;
    
      if( !apply_filters( 'wcfm_is_pref_chatbox', true ) || !apply_filters( 'wcfmmp_is_allow_store_header_chat', true ) ) {
          echo __( 'Chat module is not active', 'wc-frontend-manager-elementor' );
          return;
      }
      
      $wcfm_chatbox_setting = get_option( 'wcfm_chatbox_setting', array() );
      $wcfm_chatnow_label   = !empty( $wcfm_chatbox_setting['label'] ) ? $wcfm_chatbox_setting['label'] : __( 'Chat Now', 'wc-frontend-manager-ultimate' );
      
      echo $wcfm_chatnow_label;
    }
}
