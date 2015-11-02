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

$query_args            = array(
    'page' => isset( $_GET['page'] ) ? $_GET['page'] : '',
    'tab'  => 'howto',
);
$howto_url             = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );
$placeholders_text     = __( 'Allowed placeholders:', 'yith-woocommerce-coupon-email-system' );
$ph_reference_link     = ' - <a href="' . $howto_url . '" target="_blank">' . __( 'More info', 'yith-woocommerce-coupon-email-system' ) . '</a>';
$ph_site_title         = ' <b>{site_title}</b>';
$ph_customer_name      = ' <b>{customer_name}</b>';
$ph_customer_last_name = ' <b>{customer_last_name}</b >';
$ph_customer_email     = ' <b>{customer_email}</b>';
$ph_coupon_description = ' <b>{coupon_description}</b>';
$ph_order_date         = ' <b>{order_date}</b>';

$coupons = array_merge( array( '' => __( 'Select a coupon', 'yith-woocommerce-coupon-email-system' ) ), YITH_WCES()->_available_coupons );

$disabled = ( count( YITH_WCES()->_available_coupons ) > 0 ? array() : array( 'disabled' => 'disabled' ) );

return array(
    'general' => array(
        'ywces_main_section_title'           => array(
            'name' => __( 'Coupon Email System settings', 'yith-woocommerce-coupon-email-system' ),
            'type' => 'title',
            'desc' => '',
            //'id'   => 'ywces_main_section_title',
        ),
        'ywces_enable_plugin'                => array(
            'name'    => __( 'Enable YITH WooCommerce Coupon Email System', 'yith-woocommerce-coupon-email-system' ),
            'type'    => 'checkbox',
            'desc'    => '',
            'id'      => 'ywces_enable_plugin',
            'default' => 'yes',
        ),
        'ywces_mail_type'                    => array(
            'name'    => __( 'Email type', 'yith-woocommerce-coupon-email-system' ),
            'type'    => 'select',
            'desc'    => __( 'Choose which email format to send.', 'yith-woocommerce-coupon-email-system' ),
            'options' => array(
                'html'  => __( 'HTML', 'yith-woocommerce-coupon-email-system' ),
                'plain' => __( 'Plain text', 'yith-woocommerce-coupon-email-system' )
            ),
            'default' => 'html',
            'id'      => 'ywces_mail_type'
        ),
        'ywces_main_section_end'             => array(
            'type' => 'sectionend',
            //'id'   => 'ywces_main_section_end'
        ),

        'ywces_section_title_first_purchase' => array(
            'name' => __( 'On first purchase', 'yith-woocommerce-coupon-email-system' ),
            'type' => 'title',
            'desc' => '',
            //'id'   => 'ywces_section_title_first_purchase',
        ),
        'ywces_collapse_first_purchase'      => array(
            'type' => 'ywces-collapse'
        ),
        'ywces_enable_first_purchase'        => array(
            'name'              => __( 'Enable coupon sending', 'yith-woocommerce-coupon-email-system' ),
            'type'              => 'checkbox',
            'desc'              => '',
            'id'                => 'ywces_enable_first_purchase',
            'default'           => 'no',
            'custom_attributes' => $disabled
        ),
        'ywces_coupon_first_purchase'        => array(
            'name'    => __( 'Selected Coupon', 'yith-woocommerce-coupon-email-system' ),
            'type'    => 'select',
            'desc'    => __( 'Choose the coupon to send', 'yith-woocommerce-coupon-email-system' ),
            'options' => $coupons,
            'default' => '',
            'id'      => 'ywces_coupon_first_purchase',
        ),
        'ywces_subject_first_purchase'       => array(
            'name'              => __( 'Email subject', 'yith-woocommerce-coupon-email-system' ),
            'type'              => 'text',
            'desc'              => $placeholders_text . $ph_site_title . $ph_customer_name . $ph_customer_last_name . $ph_reference_link,
            'id'                => 'ywces_subject_first_purchase',
            'default'           => __( 'You have received a coupon from {site_title}', 'yith-woocommerce-coupon-email-system' ),
            'class'             => 'ywces-text',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'ywces_mailbody_first_purchase'      => array(
            'name'              => __( 'Email content', 'yith-woocommerce-coupon-email-system' ),
            'type'              => 'ywces-textarea',
            'desc'              => $placeholders_text . $ph_site_title . $ph_customer_name . $ph_customer_last_name . $ph_customer_email . $ph_order_date . $ph_coupon_description . $ph_reference_link,
            'id'                => 'ywces_mailbody_first_purchase',
            'default'           => __( 'Hi {customer_name},
thanks for making the first purchase on {order_date} on our shop {site_title}!
Because of this, we would like to offer you this coupon as a little gift:

{coupon_description}

See you on our shop,

{site_title}.', 'yith-woocommerce-coupon-email-system' ),
            'class'             => 'ywces-textarea',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'ywces_test_first_purchase'          => array(
            'name'              => __( 'Test email', 'yith-woocommerce-coupon-email-system' ),
            'type'              => 'ywces-send',
            'field_id'          => 'ywces_test_first_purchase',
            'custom_attributes' => $disabled
        ),
        'ywces_section_end_first_purchase'   => array(
            'type' => 'sectionend',
            //'id'   => 'ywces_section_end_first_purchase'
        ),
    )

);