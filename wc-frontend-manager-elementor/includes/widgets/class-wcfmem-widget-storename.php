<?php

use Elementor\Widget_Heading;

class WCFM_Elementor_Widget_StoreName extends Widget_Heading {

	use PositionControls;
	
	/**
	 * Widget name
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_name() {
		return 'wcfmem-store-name';
	}

	/**
	 * Widget title
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_title() {
		return __( 'Store Name', 'wc-frontend-manager-elementor' );
	}

	/**
	 * Widget icon class
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-site-title';
	}

	/**
	 * Widget categories
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'wcfmem-store-elements-single' ];
	}

	/**
	 * Widget keywords
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'wcfm', 'store', 'vendor', 'name', 'heading' ];
	}

	public function get_inline_css_depends() {
		return [
			[
				'name' => 'heading',
				'is_core_dependency' => true,
			],
		];
	}

	/**
	 * Register widget controls
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function register_controls() {
		global $WCFM, $WCFMem;
		//print_r($WCFMem->wcfmem_elementor()->dynamic_tags->tag_data_to_tag_text( null, 'wcfmem-store-name' ));
		parent::register_controls();

		$this->update_control(
			'title',
			[
				'dynamic' => [
					'default' => $WCFMem->wcfmem_elementor()->dynamic_tags->tag_data_to_tag_text( null, 'wcfmem-store-name-tag' ),
				],
			],
			[
				'recursive' => true,
			]
		);

		$this->update_control(
			'size',
			[
				'default' => 'large',
			]
		);

		$this->update_control(
			'header_size',
			[
				'default' => 'h1',
			]
		);

		$this->remove_control( 'link' );

		$this->add_position_controls();
	}

	/**
	 * Set wrapper classes
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function get_html_wrapper_class() {
		return parent::get_html_wrapper_class() . ' wcfmem-store-name elementor-page-title elementor-widget-' . parent::get_name();
	}

	/**
	 * Frontend render method
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function render() {
		$this->add_render_attribute(
				'title',
				'class',
				[ 'entry-title' ]
		);

		parent::render();
	}

	/**
	 * Elementor builder content template
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
				<#
						settings.link = {url: ''};
						view.addRenderAttribute( '_wrapper', 'class', [ 'wcfmem-store-name' ] );
						view.addRenderAttribute( 'title', 'class', [ 'entry-title' ] );
				#>
		<?php

		parent::content_template();
	}

	/**
	 * Render widget plain content
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render_plain_content() {}
}
