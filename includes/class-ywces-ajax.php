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
    exit; // Exit if accessed directly
}

if ( !class_exists( 'YWCES_Ajax' ) ) {

    /**
     * Implements AJAX for YWCES plugin
     *
     * @class   YWCES_Ajax
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     *
     */
    class YWCES_Ajax {

        /**
         * Single instance of the class
         *
         * @var \YWCES_Ajax
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YWCES_Ajax
         * @since 1.0.0
         */
        public static function get_instance() {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self( $_REQUEST );

            }

            return self::$instance;
        }

        /**
         * Constructor
         *
         * @since   1.0.0
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function __construct() {

            add_action( 'wp_ajax_ywces_send_test_mail', array( $this, 'send_test_mail' ) );

        }

        /**
         * Send a test mail from option panel
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function send_test_mail() {

            ob_start();

            try {

                global $current_user;
                get_currentuserinfo();

                $products = explode( ',', $_POST['products'] );

                $args = array(
                    'order_date' => current_time( 'Y-m-d' ),
                    'threshold'  => $_POST['threshold'],
                    'expense'    => $_POST['threshold'] + 1,
                    'product'    => array_shift( $products ),
                    'days_ago'   => $_POST['days_elapsed']
                );

                switch ( $_POST['type'] ) {

                    case 'product_purchasing':
                    case 'birthday':
                    case 'last_purchase':

                        $coupon_code = YITH_WCES()->create_coupon( $current_user->ID, $_POST['type'], $_POST['coupon_info'] );

                        break;

                    default:

                        $coupon_code = $_POST['coupon'];

                }

                if ( YITH_WCES()->check_if_coupon_exists( $coupon_code ) ) {

                    YWCES_Emails()->prepare_coupon_mail( $current_user->ID, $_POST['type'], $coupon_code, $args, $_POST['email'], $_POST['template'] );

                    wp_send_json( true );

                }
                else {

                    wp_send_json( array( 'error' => __( 'Coupon not valid', 'ywces' ) ) );

                }

            } catch ( Exception $e ) {

                wp_send_json( array( 'error' => $e->getMessage() ) );

            }


        }

    }

    /**
     * Unique access to instance of YWCES_Ajax class
     *
     * @return \YWCES_Ajax
     */
    function YWCES_Ajax() {

        return YWCES_Ajax::get_instance();

    }

}