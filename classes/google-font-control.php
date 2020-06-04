<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

	if ( ! class_exists( 'Cred_Google_Font_Dropdown_Custom_Control' ) ) :

		class Cred_Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {

            private $fonts = false;
            private $cred_system_fonts = [];

            public function __construct( $manager, $id, $args = array(), $options = array() ) {
                $this->fonts = $this->get_google_fonts();
                parent::__construct( $manager, $id, $args );
            }
        
            public function render_content() {
                $system_fonts = $this->get_system_fonts();
                ?>
                    <label class="customize_dropdown_input">
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                        <select id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" data-customize-setting-link="<?php echo esc_attr($this->id); ?>">
                            <optgroup label="Other System Fonts">
                            <?php

                                foreach ( $system_fonts as $name => $variants ) :
                                    ?>

                                    <option value="<?php echo esc_attr( $name ); ?>" ><?php echo esc_html( $name ); ?></option>
                                    <?php
                                endforeach;
                            ?>

                            <optgroup label="Google">
                            <?php
                                foreach ( $this->fonts as $k => $v ) :
                                    echo '<option value="'.esc_attr( $v['family'] ).'" ' . selected( $this->value(), $v['family'], false ) . '>'.esc_html( $v['family'] ).'</option>';
                                endforeach;
                            ?>
                        </select>
                    </label>
                <?php
            }
        
            public function get_google_fonts() {
                if ( get_transient( 'mytheme_google_font_list' ) ) :
                    $content = get_transient('mytheme_google_font_list');
                else :
                    $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyDcAjGVgfOIeaMl5Ebppm2k65nmhKiXvu4';
                    $fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );
                    $content = json_decode($fontContent['body'], true);
                    set_transient( 'mytheme_google_font_list', $content, 0 );
                endif;

                return $content['items'];
            }

            /**
             * Get System Fonts
             *
             * @return Array All the system fonts in Credence
             */
            public function get_system_fonts() {
                if ( empty( $this->cred_system_fonts ) ) {
                    $this->cred_system_fonts = array(
                        'Arial'           => array(
                            'fallback'    => 'Helvetica, Verdana, sans-serif'
                        ),
                        'Arial Black'     => array(
                            'fallback'    => 'Arial Black'
                        ),
                        'Courier'         => array(
                            'fallback'    => 'monospace'
                        ),
                        'Courier New'     => array(
                            'fallback'    => 'Courier New'
                        ),
                        'Georgia'         => array(
                            'fallback'    => 'Times, serif'
                        ),
                        'Helvetica'       => array(
                            'fallback'    => 'Verdana, Arial, sans-serif'
                        ),
                        'Times'           => array(
                            'fallback'    => 'Georgia, serif'
                        ),
                        'Times New Roman' => array(
                            'fallback'    => 'Times New Roman'
                        ),
                        'Trebuchet MS'    => array(
                            'fallback'    => 'Trebuchet MS'
                        ),
                        'Verdana'         => array(
                            'fallback'    => 'Helvetica, Arial, sans-serif'
                        )
                    );
                }

                return apply_filters( 'cred_system_fonts', $this->cred_system_fonts );
            }
        }
	endif;
endif;
