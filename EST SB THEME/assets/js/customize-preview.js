

(function( $ ) {

	wp.customize.bind( 'preview-ready', function() {

		$( '.panel-placeholder' ).hide();

		wp.customize.preview.bind( 'section-highlight', function( data ) {

			if ( ! $( 'body' ).hasClass( 'estsbtheme-front-page' ) ) {
				return;
			}

			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'highlight-front-sections' );
				$( '.panel-placeholder' ).slideDown( 200, function() {
					$.scrollTo( $( '#panel1' ), {
						duration: 600,
						offset: { 'top': -70 } // Account for sticky menu.
					});
				});

			} else {
				$( 'body' ).removeClass( 'highlight-front-sections' );
				$( '.panel-placeholder' ).slideUp( 200 );
			}
		});
	});

	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		});
	});
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		});
	});

	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute'
				});
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {

				if ( ! to.length ) {
					$( '#estsbtheme-custom-header-styles' ).remove();
				}
				$( '.site-title, .site-description' ).css({
					clip: 'auto',
					position: 'relative'
				});
				$( '.site-branding, .site-branding a, .site-description, .site-description a' ).css({
					color: to
				});
				$( 'body' ).removeClass( 'title-tagline-hidden' );
			}
		});
	});

	wp.customize( 'colorscheme', function( value ) {
		value.bind( function( to ) {

			$( 'body' )
				.removeClass( 'colors-light colors-dark colors-custom' )
				.addClass( 'colors-' + to );
		});
	});

	wp.customize( 'colorscheme_hue', function( value ) {
		value.bind( function( to ) {

			var style = $( '#custom-theme-colors' ),
				hue = style.data( 'hue' ),
				css = style.html();

			css = css.split( hue + ',' ).join( to + ',' );
			style.html( css ).data( 'hue', to );
		});
	});

	wp.customize( 'page_layout', function( value ) {
		value.bind( function( to ) {
			if ( 'one-column' === to ) {
				$( 'body' ).addClass( 'page-one-column' ).removeClass( 'page-two-column' );
			} else {
				$( 'body' ).removeClass( 'page-one-column' ).addClass( 'page-two-column' );
			}
		} );
	} );

	function hasHeaderImage() {
		var image = wp.customize( 'header_image' )();
		return '' !== image && 'remove-header' !== image;
	}

	function hasHeaderVideo() {
		var externalVideo = wp.customize( 'external_header_video' )(),
			video = wp.customize( 'header_video' )();

		return '' !== externalVideo || ( 0 !== video && '' !== video );
	}

	$.each( [ 'external_header_video', 'header_image', 'header_video' ], function( index, settingId ) {
		wp.customize( settingId, function( setting ) {
			setting.bind(function() {
				if ( hasHeaderImage() ) {
					$( document.body ).addClass( 'has-header-image' );
				} else {
					$( document.body ).removeClass( 'has-header-image' );
				}

				if ( ! hasHeaderVideo() ) {
					$( document.body ).removeClass( 'has-header-video' );
				}
			} );
		} );
	} );

} )( jQuery );
