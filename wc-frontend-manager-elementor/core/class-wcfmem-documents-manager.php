<?php

class WCFM_Elementor_DocumentBase {

  private $docs_types = [];
  
  /**
	 * Runs after first instance
	 *
	 * @return void
	 */
	public function __construct() {
    
    $this->include_docs_types();
		add_action( 'elementor/documents/register', [ $this, 'register_documents' ],15 );
	}

  public function get_docs_types() {

    $this->docs_types = [
      'wcfmem-store' => 'StorePage'
    ];

    return $this->docs_types;
  }

  private function include_docs_types() {
    foreach($this->get_docs_types() as $type => $name ) {
      $this->load_class($type);
    }
  }

  /**
	 * Module widgets
	 *
	 * @return array
	 */

	/**
   * Register module documents
   *
   * @param Elementor\Core\Documents_Manager $documents_manager
   *
   * @return void
   */
  public function register_documents( $documents_manager ) {
    global $WCFM, $WCFMem;

    foreach ( $this->docs_types as $type => $class_name ) {
      $documents_manager->register_document_type( $type, $class_name );
    }
  }

	public function load_class($class_name = '') {
		global $WCFM, $WCFMem;
		if ('' != $class_name && '' != $WCFMem->token) {
			require_once ( $WCFMem->plugin_path .  'includes/documents/class-' . esc_attr($WCFMem->token) . '-document-' . strtolower(esc_attr($class_name)) . '.php');
		} // End If Statement
	}

}