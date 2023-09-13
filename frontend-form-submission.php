<?php
/**
 * Plugin Name: Frontend Form Submission
 * Plugin URI:  https://almn.me/frontend-form-submission
 * Description: This plugin will help you to collect some data from general users.
 * Version:     1.0
 * Author:      AL Amin
 * Author URI:  https://almn.me
 * Text Domain: frontend-form-submission
 * Domain Path: /languages
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package     FrontendFormSubmission
 * @author      AL Amin
 * @copyright   2023 ADS
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 *
 * Prefix:      FRONTEND_FORM_SUBMISSION
 */

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Autoloader for loading plugin classes.
 *
 * @param string $class The fully-qualified class name.
 *
 * @since   1.0.0
 * @package FrontendFormSubmission
 */
function ads_ffs_autoloader( $class ) {
    $namespace = 'ADS';
    $base_dir  = __DIR__ . '/includes/';

    $class = ltrim( $class, '\\' );

    if ( strpos( $class, $namespace . '\\' ) === 0 ) {
        $relative_class = substr( $class, strlen( $namespace . '\\' ) );
        $file           = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';
        if ( file_exists( $file ) ) {
            require $file;
        }
    }
}

// Register the autoloader
spl_autoload_register( 'ads_ffs_autoloader' );

/**
 * Main plugin class for Frontend Form Submission.
 *
 * @since   1.0.0
 * @package FrontendFormSubmission
 */
class FrontendFormSubmissionPlugin {
    private static $instance;

    /**
     * Constructor for the plugin class.
     *
     * @since 1.0.0
     */
    private function __construct() {
        add_action( 'plugins_loaded', [ $this, 'plugin_init' ] );
        register_activation_hook( __FILE__, [ $this, 'activate' ] );
        $this->define_constants();
    }

    /**
     * Get an instance of the plugin class.
     *
     * @since 1.0.0
     *
     * @return FrontendFormSubmissionPlugin The plugin instance.
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Activation hook callback.
     *
     * @since 1.0.0
     */
    public function activate() {
        $database = new \ADS\Admin\Create_Database();
        $database->create_database();
    }
    
    /**
     * Initialize the plugin.
     *
     * @since 1.0.0
     */
    public function plugin_init() {
        load_plugin_textdomain( 'frontend-form-submission', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        new \ADS\Frontend();
        new \ADS\Assets();
        
        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new \ADS\Ajax();
        }
        
        if ( is_admin() ) {
            new \ADS\Admin( new \ADS\Admin\Invoice() );
        } else {
            // Handle non-admin functionality if needed
        }
    }

    /**
     * Define plugin-specific constants.
     *
     * @since 1.0.0
     */
    public function define_constants() {
        define( 'ADS_FFS_VERSION', 'FrontendFormSubmission' );
        define( 'ADS_FFS_PLUGIN', __FILE__ );
        define( 'ADS_FFS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        define( 'ADS_FFS_PLUGIN_ASSET', ADS_FFS_PLUGIN_URL . 'assets/' );
        define( 'ADS_FFS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        define( 'WP_INVOICE_CAN_VIEW_REPORT', 'manage_invoice_reports' );
    }
}

// Get an instance of the main plugin class
FrontendFormSubmissionPlugin::get_instance();
