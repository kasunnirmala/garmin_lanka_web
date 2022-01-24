<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Products Widget
 *
 * Riode Widget to display products.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Riode_Products_Tab_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_products_tab';
	}

	public function get_title() {
		return esc_html__( 'Products Tab', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'products', 'shop', 'woocommerce', 'tab' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-products-tab';
	}

	public function get_script_depends() {
		$depends = array( 'owl-carousel' );
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_products_selector',
			array(
				'label' => esc_html__( 'Products Tab', 'riode-core' ),
			)
		);

			$repeater = new Repeater();

			$repeater->add_control(
				'tab_title',
				[
					'label' => esc_html__( 'Tab Title', 'riode-core' ),
					'type'  => Controls_Manager::TEXT,
				]
			);

			riode_elementor_products_select_controls( $repeater, false );

			riode_elementor_tab_layout_controls( $this );

			$this->add_control(
				'products_selector_list',
				[
					'label'         => esc_html__( 'Products Selector', 'riode-core' ),
					'type'          => Controls_Manager::REPEATER,
					'fields'        => $repeater->get_controls(),
					'default'       => [
						[
							'tab_title' => esc_html__( 'New Arrivals', 'riode-core' ),
							'count'     => [
								'unit' => 'px',
								'size' => 6,
							],
							'orderby'   => 'date',
							'orderway'  => 'DESC',
						],
						[
							'tab_title' => esc_html__( 'Best Seller', 'riode-core' ),
							'count'     => [
								'unit' => 'px',
								'size' => 6,
							],
							'orderby'   => 'popularity',
							'orderway'  => 'DESC',
						],
						[
							'tab_title' => esc_html__( 'Most Popular', 'riode-core' ),
							'count'     => [
								'unit' => 'px',
								'size' => 6,
							],
							'orderby'   => 'rating',
							'orderway'  => 'DESC',
						],
						[
							'tab_title' => esc_html__( 'View All', 'riode-core' ),
							'count'     => [
								'unit' => 'px',
								'size' => 6,
							],
						],
					],
					'title_field'   => '{{{ tab_title }}}',
					'prevent_empty' => false,
				]
			);

		$this->end_controls_section();

		riode_elementor_products_layout_controls( $this );

		riode_elementor_product_type_controls( $this );

		$this->start_controls_section(
			'tab_style',
			array(
				'label' => esc_html__( 'Tab', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			riode_elementor_tab_style_controls( $this );

		$this->end_controls_section();

		riode_elementor_slider_style_controls( $this, 'layout_type' );

		riode_elementor_product_style_controls( $this );
	}

	public function render_content() {
		$settings = $this->get_settings_for_display();

		do_action( 'elementor/widget/before_render_content', $this );

		ob_start();

		$skin = $this->get_current_skin();
		if ( $skin ) {
			$skin->set_parent( $this );
			$skin->render_by_mode();
		} else {
			$this->render_by_mode();
		}

		$widget_content = ob_get_clean();

		if ( empty( $widget_content ) ) {
			return;
		}

		$extra_class     = ' tab';
		$settings['gap'] = 'no';

		if ( $settings['tab_h_type'] ) {
			$extra_class .= ' tab-' . $settings['tab_h_type'];
		}

		if ( 'vertical' == $settings['tab_type'] ) {
			$extra_class .= ' tab-vertical';
		}

		switch ( $settings['tab_navs_pos'] ) { // nav position
			case 'center':
				$extra_class .= ' tab-nav-center';
				break;
			case 'right':
				$extra_class .= ' tab-nav-right';
		}
		?>
		<div class="elementor-widget-container<?php echo esc_attr( $extra_class ); ?>">
			<?php
			$widget_content = apply_filters( 'elementor/widget/render_content', $widget_content, $this );
			echo riode_escaped( $widget_content );
			?>
		</div>
		<?php
	}

	protected function render() {
		$atts = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-products-tab-render.php';
	}

	protected function content_template() {}
}
