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
spl_autoload_register( 'ads_ffs_autoloader' );

class FrontendFormSubmissionPlugin {
    private static $instance;

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'plugin_init' ) );
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        $this->define_constants();
    }

    public static function get_instance() {
        if ( ! isset( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function activate() {
        $database = new \ADS\Admin\Database();
        $database->create_database();
    }

    public function plugin_init() {
        load_plugin_textdomain( 'frontend-form-submission', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
        new \ADS\Frontend();
        new \ADS\Assets();
    }

    public function define_constants(){
        define( 'ADS_FFS_VERSION', 'FrontendFormSubmission' );
        define( 'ADS_FFS_PLUGIN', __FILE__ );
        define( 'ADS_FFS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        define( 'ADS_FFS_PLUGIN_ASSET', ADS_FFS_PLUGIN_URL . 'assets/');
        define( 'ADS_FFS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    }
}

FrontendFormSubmissionPlugin::get_instance();