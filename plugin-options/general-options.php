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
$placeholders_text     = __( 'Allowed placeholders:', 'ywces' );
$ph_reference_link     = ' - <a href="' . $howto_url . '" target="_blank">' . __( 'More info', 'ywces' ) . '</a>';
$ph_site_title         = ' <b>{site_title}</b>';
$ph_customer_name      = ' <b>{customer_name}</b>';
$ph_customer_last_name = ' <b>{customer_last_name}</b >';
$ph_customer_email     = ' <b>{customer_email}</b>';
$ph_coupon_description = ' <b>{coupon_description}</b>';
$ph_order_date         = ' <b>{order_date}</b>';

$coupons = array_merge( array( '' => __( 'Select a coupon', 'ywces' ) ), YITH_WCES()->_available_coupons );

$disabled = ( count( YITH_WCES()->_available_coupons ) > 0 ? array() : array( 'disabled' => 'disabled' ) );

return array(
    'general' => array(
        'ywces_main_section_title'           => array(
            'name' => __( 'Coupon Email System settings', 'ywces' ),
            'type' => 'title',
            'desc' => '',
            'id'   => 'ywces_main_section_title',
        ),
        'ywces_enable_plugin'                => array(
            'name'    => __( 'Enable YITH WooCommerce Coupon Email System', 'ywces' ),
            'type'    => 'checkbox',
            'desc'    => '',
            'id'      => 'ywces_enable_plugin',
            'default' => 'yes',
        ),
        'ywces_mail_type'                    => array(
            'name'    => __( 'Email type', 'ywces' ),
            'type'    => 'select',
            'desc'    => __( 'Choose which email format to send.', 'ywces' ),
            'options' => array(
                'html'  => __( 'HTML', 'ywces' ),
                'plain' => __( 'Plain text', 'ywces' )
            ),
            'default' => 'html',
            'id'      => 'ywces_mail_type'
        ),
        'ywces_main_section_end'             => array(
            'type' => 'sectionend',
            'id'   => 'ywces_main_section_end'
        ),

        'ywces_section_title_first_purchase' => array(
            'name' => __( 'On first purchase', 'ywces' ),
            'type' => 'title',
            'desc' => '',
            'id'   => 'ywces_section_title_first_purchase',
        ),
        'ywces_collapse_first_purchase'      => array(
            'type' => 'ywces-collapse'
        ),
        'ywces_enable_first_purchase'        => array(
            'name'              => __( 'Enable coupon sending', 'ywces' ),
            'type'              => 'checkbox',
            'desc'              => '',
            'id'                => 'ywces_enable_first_purchase',
            'default'           => 'no',
            'custom_attributes' => $disabled
        ),
        'ywces_coupon_first_purchase'        => array(
            'name'    => __( 'Selected Coupon', 'ywces' ),
            'type'    => 'select',
            'desc'    => __( 'Choose the coupon to send', 'ywces' ),
            'options' => $coupons,
            'default' => '',
            'id'      => 'ywces_coupon_first_purchase',
        ),
        'ywces_subject_first_purchase'       => array(
            'name'              => __( 'Email subject', 'ywces' ),
            'type'              => 'text',
            'desc'              => $placeholders_text . $ph_site_title . $ph_customer_name . $ph_customer_last_name . $ph_reference_link,
            'id'                => 'ywces_subject_first_purchase',
            'default'           => __( 'You have received a coupon from {site_title}', 'ywces' ),
            'class'             => 'ywces-text',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'ywces_mailbody_first_purchase'      => array(
            'name'              => __( 'Email content', 'ywces' ),
            'type'              => 'ywces-textarea',
            'desc'              => $placeholders_text . $ph_site_title . $ph_customer_name . $ph_customer_last_name . $ph_customer_email . $ph_order_date . $ph_coupon_description . $ph_reference_link,
            'id'                => 'ywces_mailbody_first_purchase',
            'default'           => __( 'Hi {customer_name},
thanks for making the first purchase on {order_date} on our shop {site_title}!
Because of this, we would like to offer you this coupon as a little gift:

{coupon_description}

See you on our shop,

{site_title}.', 'ywces' ),
            'class'             => 'ywces-textarea',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'ywces_test_first_purchase'          => array(
            'name'              => __( 'Test email', 'ywces' ),
            'type'              => 'ywces-send',
            'field_id'          => 'ywces_test_first_purchase',
            'custom_attributes' => $disabled
        ),
        'ywces_section_end_first_purchase'   => array(
            'type' => 'sectionend',
            'id'   => 'ywces_section_end_first_purchase'
        ),
    )

);