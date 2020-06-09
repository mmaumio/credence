<?php
/**
 * Customizer settings for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

if ( ! class_exists( 'Cred_Customize' ) ) :
	/**
	 * CUSTOMIZER SETTINGS
	 */
	class Cred_Customize {

		/**
		 * Register customizer options.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public static function register( $wp_customize ) {

			/**
			 * Site Title & Description.
			 * */
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => 'cred_customize_partial_blogname'
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => 'cred_customize_partial_blogdescription'
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'custom_logo',
				array(
					'selector'        => '.header-titles [class*=site-]:not(.site-description)',
					'render_callback' => 'cred_customize_partial_site_logo'
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'retina_logo',
				array(
					'selector'        => '.header-titles [class*=site-]:not(.site-description)',
					'render_callback' => 'cred_customize_partial_site_logo'
				)
			);

			/**
			 * Site Identity
			 */

			/* 2X Header Logo ---------------- */

			$wp_customize->add_section(
				'title_tagline',
				array(
					'panel'    => 'cred_header_panel',
					'title'    => __( 'Site Identity', 'credence' ),
					'priority' => 20
				)
			);

			$wp_customize->add_setting(
				'retina_logo',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
					'transport'         => 'postMessage'
				)
			);

			$wp_customize->add_control(
				'retina_logo',
				array(
					'type'        => 'checkbox',
					'section'     => 'title_tagline',
					'priority'    => 10,
					'label'       => __( 'Retina logo', 'credence' ),
					'description' => __( 'Scales the logo to half its uploaded size, making it sharp on high-res screens.', 'credence' )
				)
			);

			$wp_customize->add_setting(
				'cred_enable_site_tagline',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_site_tagline',
				array(
					'type'     => 'checkbox',
					'section'  => 'title_tagline',
					'priority' => 10,
					'label'    => __( 'Show Tagline', 'credence' )
				)
			);

			// Update background color with postMessage, so inline CSS output is updated as well.
			$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

			/**
			 * Typography section
			 */

			$wp_customize-> add_section(
				'cred_typography_section',
				array(
					'title'      => __( 'Typography', 'credence' ),
					'priority'   => 40,
					'capability' => 'edit_theme_options'
				)
			);

			// Header Typography
			$wp_customize->add_setting( 
				'cred_cred_header_google_font_heading', 
				array(
					'sanitize_callback' => 'sanitize_text'
				) 
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_cred_header_google_font_heading',
					array(
						'label'      => __( 'Header Menu Font', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_header_google_font_list', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_header_google_font_list', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_header_google_font_list'
			) ) );

			//Body Font
			$wp_customize->add_setting( 
				'cred_heading_body_font', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_body_font',
					array(
						'label'      => __( 'Body Font', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_body_font_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_body_font_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_body_font_typo'
			) ) );

			$wp_customize->add_setting( 'cred_body_font', array(
				'default' => '15',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_body_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'settings'    => 'cred_body_font',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			//Heading 1

			$wp_customize->add_setting( 
				'cred_heading_1', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_1',
					array(
						'label'      => __( 'Heading 1', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_heading_1_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_heading_1_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_heading_1_typo'
			) ) );

			$wp_customize->add_setting( 'cred_heading_1_font', array(
				'default' => '42',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_heading_1_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'settings'    => 'cred_heading_1_font',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			//Heading 2

			$wp_customize->add_setting( 
				'cred_heading_2', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_2',
					array(
						'label'      => __( 'Heading 2', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_heading_2_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_heading_2_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_heading_2_typo'
			) ) );

			$wp_customize->add_setting( 'cred_heading_2_font', array(
				'default'    => '36',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_heading_2_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			//Heading 3
			$wp_customize->add_setting( 
				'cred_heading_3', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_3',
					array(
						'label'      => __( 'Heading 3', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_heading_3_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_heading_3_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_heading_3_typo'
			) ) );

			$wp_customize->add_setting( 'cred_heading_3_font', array(
				'default'    => '30',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_heading_3_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			//Heading 4
			$wp_customize->add_setting( 
				'cred_heading_4', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_4',
					array(
						'label'      => __( 'Heading 4', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_heading_4_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_heading_4_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_heading_4_typo'
			) ) );

			$wp_customize->add_setting( 'cred_heading_4_font', array(
				'default'    => '24',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_heading_4_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			//Heading 5
			$wp_customize->add_setting( 
				'cred_heading_5', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_5',
					array(
						'label'      => __( 'Heading 5', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_heading_5_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_heading_5_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_heading_5_typo'
			) ) );

			$wp_customize->add_setting( 'cred_heading_5_font', array(
				'default'    => '20',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_heading_5_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			//Heading 6
			$wp_customize->add_setting( 
				'cred_heading_6', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				)
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_heading_6',
					array(
						'label'      => __( 'Heading 6', 'credence' ),
						'section'    => 'cred_typography_section'
					)
				)
			);

			$wp_customize->add_setting( 'cred_heading_6_typo', array(
				'default'           => 'Roboto',
				'sanitize_callback' => array( __CLASS__, 'sanitize_fonts' )
			) );

			$wp_customize->add_control( new Cred_Google_Font_Dropdown_Custom_Control( $wp_customize, 'cred_heading_6_typo', array(
				'label'      => __( 'Typography', 'credence' ),
				'section'    => 'cred_typography_section',
				'settings'   => 'cred_heading_6_typo'
			) ) );

			$wp_customize->add_setting( 'cred_heading_6_font', array(
				'default' => '16',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_heading_6_font',
					array(
						'label'       => __( 'Font Size ( px )', 'credence' ),
						'section'     => 'cred_typography_section',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 100,
							'step' => 1
						)
					)
				)
			);

			/**
			 * Layout section
			 */
			$wp_customize-> add_section(
				'cred_layout_section',
				array(
					'title'      => __( 'Layout', 'credence' ),
					'priority'   => 40,
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_setting( 'cred_site_width', array(
				'default'    => '1140',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_site_width',
					array(
						'label'       => __( 'Site Width', 'credence' ),
						'section'     => 'cred_layout_section',
						'settings'    => 'cred_site_width',
						'description' => __( 'Measurement is in pixel.', 'credence' ),
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 3000,
							'step' => 1
						)
					)
				)
			);

			$wp_customize->add_setting( 'cred_site_width', array(
				'default'    => '1140',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_site_width',
					array(
						'label'       => __( 'Site Width', 'credence' ),
						'section'     => 'cred_layout_section',
						'settings'    => 'cred_site_width',
						'description' => __( 'Measurement is in pixel.', 'credence' ),
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 3000,
							'step' => 1
						)
					)
				)
			);

			$wp_customize->add_setting( 'cred_content_width', array(
				'default'    => '67',
				'capability' => 'edit_theme_options',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'  => 'refresh'
			) );

			$wp_customize->add_control(
				new Cred_Range_Custom_Control(
					$wp_customize,
					'cred_content_width',
					array(
						'label'           => __( 'Content Width', 'credence' ),
						'section'         => 'cred_layout_section',
						'settings'        => 'cred_content_width',
						'description'     => __( 'Measurement is in ( % )', 'credence' ),
						'active_callback' => array( __CLASS__, 'is_no_sidebar_enabled' ),
						'input_attrs'     => array(
							'min'  => 20,
							'max'  => 80,
							'step' => 1
						)
					)
				)
			);

			$wp_customize->add_setting( 'cred_sidebar_position',
				array(
					'default'    => 'sidebar_right',
					'transport'  => 'refresh',
					'sanitize_callback' => 'sanitize_text_field',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_control( new Cred_Radio_Img_Control( $wp_customize, 'cred_sidebar_position',
				array(
					'label'   => __( 'Select Sidebar layout', 'credence' ),
					'section' => 'cred_layout_section',
					'choices' => array(
						'sidebar_left'  => array(
							'image'     => get_template_directory_uri() . '/assets/images/sidebar-left.svg',
							'name'      => __( 'Left Sidebar', 'credence' )
						),
						'sidebar_right' => array(
							'image'     => get_template_directory_uri() . '/assets/images/sidebar-right.svg',
							'name'      => __( 'Right Sidebar', 'credence' )
						),
						'sidebar_none' => array(
							'image'    => get_template_directory_uri() . '/assets/images/sidebar-none.svg',
							'name'     => __( 'Sidebar None', 'credence' )
						)
					)
				)
			) );

			/**
			 * Blog Options
			 */

			$wp_customize-> add_section(
				'cred_blog_section',
				array(
					'title'      => __( 'Blog', 'credence' ),
					'priority'   => 40,
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_setting(
				'cred_show_author_bio',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_show_author_bio',
				array(
					'type'     => 'checkbox',
					'section'  => 'cred_blog_section',
					'priority' => 10,
					'label'    => __( 'Enable Author Bio', 'credence' )
				)
			);

			$wp_customize->add_setting(
				'cred_enable_related_post',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_related_post',
				array(
					'label'    => __( 'Enable Related Post', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_blog_section'
				)
			);

			$wp_customize->add_setting(
				'cred_enable_breadcrumb',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_breadcrumb',
				array(
					'label'    => __( 'Enable Breadcrumb( Only for Singular )', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_blog_section'
				)
			);

			$wp_customize->add_setting(
				'cred_enable_category_at_blog',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_category_at_blog',
				array(
					'label'    => __( 'Enable Category( Only for Blog Page )', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_blog_section'
				)
			);

			$wp_customize->add_setting(
				'cred_enable_tag_at_blog',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_tag_at_blog',
				array(
					'label'    => __( 'Enable Tag( Only for Blog Page )', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_blog_section'
				)
			);

			/* Display full content or excerpts on the blog and archives --------- */
			$wp_customize->add_setting(
				'cred_blog_content',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'summary',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' )
				)
			);

			$wp_customize->add_control(
				'cred_blog_content',
				array(
					'type'     => 'radio',
					'section'  => 'cred_blog_section',
					'priority' => 10,
					'label'    => __( 'On archive pages, posts show:', 'credence' ),
					'choices'  => array(
						'full'    => __( 'Full text', 'credence' ),
						'summary' => __( 'Summary', 'credence' )
					)
				)
			);

			/**
			 * Colors section
			 */
			$wp_customize->add_panel( 'Cred_Customizer_colors_panel', array(
		        'priority'       => 45,
		        'capability'     => 'edit_theme_options',
		        'theme_supports' => '',
		        'title'          => __('Colors', 'credence')
		    ) );

			$wp_customize-> add_section(
				'cred_gemeral_color_section',
				array(
					'title'      => __( 'General', 'credence' ),
					'priority'   => 11,
					'panel'      => 'Cred_Customizer_colors_panel',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize-> add_section(
				'cred_header_color_section',
				array(
					'title'      => __( 'Header', 'credence' ),
					'priority'   => 12,
					'panel'      => 'Cred_Customizer_colors_panel',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize-> add_section(
				'cred_sidebar_color_section',
				array(
					'title'      => __( 'Sidebar', 'credence' ),
					'priority'   => 13,
					'panel'      => 'Cred_Customizer_colors_panel',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize-> add_section(
				'cred_footer_color_section',
				array(
					'title'      => __( 'Footer', 'credence' ),
					'priority'   => 14,
					'panel'      => 'Cred_Customizer_colors_panel',
					'capability' => 'edit_theme_options'
				)
			);

			/* body background color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_body_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#f3f3f3'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_body_background_color',
					array(
						'label'   => __( 'Background Color', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_content_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_content_background_color',
					array(
						'label'   => __( 'Content Background Color', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_paragraph_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#707070'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_paragraph_color',
					array(
						'label'   => __( 'Text Color', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_link_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#6871FF'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_link_color',
					array(
						'label'   => __( 'Link Color', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_link_hover_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#5d00ff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_link_hover_color',
					array(
						'label'   => __( 'Link Hover Color', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_heading_text_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#000000'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_heading_text_color',
					array(
						'label'   => __( 'Heading Color ( H1-H6 )', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_heading_hover_text_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#000000'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_heading_hover_text_color',
					array(
						'label'   => __( 'Heading Hover Color ( H1-H6 )', 'credence' ),
						'section' => 'cred_gemeral_color_section'
					)
				)
			);

			/* Header background color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_header_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_header_background_color',
					array(
						'label'   => __( 'Background Color', 'credence' ),
						'section' => 'cred_header_color_section'
					)
				)
			);

			/* Header Text color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_header_text_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#707070'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_header_text_color',
					array(
						'label'   => __( 'Text Color', 'credence' ),
						'section' => 'cred_header_color_section'
					)
				)
			);

			/* Header Submenu background color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_header_submenu_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#000000'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_header_submenu_background_color',
					array(
						'label'   => __( 'Submenu Beckground Color', 'credence' ),
						'section' => 'cred_header_color_section'
					)
				)
			);

			/* Header Submenu text color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_header_submenu_text_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_header_submenu_text_color',
					array(
						'label'   => __( 'Submenu Text Color', 'credence' ),
						'section' => 'cred_header_color_section'
					)
				)
			);

			/* Mobile Menu background color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_header_mobile_menu_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_header_mobile_menu_background_color',
					array(
						'label'   => __( 'Mobile Menu Beckground Color', 'credence' ),
						'section' => 'cred_header_color_section'
					)
				)
			);

			//sidebar Background Color
			$wp_customize->add_setting(
				'cred_sidebar_bg_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_sidebar_bg_color',
					array(
						'label'   => __( 'Background Color', 'credence' ),
						'section' => 'cred_sidebar_color_section'
					)
				)
			);

			//sidebar border Color
			$wp_customize->add_setting(
				'cred_sidebar_border_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#e1e1e1'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_sidebar_border_color',
					array(
						'label'   => __( 'Border Color', 'credence' ),
						'section' => 'cred_sidebar_color_section'
					)
				)
			);

			// Footer widget color heading
			$wp_customize->add_setting( 
				'cred_footer_widget_color_heading', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				) 
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_footer_widget_color_heading',
					array(
						'label'      => __( 'Footer Widget', 'credence' ),
						'section'    => 'cred_footer_color_section'
					)
				)
			);

			$wp_customize->add_setting(
				'cred_footer_widget_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_footer_widget_background_color',
					array(
						'label'   => __( 'Background Color', 'credence' ),
						'section' => 'cred_footer_color_section'
					)
				)
			);

			$wp_customize->add_setting( 
				'cred_footer_menu_and_copyright_color_heading', 
				array(
					'sanitize_callback' => 'sanitize_text_field'
				) 
			);

			$wp_customize->add_control( 
				new Cred_Heading_Custom_Control(
					$wp_customize, 'cred_footer_menu_and_copyright_color_heading',
					array(
						'label'      => __( 'Footer Menu & Copyright', 'credence' ),
						'section'    => 'cred_footer_color_section'
					)
				)
			);


			/* Footer background color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_footer_background_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#222222'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_footer_background_color',
					array(
						'label'   => __( 'Background Color', 'credence' ),
						'section' => 'cred_footer_color_section'
					)
				)
			);

			/* Footer text color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_footer_text_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_footer_text_color',
					array(
						'label'   => __( 'Text Color', 'credence' ),
						'section' => 'cred_footer_color_section'
					)
				)
			);

			/* Footer link color ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_footer_link_color',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_hex_color' ,
					'default'           => '#ffffff'
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cred_footer_link_color',
					array(
						'label'   => __( 'Link Color', 'credence' ),
						'section' => 'cred_footer_color_section'
					)
				)
			);

			/**
			 * Header section customize
			 */

			$wp_customize-> add_panel(
				'cred_header_panel',
				array(
					'title'      => __( 'Header', 'credence' ),
					'capability' => 'edit_theme_options',
					'priority'   => 40
				)
			);

			$wp_customize-> add_section(
				'cred_header_section',
				array(
					'panel'      => 'cred_header_panel',
					'title'      => __( 'Header Content', 'credence' ),
					'capability' => 'edit_theme_options'
				)
			);

			/* Enable Header Search ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_enable_header_search',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_header_search',
				array(
					'label'    => __( 'Show search in header', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_header_section'
				)
			);

			/* Enable Header sticky ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_enable_header_sticky',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_header_sticky',
				array(
					'label'    => __( 'Enable Sticky Header', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_header_section',
					'priority' => 10
				)
			);

			
			/* Enable Transparent Header ----------------------------------------------- */
			$wp_customize->add_setting(
				'cred_enable_transparent_header',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => false,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_transparent_header',
				array(
					'label'    => __( 'Enable Transparency', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_header_section',
					'priority' => 10
				)
			);

			/**
			 * Footer Panel customize
			 */
			$wp_customize-> add_panel(
				'cred_footer_panel',
				array(
					'title'      => __( 'Footer', 'credence' ),
					'capability' => 'edit_theme_options'
				)
			);

			/**
			 * footer widget section
			 */
			$wp_customize-> add_section(
				'cred_footer_widget_section',
				array(
					'panel'      => 'cred_footer_panel',
					'title'      => __( 'Footer Widget', 'credence' ),
					'capability' => 'edit_theme_options'
				)
			);

			/* Footer background color ----------------------------------------------- */

			$wp_customize->add_setting( 'cred_footer_layout',
				array(
					'default'    => 'footer_col_four',
					'transport'  => 'refresh',
					'sanitize_callback' => 'sanitize_text_field',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_control( new Cred_Radio_Img_Control( $wp_customize, 'cred_footer_layout',
				array(
					'label'   => __( 'Select Footer Widget layout', 'credence' ),
					'section' => 'cred_footer_widget_section',
					'choices' => array(
						'footer_widget_none' => array(
							'image'          => get_template_directory_uri() . '/assets/images/footer-widget-none.svg',
							'name'           => __( 'Footer Widget None', 'credence' )
						),
						'footer_col_one'     => array(
							'image'          => get_template_directory_uri() . '/assets/images/footer-col-1.svg',
							'name'           => __( 'Column One', 'credence' )
						),
						'footer_col_two'     => array(
							'image'          => get_template_directory_uri() . '/assets/images/footer-col-2.svg',
							'name'           => __( 'Column Two', 'credence' )
						),
						'footer_col_three'   => array(
							'image'          => get_template_directory_uri() . '/assets/images/footer-col-3.svg',
							'name'           => __( 'Column Three', 'credence' )
						),
						'footer_col_four'    => array(
							'image'          => get_template_directory_uri() . '/assets/images/footer-col-4.svg',
							'name'           => __( 'Column Four', 'credence' )
						)
					)
				)
			) );

			/**
			 * footer section
			 */
			$wp_customize-> add_section(
				'cred_footer_section',
				array(
					'panel'      => 'cred_footer_panel',
					'title'      => __( 'Footer Menu & Copyright', 'credence' ),
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_setting(
				'cred_enable_footer_menu',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' )
				)
			);

			$wp_customize->add_control(
				'cred_enable_footer_menu',
				array(
					'label'    => __( 'Enable Footer Menu?', 'credence' ),
					'type'     => 'checkbox',
					'section'  => 'cred_footer_section',
					'priority' => 10
				)
			);

			/* Footer Text ----------------------------------------------- */
			$wp_customize->add_setting( 'cred_footer_text', array(
				'capability'        => 'edit_theme_options',
				'default'           => __( 'Credence Powered by WordPress', 'credence' ),
				'sanitize_callback' => 'cred_sanitize_textarea'
			) );
			  
			$wp_customize->add_control( 'cred_footer_text', array(
				'label'       => __( 'Footer Text', 'credence' ),
				'type'        => 'textarea',
				'section'     => 'cred_footer_section', 
				'description' => __( 'This is footer textarea.', 'credence' )
			) );

			// Footer Copyright text alignment
			$wp_customize->add_setting( 
				'cred_footer_copy_align',
				array(
					'default'    => 'center',
					'transport'  => 'refresh',
					'sanitize_callback' => 'sanitize_text_field',
					'capability' => 'edit_theme_options'
				)
			);

			$wp_customize->add_control( 
				new Cred_Alignment_Custom_Control( 
					$wp_customize,
					'cred_footer_copy_align',
					array(
						'label'    => __( 'Text Alignment', 'credence' ),
						'section'  => 'cred_footer_section',
						'settings' => 'cred_footer_copy_align',
						'choices'  => array(
							'left'   => __( 'Left', 'credence' ),
							'center' => __( 'Center', 'credence' ),
							'right'  => __( 'Right', 'credence'  )
						)
					)
				)
			);
		}

		/**
		 * Sanitization callback for the "accent_accessible_colors" setting.
		 *
		 * @static
		 * @access public
		 * @since 1.0.0
		 * @param array $value The value we want to sanitize.
		 * @return array       Returns sanitized value. Each item in the array gets sanitized separately.
		 */
		public static function sanitize_accent_accessible_colors( $value ) {

			// Make sure the value is an array. Do not typecast, use empty array as fallback.
			$value = is_array( $value ) ? $value : array();

			// Loop values.
			foreach ( $value as $area => $values ) :
				foreach ( $values as $context => $color_val ) :
					$value[ $area ][ $context ] = sanitize_hex_color( $color_val );
				endforeach;
			endforeach;

			return $value;
		}

		/**
		 * Sanitize select.
		 *
		 * @param string $input The input from the setting.
		 * @param object $setting The selected setting.
		 *
		 * @return string $input|$setting->default The input from the setting or the default setting.
		 */
		public static function sanitize_select( $input, $setting ) {
			$input   = sanitize_key( $input );
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
		}

		/**
		 * google fonts.
		 */
		public static function get_google_font_family() {
			if ( get_transient( 'credence_google_font_list' ) ) :
				$content = get_transient('credence_google_font_list');
			else :
				$googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyDcAjGVgfOIeaMl5Ebppm2k65nmhKiXvu4';
				$fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
				$content = json_decode($fontContent['body'], true);
				set_transient( 'credence_google_font_list', $content, 0 );
			endif;
			
			$cred_system_fonts = array(
				'Arial', 'Arial Black', 'Courier', 'Courier New', 'Georgia', 'Helvetica', 'Times', 'Times New Roman', 'Trebuchet MS', 'Verdana'
			);

			$family[] = array();
			foreach( $content['items'] as $fonts ) {
				$family[] = $fonts['family'];
			}

			$all_fonts[] = array();
			$all_fonts = array_merge( $family, $cred_system_fonts );
		
			return $all_fonts;
		}

		/**
		 * Sanitize Fonts.
		 *
		 * @param string $input The input from the setting.
		 * @param object $setting The selected setting.
		 *
		 * @return string $input|$setting->default The input from the setting or the default setting.
		 */
		public static function sanitize_fonts( $input, $setting ) {
			$value = sanitize_text_field( $input );
			$choices = Cred_Customize::get_google_font_family();
		
			// If the input is a valid key, return it; otherwise, return the default.
			return ( in_array( $value, $choices ) ? $value : $setting->default );
		}

		/**
		 * Sanitize boolean for checkbox.
		 *
		 * @param bool $checked Whether or not a box is checked.
		 *
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

		/**
		 * Sanitize number.
		 **/
		public static function sanitize_number( $number, $setting ) {
			// Ensure $number is an absolute integer (whole number, zero or greater).
			$number = ( $number );
		  
			// If the input is an absolute integer, return it; otherwise, return the default
			return ( $number ? $number : $setting->default );
		}

		/**
		 *
		 * @param bool $checked Whether sidebar option is enable or disable.
		 *
		 * @return bool
		 */
		public static function is_no_sidebar_enabled(){
		    $blueplanet_options = get_theme_mod( 'cred_sidebar_position');
		    if( 'sidebar_none' === $blueplanet_options ) {
		        return false;
		    }
		    return true;
		}
		/**
		 * Sanitize date.
		 **/
		function sanitize_date( $input ) {
			$date = new DateTime( $input );
			return $date->format('m-d-Y');
		}

		/**
		 * Sanitize URL.
		 **/
		function sanitize_url( $url ) {
			return esc_url_raw( $url );
		}

		/**
		 * Radio Button and Select sanitization
		 *
		 * @param  string		Radio Button value
		 * @return integer	Sanitized value
		 */
		function sanitize_radio_image( $input, $setting ) {
			//get the list of possible radio box or select options
			$choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) :
				return $input;
			else :
				return $setting->default;
			endif;
		}

		/**
		 * Radio icon and Select sanitization
		 *
		 * @param  string		Radio Button value
		 * @return integer	Sanitized value
		 */
		function sanitize_radio_icon( $input, $setting ) {
			//get the list of possible radio box or select options
			$choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) :
				return $input;
			else :
				return $setting->default;
			endif;
		}

		/**
		 * Sanitize range type
		 *
		 * @param bool $checked Whether or not a box is checked.
		 *
		 * @return bool
		 */
		function sanitize_range( $value ) {
			return (int) $value;
		}

		public static function cred_sanitize_textarea_field( $str ) {
			$filtered = sanitize_text_fields( $str, true );
		 
			/**
			 * Filters a sanitized textarea field string.
			 *
			 * @since 4.7.0
			 *
			 * @param string $filtered The sanitized string.
			 * @param string $str      The string prior to being sanitized.
			 */
			return apply_filters( 'cred_sanitize_textarea_field', $filtered, $str );
		}

	}

	// Setup the Theme Customizer settings and controls.
	add_action( 'customize_register', array( 'Cred_Customize', 'register' ) );

endif;

/**
 * PARTIAL REFRESH FUNCTIONS
 * */
if ( ! function_exists( 'cred_customize_partial_blogname' ) ) :
	/**
	 * Render the site title for the selective refresh partial.
	 */
	function cred_customize_partial_blogname() {
		bloginfo( 'name' );
	}
endif;

if ( ! function_exists( 'cred_customize_partial_blogdescription' ) ) :
	/**
	 * Render the site description for the selective refresh partial.
	 */
	function cred_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
endif;

if ( ! function_exists( 'cred_customize_partial_site_logo' ) ) :
	/**
	 * Render the site logo for the selective refresh partial.
	 *
	 * Doing it this way so we don't have issues with `render_callback`'s arguments.
	 */
	function cred_customize_partial_site_logo() {
		cred_site_logo();
	}
endif;

/**
 * Santize Textarea Field.
 */
function cred_sanitize_textarea( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}