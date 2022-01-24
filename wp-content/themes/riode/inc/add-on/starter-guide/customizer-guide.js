( function ( wp, $ ) {
	'use strict';
	/**
	 * Guide Tooltip
	 * @param {*} $parent 
	 */
	( function () {
		// Riode Theme option
		$( window ).on( "load", function () {
			$.ajax( {
				url: riode_admin_vars.ajax_url,
				data: {
					action: 'riode_get_theme_option_guide',
					nonce: riode_admin_vars.nonce,
				},
				type: 'post',
				success: function ( res ) {
					try {
						if ( res == "disabled" ) return;

						function ToolTipContent( props ) {
							return (
								<>
									<h3>{ props.title }</h3>
									<img src={ `${ riode_admin_vars.theme_url }${ props.imgSrc }` } alt="Tooltip Image" />
									<p>{ props.content }</p>
								</>
							)
						}
						function GuideTooltip() {
							var toolTipWrapper = null;
							var doneTip = function () {
								$.ajax( {
									url: riode_admin_vars.ajax_url,
									data: {
										action: 'riode_disable_theme_option_guide',
										nonce: riode_admin_vars.nonce,
									},
									type: 'post',
									success: function ( res ) { }
								} );
								ReactDOM.unmountComponentAtNode( toolTipWrapper.parentNode );
								if ( document.querySelector( ".riode-tooltip-container" ) ) document.querySelector( ".riode-tooltip-container" ).remove();
							}
							var toolTipContent = [
								{
									title: "Riode Theme Option Tips",
									imgSrc: "/inc/add-on/starter-guide/capture.jpg",
									content: "First, external products are for linking off-site."
								},
								{
									title: "Riode Theme Option Tips",
									imgSrc: "/inc/add-on/starter-guide/capture.jpg",
									content: "Second, external products are for linking off-site."
								},
								{
									title: "Riode Theme Option Tips",
									imgSrc: "/inc/add-on/starter-guide/capture.jpg",
									content: "Finally, external products are for linking off-site."
								}
							]
							React.useEffect(
								() => {
									var $helpers = toolTipWrapper.querySelectorAll( ".riode-helper" );
									var i = 0;
									return;
								},
								[]
							);
							const [ stepCount, setStep ] = React.useState( 0 );
							return (
								<>
									<div class="riode-tooltip-wrapper" ref={ ( item ) => toolTipWrapper = ReactDOM.findDOMNode( item ) }>
										<div class="riode-helper">
											<div class="wp-pointer-left">
												<div class="riode-help-content">
													{
														toolTipContent.map( ( item, index ) =>
															stepCount == index && <ToolTipContent title={ item.title } imgSrc={ item.imgSrc } content={ item.content } />
														)
													}
													<div class="riode-help-actions">
														{ stepCount != 0 && <a href="#" class="button tip-prev" onClick={ () => setStep( prevStep => prevStep - 1 ) }>Prev</a> }
														<a href="#" class="button button-primary tip-next" onClick={ () => { toolTipContent.length == ( stepCount + 1 ) && doneTip(); setStep( prevStep => prevStep + 1 ) } }>{ toolTipContent.length == ( stepCount + 1 ) ? "Let's go" : "Next" }</a>
													</div>
													<div class="tip-close" onClick={ () => doneTip() }>
														<svg height="24" width="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" ><g><path d="M18.36 19.78L12 13.41l-6.36 6.37-1.42-1.42L10.59 12 4.22 5.64l1.42-1.42L12 10.59l6.36-6.36 1.41 1.41L13.41 12l6.36 6.36z"></path></g></svg>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="riode-welcome-container">
										<img src={ `${ riode_admin_vars.theme_url }/inc/add-on/starter-guide/riode-logo.png` } width="44" height="44" alt="donald logo" />
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
					} catch ( error ) {
						console.warn( error );
					}
				}
			} );
		} );
	} )()
} )( wp, jQuery );