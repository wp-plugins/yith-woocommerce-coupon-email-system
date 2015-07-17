<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Outputs a custom textarea template in plugin options panel
 *
 * @class   YWCES_Custom_Textarea
 * @package Yithemes
 * @since   1.0.0
 * @author  Your Inspiration Themes
 *
 */
class YWCES_Custom_Textarea {

    /**
     * Outputs a custom textarea template in plugin options panel
     *
     * @since   1.0.0
     * @author  Alberto Ruggiero
     * @return  void
     */
    public static function output( $option ) {

        $custom_attributes = array();

        if ( !empty( $option['custom_attributes'] ) && is_array( $option['custom_attributes'] ) ) {
            foreach ( $option['custom_attributes'] as $attribute => $attribute_value ) {
                $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
            }
        }

        $option_value = WC_Admin_Settings::get_option( $option['id'], $option['default'] );

        ?>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="<?php echo esc_attr( $option['id'] ); ?>"><?php echo esc_html( $option['title'] ); ?></label>
            </th>
            <td class="forminp forminp-<?php echo sanitize_title( $option['type'] ) ?>">

                <textarea
                    name="<?php echo esc_attr( $option['id'] ); ?>"
                    id="<?php echo esc_attr( $option['id'] ); ?>"
                    style="<?php echo esc_attr( $option['css'] ); ?>"
                    class="<?php echo esc_attr( $option['class'] ); ?>"
                    <?php echo implode( ' ', $custom_attributes ); ?>
                    ><?php echo esc_textarea( $option_value ); ?></textarea>
                <span class="description"><?php echo $option['desc']; ?></span>
            </td>
        </tr>
    <?php
    }

}