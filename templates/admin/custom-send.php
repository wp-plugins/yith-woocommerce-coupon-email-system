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
 * Outputs a custom text template for send test email in plugin options panel
 *
 * @class   YWCES_Custom_Send
 * @package Yithemes
 * @since   1.0.0
 * @author  Your Inspiration Themes
 *
 */
class YWCES_Custom_Send {

    /**
     * Outputs a custom text template for send test email in plugin options panel
     *
     * @since   1.0.0
     *
     * @param   $option
     *
     * @return  void
     * @author  Alberto Ruggiero
     */
    public static function output( $option ) {

        $custom_attributes = array();

        if ( !empty( $option['custom_attributes'] ) && is_array( $option['custom_attributes'] ) ) {
            foreach ( $option['custom_attributes'] as $attribute => $attribute_value ) {
                $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
            }
        }

        ?>
        <tr valign="top">
            <th scope="row" class="titledesc">
                <label for="<?php echo esc_attr( $option['field_id'] ); ?>"><?php echo esc_html( $option['title'] ); ?></label>
            </th>
            <td class="forminp forminp-custom-send">
                <input
                    name="<?php echo esc_attr( $option['field_id'] ); ?>"
                    id="<?php echo esc_attr( $option['field_id'] ); ?>"
                    type="text"
                    class="ywces-test-email"
                    placeholder="<?php _e( 'Type an email address to send a test email', 'ywces' ) ?>"
                    />

                <button type="button" class="button-secondary ywces-send-test-email" <?php echo implode( ' ', $custom_attributes ); ?>><?php _e( 'Send Test Email', 'ywces' ); ?></button>
                <?php echo $option['desc']; ?>
            </td>
        </tr>
    <?php
    }

}