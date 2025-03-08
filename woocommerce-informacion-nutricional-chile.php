<?php
// filepath: c:\Users\gusta\OneDrive\Desktop\Freemius\woocommerce-informacion-nutricional-chile\woocommerce-informacion-nutricional-chile\woocommerce-informacion-nutricional-chile.php
/**
 * Plugin Name: Woocommerce - Información Nutricional Chile
 * Plugin URI: http://tech4in.com
 * Description: Añade información nutricional y sellos de advertencia a los productos de WooCommerce, según la normativa chilena.
 * Version: 1.0.2
 * Author: Tech4In
 * Author URI: http://tech4in.com
 * Text Domain: woocommerce-informacion-nutricional-chile
 * Domain Path: /languages
 *
 * @package INCW_Productos_Alimenticios_Chile
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Check if WooCommerce is active
 */
if ( ! function_exists( 'incw_is_woocommerce_active' ) ) {
    function incw_is_woocommerce_active() {
        return class_exists( 'WooCommerce' );
    }
}

/**
 * Display an admin notice if WooCommerce is not installed or active.
 */
function incw_admin_woocommerce_inactive_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Woocommerce - Información Nutricional Chile requires WooCommerce to be installed and active. Please install and activate WooCommerce to use this plugin.', 'woocommerce-informacion-nutricional-chile' ); ?></p>
    </div>
    <?php
}

/**
 * Check if WooCommerce is installed and active during plugin activation
 */
function incw_check_woocommerce_activation() {
    if ( ! incw_is_woocommerce_active() ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        add_action( 'admin_notices', 'incw_admin_woocommerce_inactive_notice' );
        unset( $_GET[ 'activate' ] );
    }
}
register_activation_hook( __FILE__, 'incw_check_woocommerce_activation' );

/**
 * Main plugin class.
 */
if ( ! class_exists( 'INCW_Productos_Alimenticios_Chile' ) ) {

    /**
     * Main plugin class: INCW_Productos_Alimenticios_Chile.
     */
    class INCW_Productos_Alimenticios_Chile {

        /**
         * Instance of the plugin.
         *
         * @var INCW_Productos_Alimenticios_Chile
         */
        protected static $_instance = null;

        /**
         * Instance of the plugin.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Constructor.
         */
        private function __construct() {
            // Check if WooCommerce is active before initializing the plugin
            if ( ! incw_is_woocommerce_active() ) {
                return;
            }

            $this->incw_define_constants();
            $this->incw_includes();
            $this->incw_init_hooks();

            do_action( 'incw_productos_alimenticios_chile_loaded' );
        }

        /**
         * Define plugin constants.
         */
        private function incw_define_constants() {
            define( 'INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_FILE', __FILE__ );
            define( 'INCW_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION', '1.0.2' );
            define( 'INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            define( 'INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            define( 'INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL', INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL . 'assets/' );
        }

        /**
         * Include required files.
         */
        private function incw_includes() {
            // include_once( INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/admin/class-metaboxes.php' ); // Removed direct inclusion
            include_once( INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/frontend/class-frontend-display.php' );
        }

        /**
         * Initialize WordPress hooks.
         */
        private function incw_init_hooks() {
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_styles' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
        }

        /**
         * Enqueue frontend styles.
         */
        public function enqueue_frontend_styles() {
            wp_enqueue_style(
                'incw_productos_alimenticios_chile_frontend_styles',
                INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'css/frontend-styles.css',
                array(),
                INCW_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION
            );
        }

        /**
         * Enqueue admin styles.
         *
         * @param string $hook_suffix Hook suffix.
         */
        public function enqueue_admin_styles( $hook_suffix ) {
            if ( is_admin() ) {
                $screen = get_current_screen();
                if ( isset( $screen->post_type ) && $screen->post_type === 'product' ) {
                    wp_enqueue_style(
                        'incw_productos_alimenticios_chile_admin_styles',
                        INCW_PRODUCTOS_ALIMENTICIOS_CHILE_ASSETS_URL . 'css/admin/admin-styles.css',
                        array(),
                        INCW_PRODUCTOS_ALIMENTICIOS_CHILE_VERSION
                    );
                }
            }
        }

        /**
         * Get the plugin url.
         */
        public function plugin_url() {
            return untrailingslashit( INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_URL );
        }

        /**
         * Get the plugin path.
         */
        public function plugin_path() {
            return untrailingslashit( INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR );
        }
    }
}

/**
 * Returns the main instance of the plugin.
 *
 * @return INCW_Productos_Alimenticios_Chile
 */
function incw_get_instance() {
    return INCW_Productos_Alimenticios_Chile::instance();
}

/**
 * Load plugin textdomain.
 */
function incw_load_textdomain() {
    load_plugin_textdomain( 'woocommerce-informacion-nutricional-chile', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'incw_load_textdomain' ); // Load textdomain on init

/**
 * Instantiate the metaboxes class on plugins_loaded
 */
add_action( 'plugins_loaded', 'incw_instantiate_metaboxes' );
function incw_instantiate_metaboxes() {
    if ( incw_is_woocommerce_active() ) {
        // Ensure plugin constants are defined
        incw_get_instance();

        require_once INCW_PRODUCTOS_ALIMENTICIOS_CHILE_PLUGIN_DIR . 'includes/admin/class-metaboxes.php';
        new INCW_Productos_Alimenticios_Chile_Metaboxes();
    }
}

/**
 * Initialize the plugin after plugins are loaded.
 */
function incw_init_plugin() {
    if ( incw_is_woocommerce_active() ) {
        // Initialize the main plugin class only if WooCommerce is active
        incw_get_instance();
    } else {
        // Display an admin notice if WooCommerce is not active
        add_action( 'admin_notices', 'incw_admin_woocommerce_inactive_notice' );
    }
}
add_action( 'plugins_loaded', 'incw_init_plugin' );