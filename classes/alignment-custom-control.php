<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

	if ( ! class_exists( 'Cred_Alignment_Custom_Control' ) ) :
        class Cred_Alignment_Custom_Control extends WP_Customize_Control {
            /**
             * The type of control being rendered
             */
            public $type = 'text_radio_button';
            /**
             * Enqueue our scripts and styles
             */
            public function enqueue() {
                wp_enqueue_style( 'alignment-control-css', get_template_directory_uri() . '/assets/css/alignment-custom-control.min.css' );
            }
            /**
             * Render the control in the customizer
             */
            public function render_content() {
            ?>
                <div class="text_radio_button_control">
                    <?php if( !empty( $this->label ) ) : ?>
                        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <?php endif; ?>
                    <?php if( !empty( $this->description ) ) : ?>
                        <span class="customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
                    <?php endif; ?>

                    <div class="icon-buttons">
                        <?php foreach ( $this->choices as $key => $value ) : ?>
                            <label class="icon-buttons-label">
                                <input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
                                <span class="dashicons dashicons-editor-align<?php echo esc_attr( $key ); ?>"></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
            }
        }
    endif;
endif;