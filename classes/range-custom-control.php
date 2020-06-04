<?php
/**
 * Customizer Separator Control settings for this theme.
 *
 * @package Credence
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

	if ( ! class_exists( 'Cred_Range_Custom_Control' ) ) :
		class Cred_Range_Custom_Control extends WP_Customize_Control {

            public $type = 'custom_range';

            public function enqueue(){
                wp_enqueue_script( 'range-control-js', get_template_directory_uri() . '/assets/js/range-control.min.js', array('jquery'), false, true );
                wp_enqueue_style( 'range-control-css', get_template_directory_uri() . '/assets/css/range-control.min.css' );
            }

            public function render_content(){
                ?>
                <label>
                    <?php if ( ! empty( $this->label ) ) : ?>
                        <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <?php endif; ?>
                    <div class="range-wrapper">
                        <input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="range-value" <?php $this->link(); ?> />
                        <input class="range-input-field" data-input-type="range" type="range" <?php $this->input_attrs(); ?> value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
                    </div>
                    <?php if ( ! empty( $this->description ) ) : ?>
                        <span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
                    <?php endif; ?>
                </label>
                <?php
            }
        }
	endif;
endif;