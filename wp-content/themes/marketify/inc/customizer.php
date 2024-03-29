<?php
/**
 * Customize
 *
 * Theme options are lame! Manage any customizations through the Theme
 * Customizer. Expose the customizer in the Appearance panel for easy access.
 *
 * @package Marketify
 * @since Marketify 1.0
 */

/**
 * Get Theme Mod
 *
 * Instead of options, customizations are stored/accessed via Theme Mods
 * (which are still technically settings). This wrapper provides a way to
 * check for an existing mod, or load a default in its place.
 *
 * @since Marketify 1.0
 *
 * @param string $key The key of the theme mod to check. Prefixed with 'marketify_'
 * @return mixed The theme modification setting
 */
function marketify_theme_mod( $section, $key, $_default = false ) {
	$mods = marketify_get_theme_mods();

	$default = isset( $mods[ $section ][ $key ][ 'default' ] ) ? $mods[ $section ][ $key ][ 'default' ] : null;

	if ( $_default )
		$mod = $default;
	else
		$mod = get_theme_mod( $key, $default );

	return apply_filters( 'marketify_theme_mod_' . $key, $mod );
}

/**
 * Register two new sections: General, and Social.
 *
 * @since Marketify 1.0
 *
 * @param object $wp_customize
 * @return void
 */
function marketify_customize_register_sections( $wp_customize ) {
	$wp_customize->add_section( 'general', array(
		'title'      => _x( 'General', 'Theme customizer section title', 'marketify' ),
		'priority'   => 10,
	) );

	$wp_customize->add_section( 'product-display', array(
		'title'      => _x( 'Product Display', 'Theme customizer section title', 'marketify' ),
		'priority'   => 15,
	) );

	$wp_customize->add_section( 'footer', array(
		'title'      => _x( 'Footer', 'Theme customizer section title', 'marketify' ),
		'priority'   => 100,
	) );
}
add_action( 'customize_register', 'marketify_customize_register_sections' );

/**
 * Default theme customizations.
 *
 * @since Marketify 1.0
 *
 * @return $options an array of default theme options
 */
function marketify_get_theme_mods( $args = array() ) {
	$defaults = array(
		'keys_only' => false
	);

	$args = wp_parse_args( $args, $defaults );

	$mods = array(
		'general' => array(
			'general-downloads-label-singular' => array(
				'title'   => __( 'Download Label Singular', 'marketify' ),
				'type'    => 'text',
				'default' => 'Download'
			),
			'general-downloads-label-plural' => array(
				'title'   => __( 'Download Label Plural', 'marketify' ),
				'type'    => 'text',
				'default' => 'Downloads'
			)
		),
		'product-display' => array(
			'grid-width' => array(
				'title'   => __( 'Grid Image Width (px)', 'marketify' ),
				'type'    => 'number',
				'default' => 640,
				'priority' => 7
			),
			'grid-height' => array(
				'title'   => __( 'Grid Image Height (px)', 'marketify' ),
				'type'    => 'number',
				'default' => 520,
				'priority' => 8
			),
			'grid-crop' => array(
				'title' => __( 'Hard Crop Grid Images', 'marketify' ),
				'type' => 'checkbox',
				'std' => 1,
				'priority' => 9
			),
			'product-display-columns' => array(
				'title'   => __( 'Grid Columns', 'marketify' ),
				'type'    => 'select',
				'default' => 3,
				'choices' => array(
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4
				),
				'priority' => 10
			),
			'product-display-single-style' => array(
				'title'   => __( 'Single Display Style', 'marketify' ),
				'type'    => 'radio',
				'default' => 'classic',
				'choices' => array(
					'classic' => __( 'Featured Header Slider', 'marketify' ),
					'grid'    => __( 'Inline Switcher', 'marketify' )
				),
				'priority' => 20
			),
			'product-display-grid-info' => array(
				'title'   => __( 'Grid Product Information', 'marketify' ),
				'type'    => 'radio',
				'default' => 0,
				'choices' => array(
					0 => __( 'Auto', 'marketify' ),
					1 => __( 'Always show', 'marketify' ),
					2 => __( 'Never show', 'marketify' )
				),
				'priority' => 30
			),
			'product-display-excerpt' => array(
				'title'   => __( 'Display excerpt on grid items', 'marketify' ),
				'type'    => 'checkbox',
				'std'     => 0,
				'priority' => 40
			),
			'product-display-truncate-title' => array(
				'title'   => __( 'Truncate grid item titles', 'marketify' ),
				'type'    => 'checkbox',
				'std'     => 0,
				'priority' => 50
			),
			'product-display-show-buy' => array(
				'title'   => __( 'Always show buy button', 'marketify' ),
				'type'    => 'checkbox',
				'std'     => 0,
				'priority' => 60
			)
		),
		'footer' => array(
			'footer-style' => array(
				'title'   => __( 'Style', 'marketify' ),
				'type'    => 'select',
				'choices' => array(
					'dark'  => __( 'Dark', 'marketify' ),
					'light' => __( 'Light', 'marketify' )
				),
				'default' => 'dark'
			),
			'footer-contact-address' => array(
				'title'   => __( 'Contact Address', 'marketify' ),
				'type'    => 'Marketify_Customize_Textarea_Control',
				'default' => "393 Bay Street, 2nd Floor\nToronto, Ontario, Canada, L9T8S2"
			),
			'footer-logo' => array(
				'title'   => __( 'Logo', 'marketify' ),
				'type'    => 'WP_Customize_Image_Control',
				'default' => 0
			)
		),
		'colors' => array(
			'header'  => array(
				'title'   => __( 'Page Header Color', 'marketify' ),
				'type'    => 'WP_Customize_Color_Control',
				'default' => '#515a63'
			),
			'primary' => array(
				'title'   => __( 'Button/Primary Color', 'marketify' ),
				'type'    => 'WP_Customize_Color_Control',
				'default' => '#515a63'
			),
			'accent' => array(
				'title'   => __( 'Accent Color', 'marketify' ),
				'type'    => 'WP_Customize_Color_Control',
				'default' => '#4ed0aa'
			)
		),
	);

	$mods = apply_filters( 'marketify_theme_mods', $mods );

	/** Return all keys within all sections (for transport, etc) */
	if ( $args[ 'keys_only' ] ) {
		$keys = array();
		$final = array();

		foreach ( $mods as $section ) {
			$keys = array_merge( $keys, array_keys( $section ) );
		}

		foreach ( $keys as $key ) {
			$final[ $key ] = '';
		}

		return $final;
	}

	return $mods;
}

/**
 * Register settings.
 *
 * Take the final list of theme mods, and register all the settings,
 * and add all of the proper controls.
 *
 * If the type is one of the default supported ones, add it normally. Otherwise
 * Use the type to create a new instance of that control type.
 *
 * @since Marketify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function marketify_customize_register_settings( $wp_customize ) {
	$mods = marketify_get_theme_mods();

	foreach ( $mods as $section => $settings ) {
		foreach ( $settings as $key => $setting ) {
			$wp_customize->add_setting( $key, array(
				'default'    => marketify_theme_mod( $section, $key, true ),
			) );

			$type = $setting[ 'type' ];

			if ( in_array( $type, array( 'text', 'number', 'checkbox', 'radio', 'select', 'dropdown-pages' ) ) ) {
				$wp_customize->add_control( $key, array(
					'label'      => $setting[ 'title' ],
					'section'    => $section,
					'settings'   => $key,
					'type'       => $type,
					'choices'    => isset ( $setting[ 'choices' ] ) ? $setting[ 'choices' ] : null,
					'priority'   => isset ( $setting[ 'priority' ] ) ? $setting[ 'priority' ] : null
				) );
			} else {
				$wp_customize->add_control( new $type( $wp_customize, $key, array(
					'label'      => $setting[ 'title' ],
					'section'    => $section,
					'settings'   => $key,
					'priority'   => isset ( $setting[ 'priority' ] ) ? $setting[ 'priority' ] : null
				) ) );
			}
		}
	}

	do_action( 'marketify_customize_regiser_settings', $wp_customize );

	return $wp_customize;
}
add_action( 'customize_register', 'marketify_customize_register_settings' );

/**
 * Add postMessage support for all default fields, as well
 * as the site title and desceription for the Theme Customizer.
 *
 * @since Marketify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function marketify_customize_register_transport( $wp_customize ) {
	$built_in  = array( 'blogname' => '', 'blogdescription' => '', 'header_textcolor' => '' );
	$marketify = marketify_get_theme_mods( array( 'keys_only' => true ) );

	$transport = array_merge( $built_in, $marketify );

	foreach ( $transport as $key => $default ) {
		$wp_customize->get_setting( $key )->transport = 'refresh';
	}
}
add_action( 'customize_register', 'marketify_customize_register_transport' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Marketify 1.0
 */
function marketify_customize_preview_js() {
	wp_enqueue_script( 'marketify-customizer', get_template_directory_uri() . '/js/app/customizer.js', array( 'customize-preview' ), 20140210, true );
}
add_action( 'customize_preview_init', 'marketify_customize_preview_js' );

/**
 * Textarea Control
 *
 * Attach the custom textarea control to the `customize_register` action
 * so the WP_Customize_Control class is initiated.
 *
 * @since Marketify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function marketify_customize_textarea_control( $wp_customize ) {
	/**
	 * Textarea Control
	 *
	 * @since Marketify 1.0
	 */
	class Marketify_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
	?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
	<?php
		}
	}
}
add_action( 'customize_register', 'marketify_customize_textarea_control', 1, 1 );

function marketify_hex2rgb($hex) {
	$hex = str_replace( '#', '', $hex);

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}

	$rgb = array($r, $g, $b);

	return implode(",", $rgb);
}

/**
 * Output the basic extra CSS for primary and accent colors.
 * Split away from widget colors for brevity.
 *
 * @since Marketify 1.0
 */
function marketify_header_css() {
	$css = "
	.header-outer:not(.custom-featured-image) .site-header,
	.header-outer:not(.custom-featured-image) .page-header,
	.site-footer,
	body.minimal,
	body.custom-background.minimal,
	.header-outer,
	.minimal .entry-content .edd-slg-social-container span legend {
		background-color: " . marketify_theme_mod( 'colors', 'header' ) . ";
	}

	button,
	input[type=reset],
	input[type=submit],
	.button,
	a.button,
	.fes-button,
	.main-navigation .edd-cart .cart_item.edd_checkout a,
	.page-header .button:hover,
	.content-grid-download .button:hover,
	body .marketify_widget_slider_hero .soliloquy-caption a.button:hover,
	#edd_checkout_form_wrap fieldset#edd_cc_fields legend,
	.marketify_widget_featured_popular .home-widget-title span:hover,
	.marketify_widget_featured_popular .home-widget-title span.active,
	.nav-previous a:hover i,
	.nav-next a:hover i,
	body-footer.light .site-info .site-title,
	body a.edd-wl-action,
	body a.edd-wl-action.edd-wl-button,
	#recaptcha_area .recaptchatable a,
	#recaptcha_area .recaptchatable a:hover,
	.fes-feat-image-btn,
	.upload_file_button,
	.fes-avatar-image-btn {
		color: " . marketify_theme_mod( 'colors', 'primary' ) . ";
	}

	button,
	input[type=reset],
	input[type=submit],
	.button,
	a.button,
	.fes-button,
	.edd_price_options input[type=radio]:checked,
	body #edd-wl-modal input[type=radio]:checked,
	#edd_checkout_form_wrap fieldset#edd_cc_fields legend,
	.marketify_widget_featured_popular .home-widget-title span:hover,
	.marketify_widget_featured_popular .home-widget-title span.active,
	.entry-content blockquote,
	.nav-previous a:hover,
	.nav-next a:hover,
	body a.edd-wl-action,
	body a.edd-wl-action.edd-wl-button,
	body a.edd-wl-action.edd-wl-button:hover,
	.fes-feat-image-btn,
	.upload_file_button,
	.fes-avatar-image-btn {
		border-color: " . marketify_theme_mod( 'colors', 'primary' ) . ";
	}

	button:hover,
	input[type=reset]:hover,
	input[type=submit]:hover,
	.button:hover,
	a.button:hover,
	#edd_checkout_form_wrap fieldset#edd_cc_fields > span:after,
	.edd-reviews-voting-buttons a:hover,
	.flex-control-nav a.flex-active,
	.search-form .search-submit,
	.fes-pagination a.page-numbers:hover,
	body a.edd-wl-action.edd-wl-button:hover,
	.fes-feat-image-btn:hover,
	.upload_file_button:hover,
	.fes-avatar-image-btn:hover {
		background-color: " . marketify_theme_mod( 'colors', 'primary' ) . ";
	}

	a.edd-cart-saving-button,
	input[name=edd_update_cart_submit],
	.main-navigation .edd-cart .cart_item.edd_checkout a,
	.download-variable .entry-content .edd-add-to-cart.button.edd-submit:hover,
	.download-variable .entry-content .edd_go_to_checkout.button.edd-submit:hover,
	.popup .edd-add-to-cart.button.edd-submit:hover,
	.edd-reviews-voting-buttons a,
	a.edd-fes-adf-submission-add-option-button,
	#fes-insert-image,
	#fes-view-comment a,
	a.edd_terms_links {
		color: " . marketify_theme_mod( 'colors', 'accent' ) . ";
	}

	a.edd-cart-saving-button,
	input[name=edd_update_cart_submit],
	.main-navigation .edd-cart .cart_item.edd_checkout a:hover,
	.download-variable .entry-content .edd-add-to-cart.button.edd-submit:hover,
	.download-variable .entry-content .edd_go_to_checkout.button.edd-submit:hover,
	.popup .edd-add-to-cart.button.edd-submit:hover,
	.popup .edd_go_to_checkout.button.edd-submit,
	.popup .edd_go_to_checkout.button.edd-submit:hover,
	.edd-reviews-voting-buttons a,
	.edd-fes-adf-submission-add-option-button,
	#fes-insert-image,
	#fes-view-comment a,
	.edd_terms_links,
	.site-footer.dark .mailbag-wrap input[type=submit],
	.insert-file-row {
		border-color: " . marketify_theme_mod( 'colors', 'accent' ) . ";
	}

	a.edd-cart-saving-button:hover,
	input[name=edd_update_cart_submit]:hover,
	.minimal #edd_purchase_submit input[type=submit],
	.main-navigation .edd-cart .cart_item.edd_checkout a:hover,
	.minimal a.edd-cart-saving-button,
	.minimal input[name=edd_update_cart_submit],
	.minimal .fes-form input[type=submit],
	.popup .edd_go_to_checkout.button.edd-submit,
	.popup .edd_go_to_checkout.button.edd-submit:hover,
	.main-navigation .search-form.active .search-submit,
	.main-navigation.toggled .search-form .search-submit,
	.edd-fes-adf-submission-add-option-button:hover,
	#fes-insert-image:hover,
	.edd-reviews-voting-buttons a:hover,
	.minimal #edd_login_submit,
	.minimal input[name=edd_register_submit],
	.edd_terms_links:hover,
	.site-footer.dark .mailbag-wrap input[type=submit],
	.home-search .page-header .search-submit,
	.search-form-overlay .search-submit,
	.marketify_widget_taxonomy_stylized,
	.insert-file-row {
		background-color: " . marketify_theme_mod( 'colors', 'accent' ) . ";
	}

	.site-footer.light, {
		background-color: #" . get_theme_mod( 'background_color' ) . ";
	}

	.content-grid-download .entry-image:hover .overlay,
	.content-grid-download .entry-image.hover .overlay,
	.download-image-grid-preview .slides li.active a:before,
	.download-image-grid-preview .slides li:hover a:before {
		background: rgba( " . marketify_hex2rgb( marketify_theme_mod( 'colors', 'primary' ) ) . ", .80 );
		border: 1px solid rgba( " . marketify_hex2rgb( marketify_theme_mod( 'colors', 'primary' ) ) . ", .80 );
	}

	.search-form-overlay {
		background: rgba( " . marketify_hex2rgb( marketify_theme_mod( 'colors', 'primary' ) ) . ", .90 );
	}
	";

	wp_add_inline_style( 'marketify-base', trim( str_replace( array( "\t", "\r", "\n" ), '', $css ) ) );
}
add_action( 'wp_enqueue_scripts', 'marketify_header_css' );
