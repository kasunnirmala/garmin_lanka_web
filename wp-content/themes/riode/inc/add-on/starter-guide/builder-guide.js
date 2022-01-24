( function ( wp, $ ) {
	'use strict';
	/**
	 * Guide Tooltip
	 * @param {*} $parent 
	 */
	$( window ).on( 'load', function () {
		$.ajax( {
			url: riode_core_vars.ajax_url,
			data: {
				action: 'riode_get_elementor_guide',
				nonce: riode_core_vars.nonce,
			},
			type: 'post',
			success: function ( res ) {
				try {
					if ( res == "disabled" ) return;

					// Elementor Preview
					function GuideTooltip() {
						var toolTipWrapper = null;
						var doneTip = function () {
							$.ajax( {
								url: riode_core_vars.ajax_url,
								data: {
									action: 'riode_disable_elementor_guide',
									nonce: riode_core_vars.nonce,
								},
								type: 'post',
								success: function ( res ) { }
							} );
							ReactDOM.unmountComponentAtNode( toolTipWrapper.parentNode );
							if ( document.querySelector( ".riode-tooltip-container" ) ) document.querySelector( ".riode-tooltip-container" ).remove();
						}
						React.useEffect(
							() => {
								var $helpers = toolTipWrapper.querySelectorAll( ".riode-helper" );
								var i = 0;
								for ( ; i < $helpers.length; i++ ) {
									var $el = $helpers[ i ];
									if ( $el.getAttribute( "data-tip" ) ) {
										var calculatePos = function ( $el ) {
											var tipDom = document.querySelector( $el.getAttribute( "data-tip" ) );
											var tipRect = tipDom.getBoundingClientRect();
											var offsetLeft = tipRect.left;
											var tipHeight = $el.clientHeight;
											if ( $el.classList.contains( 'wp-pointer-close' ) )
												$el.style.left = offsetLeft + 3 + "px";
											else
												$el.style.left = offsetLeft - 50 + "px";
											$el.style.top = tipRect.top - ( tipHeight ) - 10 + "px";
										}
										if ( i == 0 ) {
											$el.classList.add( "tip-active" );
											calculatePos( $el );
										}
										$( $el ).on( "click", ".tip-next", function () {
											var $self = $( this ).closest( '.riode-helper' ).get( 0 );
											if ( $self.classList.contains( "tip-active" ) ) {
												$self.classList.remove( "tip-active" );
												if ( $self.nextSibling ) {
													$self.nextSibling.classList.add( "tip-active" );
													calculatePos( $self.nextSibling );
												}
											}
										} );
									}
								}
								return;
							},
							[]
						);
						return (
							<>
								<div class="riode-tooltip-wrapper" ref={ ( item ) => toolTipWrapper = ReactDOM.findDOMNode( item ) }>
									<div class="riode-helper" data-tip="#riode-elementor-addons">
										<div class="wp-pointer-bottom">
											<div class="riode-help-content">
												<h3>Riode Addon</h3>
												<p>This is Riode Addon. You can build page fast using Riode Studio. And you can change settings display condition on Header or Footer Builder.</p>
												<div class="riode-help-actions">
													<a href="#" class="tip-skip" onClick={ () => doneTip() }>Click here to skip</a>
													<a href="#" class="tip-next">Next</a>
												</div>
											</div>
											<div class="wp-pointer-arrow">
												<div class="wp-pointer-arrow-inner">
												</div>
											</div>
										</div>
									</div>
									<div class="riode-helper wp-pointer-close" data-tip="#elementor-panel-footer-settings">
										<div class="wp-pointer-bottom">
											<div class="riode-help-content">
												<h3>Riode Custom Settings</h3>
												<p>Add custom css and javascript on your page or post.</p>
												<div class="riode-help-actions">
													<a href="#" class="tip-next" onClick={ () => doneTip() }>Done!</a>
												</div>
											</div>
											<div class="wp-pointer-arrow">
												<div class="wp-pointer-arrow-inner">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="riode-welcome-container">
									<img src={ `${ riode_core_vars.theme_url }/inc/add-on/starter-guide/riode-logo.png` } width="44" height="44" alt="donald logo" />
									<h2>Welcome</h2>
									<p>Thank you for using our Riode Theme. It helps you build website perfectly.</p>
								</div>
							</>
						)
					}
					var tooltipDiv = document.createElement( "div" );
					tooltipDiv.className = "riode-tooltip-container";
					document.body.appendChild( tooltipDiv );
					ReactDOM.render( <GuideTooltip />, tooltipDiv );
				}
				catch ( e ) {
					console.warn( e );
				}
			}
		} );
	} );
} )( wp, jQuery );