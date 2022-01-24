<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Riode Share Widget
 *
 * Riode Widget to display share buttons.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use ELementor\Group_Control_Box_Shadow;
use Elementor\Repeater;


class Riode_Share_Elementor_Widget extends \Elementor\Widget_Base {
	public $share_icons = array(
		'facebook'  => array( 'fab fa-facebook-f', 'https://www.facebook.com/sharer.php?u=$permalink' ),
		'twitter'   => array( 'fab fa-twitter', 'https://twitter.com/intent/tweet?text=$title&amp;url=$permalink' ),
		'linkedin'  => array( 'fab fa-linkedin-in', 'https://www.linkedin.com/shareArticle?mini=true&amp;url=$permalink&amp;title=$title' ),
		'email'     => array( 'far fa-envelope', 'mailto:?subject=$title&amp;body=$permalink' ),
		'google'    => array( 'fab fa-google-plus-g', 'https://plus.google.com/share?url=$permalink' ),
		'pinterest' => array( 'fab fa-pinterest-p', 'https://pinterest.com/pin/create/button/?url=$permalink&amp;media=$image' ),
		'reddit'    => array( 'fab fa-reddit-alien', 'http://www.reddit.com/submit?url=$permalink&amp;title=$title' ),
		'tumblr'    => array( 'fab fa-tumblr', 'http://www.tumblr.com/share/link?url=$permalink&amp;name=$title&amp;description=$excerpt' ),
		'vk'        => array( 'fab fa-vk', 'https://vk.com/share.php?url=$permalink&amp;title=$title&amp;image=$image&amp;noparse=true' ),
		'whatsapp'  => array( 'fab fa-whatsapp', 'whatsapp://send?text=$title - $permalink' ),
		'xing'      => array( 'fab fa-xing', 'https://www.xing-share.com/app/user?op=share;sc_p=xing-share;url=$permalink' ),
		'instagram' => array( 'fab fa-instagram', '' ),
		'youtube'   => array( 'fab fa-youtube', '' ),
		'tiktok'    => array( 'fab fa-tiktok', '' ),
		'wechat'    => array( 'fab fa-weixin', '' ),
	);

	public function get_name() {
		return 'riode_widget_share';
	}

	public function get_title() {
		return esc_html__( 'Social', 'riode-core' );
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'Share', 'Social', 'link', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-social';
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_share_content',
			array(
				'label' => esc_html__( 'Share Buttons', 'riode-core' ),
			)
		);

			$options = array();

		foreach ( $this->share_icons as $key => $value ) {
			$options[ $key ] = $key;
		}

			$repeater = new Repeater();

				$repeater->add_control(
					'site',
					array(
						'label'       => esc_html__( 'Network', 'riode-core' ),
						'description' => esc_html__( 'Select social network for each social items.', 'riode-core' ),
						'type'        => Controls_Manager::SELECT,
						'options'     => $options,
						'default'     => 'facebook',
					)
				);

				$repeater->add_control(
					'link',
					array(
						'label'       => esc_html__( 'Link', 'riode-core' ),
						'type'        => Controls_Manager::URL,
						'description' => esc_html__( 'Please leave it blank to share this page or input URL for social login', 'riode-core' ),
						'options'     => false,
					)
				);

			$this->add_control(
				'share_buttons',
				array(
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'description' => esc_html__( 'Select items to share or for social links. Each items contain network and link options.', 'riode-core' ),
					'default'     => array(
						array(
							'site' => 'facebook',
							'link' => '',
						),
						array(
							'site' => 'twitter',
							'link' => '',
						),
						array(
							'site' => 'linkedin',
							'link' => '',
						),
					),
					'title_field' => '{{{ site }}}',
				)
			);

			$this->add_control(
				'type',
				array(
					'label'       => esc_html__( 'Type', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => esc_html__( 'Choose social link item type. Choose from Simple, Stacked, Framed.', 'riode-core' ),
					'options'     => array(
						''        => esc_html__( 'Default', 'riode-core' ),
						'stacked' => esc_html__( 'Stacked', 'riode-core' ),
						'framed'  => esc_html__( 'Framed', 'riode-core' ),
					),
					'default'     => 'stacked',
					'separator'   => 'before',
				)
			);

			$this->add_control(
				'border',
				array(
					'label'       => esc_html__( 'Border Style', 'riode-core' ),
					'type'        => Controls_Manager::SELECT,
					'description' => esc_html__( 'Choose border style of social link item. Choose from Square, Rounded, Ellipse.', 'riode-core' ),
					'options'     => array(
						'0'   => esc_html__( 'Rectangle', 'riode-core' ),
						'5px' => esc_html__( 'Rounded', 'riode-core' ),
						'50%' => esc_html__( 'Circle', 'riode-core' ),
					),
					'default'     => '50%',
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'border-radius: {{VALUE}}',
					),
				)
			);

			$this->add_control(
				'share_direction',
				array(
					'type'        => Controls_Manager::CHOOSE,
					'label'       => esc_html__( 'Direction', 'riode-core' ),
					'description' => esc_html__( 'Determine whether to arrange social link items horizontally or vertically.', 'riode-core' ),
					'options'     => array(
						'flex'  => array(
							'title' => esc_html__( 'Row', 'riode-core' ),
							'icon'  => 'eicon-arrow-right',
						),
						'block' => array(
							'title' => esc_html__( 'Column', 'riode-core' ),
							'icon'  => 'eicon-arrow-down',
						),
					),
					'default'     => 'flex',
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icons' => 'display: {{VALUE}}',
					),
				)
			);

			$this->add_responsive_control(
				'share_align',
				array(
					'label'       => esc_html__( 'Alignment', 'riode-core' ),
					'description' => esc_html__( 'Choose alignment of social icons. Choose from Left, Center, Right, Justified.', 'riode-core' ),
					'type'        => Controls_Manager::CHOOSE,
					'options'     => array(
						'flex-start'    => array(
							'title' => esc_html__( 'Left', 'riode-core' ),
							'icon'  => 'eicon-text-align-left',
						),
						'center'        => array(
							'title' => esc_html__( 'Center', 'riode-core' ),
							'icon'  => 'eicon-text-align-center',
						),
						'flex-end'      => array(
							'title' => esc_html__( 'Right', 'riode-core' ),
							'icon'  => 'eicon-text-align-right',
						),
						'space-between' => array(
							'title' => esc_html__( 'Justify', 'riode-core' ),
							'icon'  => 'eicon-text-align-justify',
						),
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icons' => 'justify-content: {{VALUE}};',
					),
					'condition'   => array(
						'share_direction' => 'flex',
					),
				)
			);

			$this->add_control(
				'custom_color',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'label'       => esc_html__( 'Use Custom Color', 'riode-core' ),
					'description' => esc_html__( 'Enables you to change color scheme of social icons.', 'riode-core' ),
				)
			);

			$this->add_control(
				'color',
				array(
					'label'       => esc_html__( 'Color', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'description' => esc_html__( 'Choose custom color of social icons.', 'riode-core' ),
					'selectors'   => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'color: {{VALUE}}',
					),
					'condition'   => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'border_color',
				array(
					'label'       => esc_html__( 'Border Color', 'riode-core' ),
					'description' => esc_html__( 'Choose custom border color of social icons.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'border-color: {{VALUE}}',
					),
					'condition'   => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'background_color',
				array(
					'label'       => esc_html__( 'Background Color', 'riode-core' ),
					'description' => esc_html__( 'Choose custom background color of social icons.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor .elementor-element-{{ID}} .social-custom:not(:hover)' => 'background: {{VALUE}};',
					),
					'condition'   => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'custom_hover_color',
				array(
					'type'        => Controls_Manager::SWITCHER,
					'description' => esc_html__( 'Enables you to change color scheme of social icons when mouse is over.', 'riode-core' ),
					'label'       => esc_html__( 'Use Custom Hover Color', 'riode-core' ),
					'condition'   => array(
						'custom_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_color',
				array(
					'label'       => esc_html__( 'Hover Color', 'riode-core' ),
					'description' => esc_html__( 'Choose color of social icons on hover event.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'color: {{VALUE}}',
					),
					'condition'   => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_border_color',
				array(
					'label'       => esc_html__( 'Border Color', 'riode-core' ),
					'description' => esc_html__( 'Choose border color of social icons on hover event.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'border-color: {{VALUE}}',
					),
					'condition'   => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

			$this->add_control(
				'hover_bg_color',
				array(
					'label'       => esc_html__( 'Hover Background Color', 'riode-core' ),
					'description' => esc_html__( 'Choose background color of social icons on hover event.', 'riode-core' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => array(
						'.elementor .elementor-element-{{ID}} .social-custom:hover' => 'background: {{VALUE}};',
					),
					'condition'   => array(
						'custom_color'       => 'yes',
						'custom_hover_color' => 'yes',
					),
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_share_style',
			array(
				'label' => esc_html__( 'Share Icons Style', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_responsive_control(
				'button_size',
				array(
					'label'       => esc_html__( 'Button Size', 'riode-core' ),
					'description' => esc_html__( 'Controls entire size of social items.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'icon_size',
				array(
					'label'       => esc_html__( 'Icon Size', 'riode-core' ),
					'description' => esc_html__( 'Controls only icon size of social items.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				'col_space',
				array(
					'label'       => esc_html__( 'Column Gap', 'riode-core' ),
					'description' => esc_html__( 'Controls horizontal space (Left and Right) of social items.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2); margin-right: calc({{SIZE}}{{UNIT}} / 2);',
						'.elementor-element-{{ID}} .social-icons' => 'margin-left: calc(-{{SIZE}}{{UNIT}} / 2); margin-right: calc(-{{SIZE}}{{UNIT}} / 2);',
					),
				)
			);

			$this->add_responsive_control(
				'row_space',
				array(
					'label'       => esc_html__( 'Row Gap', 'riode-core' ),
					'description' => esc_html__( 'Controls vertical space (Top and Bottom) of social items.', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 50,
						),
					),
					'size_units'  => array(
						'px',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
						'.elementor-element-{{ID}} .social-icons' => 'margin-top: calc(-{{SIZE}}{{UNIT}} / 2); margin-bottom: calc(-{{SIZE}}{{UNIT}} / 2);',
					),
				)
			);

			$this->add_control(
				'border_width',
				array(
					'label'       => esc_html__( 'Border Width', 'riode-core' ),
					'type'        => Controls_Manager::SLIDER,
					'description' => esc_html__( 'Controls border width of framed social icons.', 'riode-core' ),
					'default'   => array(
						'px' => 2,
					),
					'range'       => array(
						'px' => array(
							'step' => 1,
							'min'  => 1,
							'max'  => 10,
						),
					),
					'condition'   => array(
						'type' => 'framed',
					),
					'selectors'   => array(
						'.elementor-element-{{ID}} .social-icon' => 'border-width: {{SIZE}}px',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		include RIODE_CORE_PATH . 'elementor/render/widget-share-render.php';
	}
}
