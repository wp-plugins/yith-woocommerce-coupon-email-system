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
 * Implements Coupon Mail for YWCES plugin (HTML)
 *
 * @class   YWCES_Coupon_Mail
 * @package Yithemes
 * @since   1.0.0
 * @author  Your Inspiration Themes
 */

if ( defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywces_mail_template_enable' ) == 'yes' ) {

    do_action( 'yith_wcet_email_header', $email_heading, 'yith-coupon-email-system' );

}
else {

    do_action( 'ywces_email_header', $email_heading, $template );

}

echo $mail_body;


if ( defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywces_mail_template_enable' ) == 'yes' ) {

    do_action( 'yith_wcet_email_footer', 'yith-coupon-email-system' );

}
else {

    do_action( 'ywces_email_footer', $template );

}