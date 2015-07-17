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

if ( !class_exists( 'YWCES_Coupon_Mail' ) ) {

    /**
     * Implements Coupon Mail for YWCES plugin
     *
     * @class   YWCES_Coupon_Mail
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     * @extends WC_Email
     *
     */
    class YWCES_Coupon_Mail extends WC_Email {

        /**
         * @var int $mail_body content of the email
         */
        var $mail_body;

        /**
         * @var int $template the template of the email
         */
        var $template_type;

        /**
         * Constructor
         *
         * Initialize email type and set templates paths
         *
         * @since   1.0.0
         * @author  Alberto Ruggiero
         */
        public function __construct() {

            $this->title          = __( 'Coupon Mail System', 'ywces' );
            $this->template_html  = '/emails/coupon-email.php';
            $this->template_plain = '/emails/plain/coupon-email.php';

            parent::__construct();

        }

        /**
         * Trigger email send
         *
         * @since   1.0.0
         *
         * @param   $mail_body
         * @param   $mail_subject
         * @param   $mail_address
         * @param   $template
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function trigger( $mail_body, $mail_subject, $mail_address, $template = false ) {

            $this->email_type = get_option( 'ywces_mail_type' );
            $this->heading    = $mail_subject;
            $this->subject    = $mail_subject;
            $this->mail_body  = $mail_body;
            $this->template_type   = $template;
            $this->recipient  = $mail_address;

            if ( !$this->get_recipient() ) {
                return;
            }

            $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), "" );

        }

        /**
         * Send the email.
         *
         * @since   1.0.0
         *
         * @param   string $to
         * @param   string $subject
         * @param   string $message
         * @param   string $headers
         * @param   string $attachments
         *
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function send( $to, $subject, $message, $headers, $attachments ) {

            add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
            add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
            add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

            $message = apply_filters( 'woocommerce_mail_content', $this->style_inline( $message ) );

            if ( defined( 'YWCES_PREMIUM' ) && get_option( 'ywces_mandrill_enable' ) == 'yes' ) {

                $return = YWCES_Mandrill()->send_email( $to, $subject, $message, $headers, $attachments );

            }
            else {

                $return = wp_mail( $to, $subject, $message, $headers, $attachments );

            }

            remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
            remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
            remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );

            return $return;

        }

        /**
         * Get HTML content
         *
         * @since   1.0.0
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function get_content_html() {

            ob_start();

            wc_get_template( $this->template_html, array(
                'email_heading' => $this->get_heading(),
                'mail_body'     => $this->mail_body,
                'template'      => $this->template_type,
                'sent_to_admin' => false,
                'plain_text'    => false
            ), YWCES_TEMPLATE_PATH, YWCES_TEMPLATE_PATH );

            return ob_get_clean();

        }

        /**
         * Get Plain content
         *
         * @since   1.0.0
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function get_content_plain() {

            ob_start();

            wc_get_template( $this->template_plain, array(
                'email_heading' => $this->get_heading(),
                'mail_body'     => $this->mail_body,
                'sent_to_admin' => false,
                'plain_text'    => true
            ), YWCES_TEMPLATE_PATH, YWCES_TEMPLATE_PATH );

            return ob_get_clean();

        }

        /**
         * Admin Panel Options Processing - Saves the options to the DB
         *
         * @since   1.0.0
         * @return  boolean|null
         * @author  Alberto Ruggiero
         */
        public function process_admin_options() {

            woocommerce_update_options( $this->form_fields['general'] );

        }

        /**
         * Setup email settings screen.
         *
         * @since   1.0.0
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function admin_options() {

            ?>
            <table class="form-table">
                <?php woocommerce_admin_fields( $this->form_fields['general'] ); ?>
            </table>
        <?php

        }

        /**
         * Initialise Settings Form Fields
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function init_form_fields() {

            $this->form_fields = include( YWCES_DIR . '/plugin-options/general-options.php' );

        }

    }

}

return new YWCES_Coupon_Mail();