<?php

use Elementor\Controls_Manager;
use Elementor\Widget_Alert;

class WCFM_Elementor_Widget_StoreVacationMessage extends Widget_Alert {

	/**
	 * Widget name
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_name() {
		return 'wcfmem-store-vacation-message';
	}

	/**
	 * Widget title
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_title() {
		return esc_html__( 'Store Vacation Message', 'wc-frontend-manager-elementor' );
	}

	/**
	 * Widget icon class
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-alert';
	}

	/**
	 * Widget categories
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_categories() {
		return [ 'wcfmem-store-elements-single' ];
	}

	/**
	 * Widget keywords
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public function get_keywords() {
		return [ 'wcfm', 'store', 'vendor', 'vacation', 'message', 'alert' ];
	}

	public function get_inline_css_depends() {
		return [
			[
				'name' => 'alert',
				'is_core_dependency' => true,
			],
		];
	}

	/**
	 * Register widget controls
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	protected function register_controls() {
		global $WCFMem;
		parent::register_controls();

		$this->update_control(
			'alert_title',
			[
				'label'   => esc_html__( 'Title', 'wc-frontend-manager-elementor' ),
				'default' => esc_html__( 'The Store is Temporarily Closed', 'wc-frontend-manager-elementor' ),
				'dynamic' => false
			]
		);

		$this->update_control(
			'alert_description',
			[
				'type'      => WCFM_Elementor_Control_DynamicHidden::CONTROL_TYPE,
				'dynamic'   => [
					'default' => $WCFMem->wcfmem_elementor()->dynamic_tags->tag_data_to_tag_text( null, 'wcfmem-store-vacation-message-tag' ),
					'active' => true,
				],
			],
			[
				'recursive' => true,
			]
		);

		$this->update_control(
			'show_dismiss',
			[
				'type' => Controls_Manager::HIDDEN,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Show Title', 'wc-frontend-manager-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hide',
				'options' => [
					'show' => esc_html__( 'Show', 'wc-frontend-manager-elementor' ),
					'hide' => esc_html__( 'Hide', 'wc-frontend-manager-elementor' ),
				],
			],
			[
				'position' => [ 'of' => 'show_dismiss' ],
			]
		);
	}

	/**
	 * Set wrapper classes
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	protected function get_html_wrapper_class() {
		return parent::get_html_wrapper_class() . ' wcfmem-store-vacation-message elementor-widget-' . parent::get_name();
	}

	/**
	 * Frontend render method
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['alert_description'] ) ) {
			return;
		}

		if ( ! empty( $settings['alert_title'] ) ) {
			$this->add_render_attribute( 'alert_title', 'class', 'elementor-alert-title' );

			$this->add_inline_editing_attributes( 'alert_title', 'none' );
		}

		if ( ! empty( $settings['alert_type'] ) ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-alert elementor-alert-' . $settings['alert_type'] );
		}

		$this->add_render_attribute( 'wrapper', 'role', 'alert' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['show_title'] ) && 'show' === $settings['show_title'] && ! empty( $settings['alert_title'] ) ): ?>
				<span <?php echo $this->get_render_attribute_string( 'alert_title' ); ?>><?php echo $settings['alert_title']; ?></span>
			<?php endif; ?>

			<?php
			if ( ! empty( $settings['alert_description'] ) ) :
				$this->add_render_attribute( 'alert_description', 'class', 'elementor-alert-description' );

				$this->add_inline_editing_attributes( 'alert_description' );
				?>
				<span <?php echo $this->get_render_attribute_string( 'alert_description' ); ?>><?php echo $settings['alert_description']; ?></span>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Elementor builder content template
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	protected function content_template() {
		?>
		<#
			if ( settings.alert_title ) {
				view.addRenderAttribute( {
						alert_title: { class: 'elementor-alert-title' },
				} );

				view.addInlineEditingAttributes( 'alert_title', 'none' );
			}

			view.addRenderAttribute( {
				alert_description: { class: 'elementor-alert-description' }
			} );

			view.addInlineEditingAttributes( 'alert_description' );
		#>
		<div class="elementor-alert elementor-alert-{{ settings.alert_type }}" role="alert">
			<# if ( 'show' === settings.show_title && settings.alert_title ) { #>
					<span {{{ view.getRenderAttributeString( 'alert_title' ) }}}>{{{ settings.alert_title }}}</span>
			<# } #>
			<span {{{ view.getRenderAttributeString( 'alert_description' ) }}}>{{{ settings.alert_description }}}</span>
		</div>
		<?php
	}

	/**
	 * Render widget plain content
	 *
	 * @since 2.0.0
	 *
	 * @return void
	 */
	public function render_plain_content() {}
}
