<?php
/**
 * Riode Header Elementor Account
 */
defined( 'ABSPATH' ) || die;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

class Riode_Header_Account_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_header_account';
	}

	public function get_title() {
		return esc_html__( 'Account', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon eicon-lock-user';
	}

	public function get_categories() {
		return array( 'riode_header_widget' );
	}

	public function get_keywords() {
		return array( 'header', 'riode', 'account', 'login', 'register', 'sign' );
	}

	public function get_script_depends() {
		$depends = array();
		if ( riode_is_elementor_preview() ) {
			$depends[] = 'riode-elementor-js';
		}
		return $depends;
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_account_content',
			array(
				'label' => esc_html__( 'Account', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

			$this->add_control(
				'type',
				array(
					'label'   => esc_html__( 'Account Type', 'riode-core' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'inline',
					'options' => array(
						'block'  => array(
							'title' => esc_html__( 'Block', 'riode-core' ),
							'icon'  => 'eicon-v-align-bottom',
						),
						'inline' => array(
							'title' => esc_html__( 'Inline', 'riode-core' ),
							'icon'  => 'eicon-h-align-right',
						),
					),
				)
			);

			$this->add_control(
				'account_items',
				array(
					'label'    => esc_html__( 'Show Items', 'riode-core' ),
					'type'     => Controls_Manager::SELECT2,
					'multiple' => true,
					'default'  => array(
						'icon',
						'login',
					),
					'options'  => array(
						'icon'     => esc_html__( 'User Icon/Avatar', 'riode-core' ),
						'login'    => esc_html__( 'Login/Logout Label', 'riode-core' ),
						'register' => esc_html__( 'Register Label', 'riode-core' ),
					),
				)
			);

			$this->add_control(
				'icon',
				array(
					'label'   => esc_html__( 'Icon', 'riode-core' ),
					'type'    => Controls_Manager::ICONS,
					'default' => array(
						'value'   => 'd-icon-user',
						'library' => 'riode-icons',
					),
				)
			);

			$this->add_control(
				'account_login',
				array(
					'label'   => esc_html__( 'Login Text', 'riode-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'Log in',
				)
			);

			$this->add_control(
				'account_register',
				array(
					'label'   => esc_html__( 'Register Text', 'riode-core' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 'Register',
				)
			);

			$this->add_control(
				'account_delimiter',
				array(
					'label'       => esc_html__( 'Delimiter Text', 'riode-core' ),
					'description' => esc_html__( 'Account Delimiter will be shown between Login and Register links', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '/',
				)
			);

			$this->add_control(
				'label_heading2',
				array(
					'label'     => esc_html__( 'When user is logged in...', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_control(
				'account_dropdown',
				array(
					'label'       => esc_html__( 'Menu Dropdown', 'riode-core' ),
					'type'        => Controls_Manager::SWITCHER,
					'default'     => '',
					'description' => esc_html__( 'Menu that is located in Account Menu will be shown.', 'riode-core' ),
				)
			);

			$this->add_control(
				'account_logout',
				array(
					'label'       => esc_html__( 'Logout Text', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Log out',
					'description' => esc_html__( 'Please input %name% where you want to show current user name. ( ex: Hi, %name%! )', 'riode-core' ),
				)
			);

			$this->add_control(
				'account_avatar',
				array(
					'label'   => esc_html__( 'Show Avatar', 'riode-core' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
				)
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_account_style',
			array(
				'label' => esc_html__( 'Account', 'riode-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'account_typography',
					'selector' => '.elementor-element-{{ID}} .account > a',
				)
			);

			$this->add_responsive_control(
				'account_icon',
				array(
					'label'      => esc_html__( 'Icon Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .account i' => 'font-size: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_icon_space',
				array(
					'label'      => esc_html__( 'Icon Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .block-type i + span' => 'margin-top: {{SIZE}}px;',
						'.elementor-element-{{ID}} .inline-type i + span' => 'margin-left: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_avatar_size',
				array(
					'label'      => esc_html__( 'Avatar Size (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .account-avatar' => 'width: {{SIZE}}px; height: {{SIZE}}px;',
					),
				)
			);

			$this->add_responsive_control(
				'account_avatar_space',
				array(
					'label'      => esc_html__( 'Avatar Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .inline-type .account-avatar' => 'margin-right: {{SIZE}}px;',
						'.elementor-element-{{ID}} .block-type .account-avatar' => 'margin-bottom: {{SIZE}}px;',
					),
				)
			);

			$this->start_controls_tabs( 'tabs_account_color' );
				$this->start_controls_tab(
					'tab_account_normal',
					array(
						'label' => esc_html__( 'Normal', 'riode-core' ),
					)
				);

				$this->add_control(
					'account_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .account > a' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'tab_account_hover',
					array(
						'label' => esc_html__( 'Hover', 'riode-core' ),
					)
				);

				$this->add_control(
					'account_hover_color',
					array(
						'label'     => esc_html__( 'Color', 'riode-core' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => array(
							'.elementor-element-{{ID}} .account > a:hover, .elementor-element-{{ID}} .account-dropdown:hover > .logout' => 'color: {{VALUE}};',
						),
					)
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'delimiter_heading',
				array(
					'label'     => esc_html__( 'Delimiter', 'riode-core' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => 'deimiter_typography',
					'selector' => '.elementor-element-{{ID}} .account .delimiter',
				)
			);

			$this->add_control(
				'delimiter_color',
				array(
					'label'     => esc_html__( 'Color', 'riode-core' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'.elementor-element-{{ID}} .account .delimiter' => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				'account_delimiter_space',
				array(
					'label'      => esc_html__( 'Delimiter Space (px)', 'riode-core' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array( 'px' ),
					'selectors'  => array(
						'.elementor-element-{{ID}} .account .delimiter' => 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px;',
					),
				)
			);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$args = array(
			'type'             => $settings['type'],
			'items'            => $settings['account_items'],
			'login_text'       => $settings['account_login'] ? $settings['account_login'] : 'Log in',
			'logout_text'      => $settings['account_logout'] ? $settings['account_logout'] : 'Log out',
			'register_text'    => $settings['account_register'] ? $settings['account_register'] : 'Register',
			'delimiter_text'   => $settings['account_delimiter'],
			'icon'             => isset( $settings['icon']['value'] ) && $settings['icon']['value'] ? $settings['icon']['value'] : 'd-icon-user',
			'account_dropdown' => 'yes' == $settings['account_dropdown'],
			'account_avatar'   => 'yes' == $settings['account_avatar'],
		);

		if ( defined( 'RIODE_VERSION' ) ) {
			riode_get_template_part( RIODE_PART . '/header/elements/element-account', null, $args );
		}
	}
}
