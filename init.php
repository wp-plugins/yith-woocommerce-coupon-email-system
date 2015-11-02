<?php
/**
 * Plugin Name: YITH WooCommerce Coupon Email System
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-coupon-email-system/
 * Description: YITH WooCommerce Coupon Email System offers an automatic way to send a coupon to your users according to specific events.
 * Author: YIThemes
 * Text Domain: yith-woocommerce-coupon-email-system
 * Version: 1.0.4
 * Author URI: http://yithemes.com/
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function ywces_install_free_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Coupon Email System while you are using the premium one.', 'yith-woocommerce-coupon-email-system' ); ?></p>
    </div>
<?php
}

function ywces_install_woocommerce_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'YITH WooCommerce Coupon Email System is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-coupon-email-system' ); ?></p>
    </div>
<?php
}

if ( !defined( 'YWCES_VERSION' ) ) {
    define( 'YWCES_VERSION', '1.0.4' );
}

if ( !defined( 'YWCES_FREE_INIT' ) ) {
    define( 'YWCES_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( !defined( 'YWCES_FILE' ) ) {
    define( 'YWCES_FILE', __FILE__ );
}

if ( !defined( 'YWCES_DIR' ) ) {
    define( 'YWCES_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'YWCES_URL' ) ) {
    define( 'YWCES_URL', plugins_url( '/', __FILE__ ) );
}

if ( !defined( 'YWCES_ASSETS_URL' ) ) {
    define( 'YWCES_ASSETS_URL', YWCES_URL . 'assets' );
}

if ( !defined( 'YWCES_TEMPLATE_PATH' ) ) {
    define( 'YWCES_TEMPLATE_PATH', YWCES_DIR . 'templates' );
}

/* Plugin Framework Version Check */
if( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( YWCES_DIR . 'plugin-fw/init.php' ) ) {
    require_once( YWCES_DIR . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( YWCES_DIR  );

function ywces_free_init() {

    /* Load text domain */
    load_plugin_textdomain( 'yith-woocommerce-coupon-email-system', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    /* === Global YITH WooCommerce Coupon Email System  === */
    YITH_WCES();

}

add_action( 'ywces_init', 'ywces_free_init' );

function ywces_free_install() {

    if ( !function_exists( 'WC' ) ) {
        add_action( 'admin_notices', 'ywces_install_woocommerce_admin_notice' );
    }
    elseif ( defined( 'YWCES_PREMIUM' ) ) {
        add_action( 'admin_notices', 'ywces_install_free_admin_notice' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
    else {
        do_action( 'ywces_init' );
    }

}

add_action( 'plugins_loaded', 'ywces_free_install', 11 );

/**
 * Init default plugin settings
 */
if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}

register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( !function_exists( 'YITH_WCES' ) ) {

    /**
     * Unique access to instance of YITH_WC_Coupon_Email_System
     *
     * @since   1.0.0
     * @return  YITH_WC_Coupon_Email_System|YITH_WC_Coupon_Email_System_Premium
     * @author  Alberto Ruggiero
     */
    function YITH_WCES() {

        // Load required classes and functions
        require_once( YWCES_DIR . 'class.yith-wc-coupon-email-system.php' );

        if ( defined( 'YWCES_PREMIUM' ) && file_exists( YWCES_DIR . 'class.yith-wc-coupon-email-system-premium.php' ) ) {


            require_once( YWCES_DIR . 'class.yith-wc-coupon-email-system-premium.php' );
            return YITH_WC_Coupon_Email_System_Premium::get_instance();
        }

        return YITH_WC_Coupon_Email_System::get_instance();

    }

}