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

if ( !class_exists( 'YWCES_Emails' ) ) {

    /**
     * Implements email functions for YWCES plugin
     *
     * @class   YWCES_Emails
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     *
     */
    class YWCES_Emails {

        /**
         * Single instance of the class
         *
         * @var \YWCES_Emails
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YWCES_Emails
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

        }

        /**
         * Send the coupon mail
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
        public function send_email( $mail_body, $mail_subject, $mail_address, $template = false ) {

            $wc_email = WC_Emails::instance();
            $email    = $wc_email->emails['YWCES_Coupon_Mail'];

            $email->trigger( $mail_body, $mail_subject, $mail_address, $template );

        }

        /**
         * Set the mail for user registration
         *
         * @since   1.0.0
         *
         * @param   $user_id
         * @param   $type
         * @param   $coupon_code
         * @param   $args
         * @param   $test_email
         * @param   $template
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function prepare_coupon_mail( $user_id, $type, $coupon_code, $args = array(), $test_email = false, $template = false ) {

            $first_name = get_user_meta( $user_id, 'billing_first_name', true );

            if ( $first_name == '' ) {
                $first_name = get_user_meta( $user_id, 'nickname', true );
            }

            $last_name = get_user_meta( $user_id, 'billing_last_name', true );

            if ( $last_name == '' ) {
                $last_name = get_user_meta( $user_id, 'nickname', true );
            }

            if ( !$test_email ) {

                $user_email = get_user_meta( $user_id, 'billing_email', true );

                if ( $user_email == '' ) {
                    $user_info  = get_userdata( $user_id );
                    $user_email = $user_info->user_email;
                }

            }
            else {

                $user_email = $test_email;

            }

            $mail_body    = $this->get_mail_body( $type, $coupon_code, $first_name, $last_name, $user_email, $args, $template );
            $mail_subject = $this->get_subject( $type, $first_name, $last_name );

            $this->send_email( $mail_body, $mail_subject, $user_email, $template );

        }

        /**
         * Set the mail body
         *
         * @since   1.0.0
         *
         * @param   $type
         * @param   $coupon_code
         * @param   $first_name
         * @param   $last_name
         * @param   $user_email
         * @param   $args
         * @param   $template
         *
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function get_mail_body( $type, $coupon_code, $first_name, $last_name, $user_email, $args = array(), $template = false ) {

            if ( !$template ) {
                $template = get_option( 'ywces_mail_template', 'base' );
            }

            if ( array_key_exists( $template, YITH_WCES()->_email_templates ) ) {

                $path   = YITH_WCES()->_email_templates[$template]['path'];
                $folder = YITH_WCES()->_email_templates[$template]['folder'];

                $styles = include( $path . $folder . '/coupon-description.php' );

            }
            elseif ( defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywces_mail_template_enable' ) == 'yes' ) {

                $styles = array('h2'   => '',
                                'i'    => '',
                                'a'    => '',
                                'span' => '');

            }
            else {

                $styles = include( YWCES_TEMPLATE_PATH . '/emails/coupon-description.php' );

            }

            $mail_body = get_option( 'ywces_mailbody_' . $type );
            $coupon    = $this->get_coupon_info( $coupon_code, $styles );
            $find      = array(
                '{coupon_description}',
                '{site_title}',
                '{customer_name}',
                '{customer_last_name}',
                '{customer_email}',
            );

            $replace = array(
                $coupon,
                get_option( 'blogname' ),
                $first_name,
                $last_name,
                $user_email,
            );

            switch ( $type ) {
                case 'first_purchase':
                    $find[]    = '{order_date}';
                    $replace[] = $args['order_date'];
                    break;

                case 'purchases':
                    $find[]    = '{order_date}';
                    $find[]    = '{purchases_threshold}';
                    $replace[] = $args['order_date'];
                    $replace[] = $args['threshold'];
                    break;

                case 'spending':
                    $find[]    = '{order_date}';
                    $find[]    = '{spending_threshold}';
                    $find[]    = '{customer_money_spent}';
                    $replace[] = $args['order_date'];
                    $replace[] = wc_price( $args['threshold'] );
                    $replace[] = wc_price( $args['expense'] );
                    break;

                case 'product_purchasing':
                    $find[]    = '{order_date}';
                    $find[]    = '{purchased_product}';
                    $replace[] = $args['order_date'];
                    $replace[] = $this->render_mailbody_link( wc_get_product( $args['product'] ), 'product', $styles['a'] );
                    break;

                case 'last_purchase':
                    $find[]    = '{days_ago}';
                    $replace[] = $args['days_ago'];
                    break;

                default:

            }

            $mail_body = str_replace( $find, $replace, nl2br( $mail_body ) );

            return $mail_body;

        }

        /**
         * Set the subject and mail heading
         *
         * @since   1.0.0
         *
         * @param   $type
         * @param   $first_name
         * @param   $last_name
         *
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function get_subject( $type, $first_name, $last_name ) {

            $subject = get_option( 'ywces_subject_' . $type );

            $find = array(
                '{site_title}',
                '{customer_name}',
                '{customer_last_name}',
            );

            $replace = array(
                get_option( 'blogname' ),
                $first_name,
                $last_name,
            );

            $subject = str_replace( $find, $replace, $subject );

            return $subject;
        }

        /**
         * Get coupon info
         *
         * @since   1.0.0
         *
         * @param   $coupon_code
         * @param   $styles
         *
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function get_coupon_info( $coupon_code, $styles ) {

            $result = '';
            $coupon = new WC_Coupon( $coupon_code );

            if ( $coupon->id ) {
                if ( $post = get_post( $coupon->id ) ) {

                    $amount_suffix = get_woocommerce_currency_symbol();

                    if ( function_exists( 'wc_price' ) ) {

                        $amount_suffix = null;

                    }

                    if ( $coupon->type = 'percent' || $coupon->type = 'percent_product' ) {

                        $amount_suffix = '%';

                    }

                    $amount = $coupon->amount;
                    if ( $amount_suffix === null ) {
                        $amount        = wc_price( $amount );
                        $amount_suffix = '';
                    }

                    $products            = array();
                    $products_excluded   = array();
                    $categories          = array();
                    $categories_excluded = array();

                    if ( count( $coupon->product_ids ) > 0 ) {
                        foreach ( $coupon->product_ids as $product_id ) {
                            $product = wc_get_product( $product_id );
                            if ( $product ) {
                                $products[] = $this->render_mailbody_link( $product, 'product', $styles['a'] );
                            }
                        }
                    }

                    if ( count( $coupon->exclude_product_ids ) > 0 ) {
                        foreach ( $coupon->exclude_product_ids as $product_id ) {
                            $product = wc_get_product( $product_id );
                            if ( $product ) {
                                $products_excluded[] = $this->render_mailbody_link( $product, 'product', $styles['a'] );
                            }
                        }
                    }

                    if ( count( $coupon->product_categories ) > 0 ) {
                        foreach ( $coupon->product_categories as $term_id ) {
                            if ( $term = get_term_by( 'id', $term_id, 'product_cat' ) ) {
                                $categories[] = $this->render_mailbody_link( $term, 'category', $styles['a'] );
                            }
                        }
                    }

                    if ( count( $coupon->exclude_product_categories ) > 0 ) {
                        foreach ( $coupon->exclude_product_categories as $term_id ) {
                            if ( $term = get_term_by( 'id', $term_id, 'product_cat' ) ) {
                                $categories_excluded[] = $this->render_mailbody_link( $term, 'category', $styles['a'] );
                            }
                        }
                    }

                    ob_start();
                    ?>

                    <h2 style="<?php echo $styles['h2'] ?>" class="ywces-h2">
                        <?php echo __( 'Coupon code: ', 'yith-woocommerce-coupon-email-system' ) . $coupon->code; ?>
                    </h2>

                    <?php if ( !empty( $post->post_excerpt ) ) : ?>

                        <i style="<?php echo $styles['i'] ?>" class="ywces-i">
                            <?php echo $post->post_excerpt; ?>
                        </i>

                    <?php endif; ?>

                    <p>
                        <b>
                            <?php printf( __( 'Coupon amount: %s%s off', 'yith-woocommerce-coupon-email-system' ), $amount, $amount_suffix ); ?>
                            <?php if ( $coupon->free_shipping == 'yes' ) : ?>
                                + <?php _e( 'Free shipping', 'yith-woocommerce-coupon-email-system' ); ?>
                                <br />
                            <?php endif; ?>
                        </b>
                        <span style="<?php echo $styles['span'] ?>" class="ywces-span">
                            <?php if ( $coupon->minimum_amount != '' && $coupon->maximum_amount == '' ) : ?>
                                <?php printf( __( 'Valid for a minimum purchase of %s', 'yith-woocommerce-coupon-email-system' ), wc_price( $coupon->minimum_amount ) ); ?>
                            <?php endif; ?>
                            <?php if ( $coupon->minimum_amount == '' && $coupon->maximum_amount != '' ) : ?>
                                <?php printf( __( 'Valid for a maximum purchase of %s', 'yith-woocommerce-coupon-email-system' ), wc_price( $coupon->maximum_amount ) ); ?>
                            <?php endif; ?>
                            <?php if ( $coupon->minimum_amount != '' && $coupon->maximum_amount != '' ) : ?>
                                <?php printf( __( 'Valid for a minimum purchase of %s and a maximum of %s', 'yith-woocommerce-coupon-email-system' ), wc_price( $coupon->minimum_amount ), wc_price( $coupon->maximum_amount ) ); ?>
                            <?php endif; ?>
                        </span>
                    </p>

                    <?php if ( count( $products ) > 0 || count( $categories ) > 0 ) : ?>
                        <p>
                            <b><?php echo __( 'Valid for:' ); ?></b>
                            <br />
                            <?php if ( count( $products ) > 0 ) : ?>
                                <?php printf( __( 'Following products: %s', 'yith-woocommerce-coupon-email-system' ), implode( ',', $products ) ); ?>
                                <br />
                            <?php endif; ?>

                            <?php if ( count( $categories ) > 0 ) : ?>
                                <?php printf( __( 'Products of the following categories: %s', 'yith-woocommerce-coupon-email-system' ), implode( ',', $categories ) ); ?>
                                <br />
                            <?php endif; ?>

                        </p>
                    <?php endif; ?>

                    <?php if ( count( $products_excluded ) > 0 || count( $categories_excluded ) > 0 ) : ?>
                        <p>
                            <b><?php echo __( 'Not valid for:' ); ?></b>
                            <br />
                            <?php if ( count( $products_excluded ) > 0 ): ?>
                                <?php printf( __( 'Following products: %s', 'yith-woocommerce-coupon-email-system' ), implode( ',', $products_excluded ) ) ?>
                                <br />
                            <?php endif; ?>

                            <?php if ( count( $categories_excluded ) > 0 ): ?>
                                <?php printf( __( 'Products of the following categories: %s', 'yith-woocommerce-coupon-email-system' ), implode( ',', $categories_excluded ) ) ?>
                                <br />
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <span style="<?php echo $styles['span'] ?>" class="ywces-span">
                        <?php if ( $coupon->individual_use == 'yes' ) : ?>
                            &bull; <?php _e( 'This coupon cannot be used in conjunction with other coupons', 'yith-woocommerce-coupon-email-system' ); ?>
                            <br />
                        <?php endif; ?>
                        <?php if ( $coupon->exclude_sale_items == 'yes' ) : ?>
                            &bull; <?php _e( 'This coupon will not apply to items on sale', 'yith-woocommerce-coupon-email-system' ); ?>
                            <br />
                        <?php endif; ?>
                    </span>

                    <?php if ( $coupon->expiry_date != '' ) : ?>
                        <p>
                            <br />
                            <b>
                                <?php printf( __( 'Expiration date: %s', 'yith-woocommerce-coupon-email-system' ), get_date_from_gmt( date( 'Y-m-d H:i:s', $coupon->expiry_date ), get_option( 'date_format' ) ) ); ?>
                            </b>
                        </p>
                    <?php endif; ?>

                    <?php

                    $result = ob_get_clean();

                }

            }

            return $result;

        }

        /**
         * Renders links for products or categories
         *
         * @since   1.0.0
         *
         * @param   $object
         * @param   $type
         * @param   $style
         *
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function render_mailbody_link( $object, $type, $style ) {
            if ( $type == 'product' ) {

                $url   = esc_url( get_permalink( $object->id ) );
                $title = $object->get_title();

            }
            else {

                $url   = get_term_link( $object->slug, 'product_cat' );
                $title = esc_html( $object->name );

            }

            return sprintf( '<a class="ywces-a" style="' . $style . '" href="%s">%s</a>', $url, $title );
        }

    }

    /**
     * Unique access to instance of YWCES_Emails class
     *
     * @return \YWCES_Emails
     */
    function YWCES_Emails() {
        return YWCES_Emails::get_instance();
    }

}