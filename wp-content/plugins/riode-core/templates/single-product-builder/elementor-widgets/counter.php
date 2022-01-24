<?php
/**
 * Riode Elementor Single Product Counter Widget
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;

class Riode_Single_Product_Counter_Elementor_Widget extends \Elementor\Widget_Counter {

	public function get_name() {
		return 'riode_sproduct_counter';
	}

	public function get_title() {
		return esc_html__( 'Product Counter', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-counter';
	}

	public function get_categories() {
		return array( 'riode_single_product_widget' );
	}

	public function get_keywords() {
		return array( 'single', 'custom', 'layout', 'product', 'woocommerce', 'shop', 'store', 'name', 'total', 'sale', 'count', 'stock' );
	}

	public function get_script_depends() {
		return [ 'jquery-numerator' ];
	}

	protected function register_controls() {
		parent::register_controls();

		$this->update_control(
			'starting_number',
			array(
				'dynamic' => array(
					'active' => false,
				),
			)
		);

		$this->add_control(
			'adding_number',
			array(
				'label'       => esc_html__( 'Fake Addition Number', 'riode-core' ),
				'description' => esc_html__( 'Add more numbers to real sale count or stock count to boost your sale.', 'riode-core' ),
				'type'        => Controls_Manager::NUMBER,
				'separator'   => 'after',
				'default'     => 0,
			),
			array(
				'position' => array(
					'at' => 'after',
					'of' => 'ending_number',
				),
			)
		);

		$this->update_control(
			'ending_number',
			array(
				'type'    => Controls_Manager::SELECT,
				'default' => 'sale',
				'options' => array(
					'sale'  => esc_html__( 'Sale Count', 'riode-core' ),
					'stock' => esc_html__( 'Stock', 'riode-core' ),
				),
			)
		);
	}

	protected function content_template() {
	}

	protected function render() {
		if ( apply_filters( 'riode_single_product_builder_set_product', false ) ) {

			global $product;
			$settings = $this->get_settings_for_display();

			if ( 'sale' == $settings['ending_number'] ) {
				$count_to = $product->get_total_sales();
			} else {
				$count_to = $product->get_stock_quantity();
			}

			if ( $settings['adding_number'] ) {
				$count_to += $settings['adding_number'];
			}

			$this->add_render_attribute(
				'counter',
				array(
					'class'           => 'elementor-counter-number',
					'data-duration'   => $settings['duration'],
					'data-to-value'   => $count_to,
					'data-from-value' => $settings['starting_number'],
				)
			);

			if ( ! empty( $settings['thousand_separator'] ) ) {
				$delimiter = empty( $settings['thousand_separator_char'] ) ? ',' : $settings['thousand_separator_char'];
				$this->add_render_attribute( 'counter', 'data-delimiter', $delimiter );
			}

			$this->add_render_attribute( 'counter-title', 'class', 'elementor-counter-title' );

			$this->add_inline_editing_attributes( 'counter-title' );
			?>
			<div class="elementor-counter">
				<div class="elementor-counter-number-wrapper">
					<span class="elementor-counter-number-prefix"><?php echo $settings['prefix']; ?></span>
					<span <?php $this->print_render_attribute_string( 'counter' ); ?>><?php echo $settings['starting_number']; ?></span>
					<span class="elementor-counter-number-suffix"><?php echo $settings['suffix']; ?></span>
				</div>
				<?php if ( $settings['title'] ) : ?>
					<div <?php $this->print_render_attribute_string( 'counter-title' ); ?>><?php echo $settings['title']; ?></div>
				<?php endif; ?>
			</div>
			<?php
			do_action( 'riode_single_product_builder_unset_product' );
		}
	}
}
