<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Riode Testimonial Widget
 *
 * Riode Widget to display testimonial.
 *
 * @since 1.0
 */

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use ELementor\Group_Control_Background;
use ELementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

class Riode_Testimonial_Elementor_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'riode_widget_testimonial';
	}

	public function get_title() {
		return esc_html__( 'Testimonial', 'riode-core' );
	}

	public function get_icon() {
		return 'riode-elementor-widget-icon widget-icon-testimonial';
	}

	public function get_categories() {
		return array( 'riode_widget' );
	}

	public function get_keywords() {
		return array( 'testimonial', 'rating', 'comment', 'review', 'customer' );
	}

	public function get_script_depends() {
		return array();
	}

	protected function register_controls() {
		$this->start_controls_section(
			'testimonial_content',
			array(
				'label' => esc_html__( 'Testimonial', 'riode-core' ),
			)
		);

			riode_elementor_testimonial_content_controls( $this );

			$this->add_control(
				'content_line',
				[
					'label'       => esc_html__( 'Maximum Content Line', 'riode-core' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '4',
					'selectors'   => array(
						'.elementor-element-{{ID}} .testimonial .comment' => '-webkit-line-clamp: {{VALUE}};',
					),
					'description' => esc_html__( 'Type a number which means the line of comment.', 'riode-core' ),
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'tesimonial_layout',
			array(
				'label' => esc_html__( 'Layout & Position', 'riode-core' ),
			)
		);

		riode_elementor_testimonial_type_controls( $this );

		$this->end_controls_section();

		riode_elementor_testimonial_style_controls( $this );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		include RIODE_CORE_PATH . 'elementor/render/widget-testimonial-render.php';
	}

	/**
	 * Render testimonial widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 */
	protected function content_template() {
		?><#
		var avatar_image = {
				id: settings.avatar.id,
				url: settings.avatar.url,
				size: settings.avatar_size,
				dimension: settings.avatar_custom_dimension,
				model: view.getEditModel()
			};

		var image = '',
			image_info;

		if ( '' !== settings.avatar.url ) {
			var imageHtml = '<img src="' + elementor.imagesManager.getImageUrl( avatar_image ) + '" alt="testimonial" />';
			if ( settings.link.url ) {
				imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
			}
			image = '<div class="avatar">' + imageHtml + '</div>';
		} else {
			image = '<div class="avatar icon"></div>';
		}

		if ( 'top' === settings.avatar_pos || 'aside' === settings.avatar_pos || 'after_title' === settings.avatar_pos || 'simple' === settings.testimonial_type || 'boxed' === settings.testimonial_type ) {
			image_info = '';
		} else {
			image_info = image;
			image = '';
		}

		view.addRenderAttribute( 'content', 'class', 'comment' );
		view.addInlineEditingAttributes( 'content' );
		view.addRenderAttribute( 'name', 'class', 'name' );
		view.addInlineEditingAttributes( 'name' );
		view.addRenderAttribute( 'job', 'class', 'job' );
		view.addInlineEditingAttributes( 'job' );

		var commentor = '<cite><span ' + view.getRenderAttributeString( 'name' ) + '>' + settings.name +
			'</span><span ' + view.getRenderAttributeString( 'job' ) + '>' + settings.job + '</span></cite>';
		if ( 'custom' === settings.testimonial_type ) {
		#>
		<blockquote class="testimonial {{ settings.avatar_pos }}">
			<# if ( 'after_title' !== settings.avatar_pos ) { #>
			{{{ image }}}
			<# } #>
			<#
			if ( 'aside' === settings.avatar_pos ) { #>
				<div class="content">
			<# }

			if ( 'before' === settings.commenter_pos ) { #>
				<div class="commenter">{{{ image_info }}}{{{ commentor }}}</div>
			<# }

			if ( '' !== settings.rating && 'before' == settings.rating_pos ) {
				var rating_cls = '';
				if ( settings.star_icon ) {
					rating_cls += ' ' + settings.star_icon;
				}
				if ( settings.star_shape ) {
					rating_cls += ' ' + settings.star_shape;
				}

				view.addRenderAttribute( 'rating', 'style', 'width:' + ( 20 * settings.rating ) + '%;' );
				view.addRenderAttribute( 'rating', 'class', 'ratings' );
				#>
				<div class="ratings-container"><div class="ratings-full{{ rating_cls }}"><span {{{ view.getRenderAttributeString( 'rating' ) }}}></span></div></div>
			<#
			}

			if ( '' !== settings.title ) {
				view.addRenderAttribute( 'title', 'class', 'comment-title' );
				view.addInlineEditingAttributes( 'title' );
				#>
				<h5 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h5>
				<#
			}

			if ( 'after_title' === settings.avatar_pos ) { #>
				{{{ image }}}
			<#
			}
			#>
			<p {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</p>
			<#

			if ( '' !== settings.rating && 'after' == settings.rating_pos ) {
				var rating_cls = '';
				if ( settings.star_icon ) {
					rating_cls += ' ' + settings.star_icon;
				}
				if ( settings.star_shape ) {
					rating_cls += ' ' + settings.star_shape;
				}
				view.addRenderAttribute( 'rating', 'style', 'width:' + ( 20 * settings.rating ) + '%;' );
				view.addRenderAttribute( 'rating', 'class', 'ratings' );
				#>
				<div class="ratings-container"><div class="ratings-full{{ rating_cls }}"><span {{{ view.getRenderAttributeString( 'rating' ) }}}></span></div></div>
			<#
			}

			if ( 'after' === settings.commenter_pos ) { #>
				<div class="commenter">{{{ image_info }}}{{{ commentor }}}</div>
			<# }

			if ( 'aside' === settings.avatar_pos ) { #>
				</div>
			<# } #>
		</blockquote>
		<# } else if ( 'simple' === settings.testimonial_type ) { 
			var aclass = '';
			if ( 'yes' == settings.testimonial_inverse ) {
				aclass = 'inversed';
			}
		#>
			<blockquote class="testimonial testimonial-simple {{{ aclass }}}">
				<div class="content">
					<# if ( '' !== settings.title ) {
						view.addRenderAttribute( 'title', 'class', 'comment-title' );
						view.addInlineEditingAttributes( 'title' );
						#>
						<h5 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h5>
						<#
					} #>
					<p {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</p>
					<#
					if ( '' !== settings.rating ) {
						var rating_cls = '';
						if ( settings.star_icon ) {
							rating_cls += ' ' + settings.star_icon;
						}
						if ( settings.star_shape ) {
							rating_cls += ' ' + settings.star_shape;
						}

						view.addRenderAttribute( 'rating', 'style', 'width: ' + ( 20 * settings.rating ) + '%;' );
						view.addRenderAttribute( 'rating', 'class', 'ratings' );
					#>
						<div class="ratings-container"><div class="ratings-full{{ rating_cls }}"><span {{{ view.getRenderAttributeString( 'rating' ) }}}></span></div></div>
					<#
					}
					#>
				</div>
				<div class="commenter">{{{ image }}}{{{ commentor }}}</div>
			</blockquote>
		<# } else if ( 'boxed' === settings.testimonial_type ) {
			view.addRenderAttribute( 'title', 'class', 'comment-title' );
			view.addInlineEditingAttributes( 'title' );
		#>
			<blockquote class="testimonial testimonial-boxed">
				<h5 {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</h5>
				{{{ image }}}
				<div class="content"><p {{{ view.getRenderAttributeString( 'content' ) }}}>{{{ settings.content }}}</p></div>
				<#
				if ( '' !== settings.rating ) {
					var rating_cls = '';
					if ( settings.star_icon ) {
						rating_cls += ' ' + settings.star_icon;
					}
					if ( settings.star_shape ) {
						rating_cls += ' ' + settings.star_shape;
					}

					view.addRenderAttribute( 'rating', 'style', 'width: ' + ( 20 * settings.rating ) + '%;' );
					view.addRenderAttribute( 'rating', 'class', 'ratings' );
				#>
					<div class="ratings-container"><div class="ratings-full{{ rating_cls }}"><span {{{ view.getRenderAttributeString( 'rating' ) }}}></span></div></div>
				<#
				}
				#>
				<div class="commenter">{{{ commentor }}}</div>
			</blockquote>
		<# } #>
		<?php
	}
}
