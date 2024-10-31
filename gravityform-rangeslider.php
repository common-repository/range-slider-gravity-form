<?php  
/**
 * Plugin Name: Range Slider Gravity Form
 * Description: This plugin allows create Rangeslider for gravityfrom.
 * Version: 1.0
 * Author: Ocean Infotech
 * Author URI: https://www.xeeshop.com
 * Copyright:2019 
 */
if (!defined('ABSPATH')) {
    die('-1');
}
if (!defined('OCRSGF_PLUGIN_NAME')) {
    define('OCRSGF_PLUGIN_NAME', 'Range Slider Gravity Form');
}
if (!defined('OCRSGF_PLUGIN_VERSION')) {
    define('OCRSGF_PLUGIN_VERSION', '2.0.0');
}
if (!defined('OCRSGF_PLUGIN_FILE')) {
    define('OCRSGF_PLUGIN_FILE', __FILE__);
}
if (!defined('OCRSGF_PLUGIN_DIR')) {
    define('OCRSGF_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('OCRSGF_DOMAIN')) {
    define('OCRSGF_DOMAIN', 'ocrsgf');
}
if (!defined('OCRSGF_BASE_NAME')) {
define('OCRSGF_BASE_NAME', plugin_basename(OCRSGF_PLUGIN_FILE));
}
if (!class_exists('OCRSGF')) {

  	class OCRSGF {
      protected static $OCRSGF_instance;
  
      function includes() {
        include_once('admin/gravity_rangeslider.php');
      }


      function init() { 
        add_action('admin_enqueue_scripts', array($this, 'OCRSGF_load_admin_script_style'));
        add_action( 'wp_enqueue_scripts',array($this,'OCRSGF_enqueue_custom_script'));
         
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );        
      }


        function OCRSGF_load_admin_script_style() {
           wp_enqueue_style( 'OCRSGF_admin_css', OCRSGF_PLUGIN_DIR . '/includes/css/admin_style.css', false, '2.0.0' );
      }

      function plugin_row_meta( $links, $file ) {
        if ( OCRSGF_BASE_NAME === $file ) {
          $row_meta = array(
            'rating' => '<a href="https://wordpress.org/support/plugin/post-slider-by-oc/reviews/#new-post" target="_blank"><img src="'.OCRSGF_PLUGIN_DIR.'/includes/image/star.png" class="OCRSGF_rating_div"></a>',
            );

            return array_merge( $links, $row_meta );
        }

        return (array) $links;
      }


      function OCRSGF_enqueue_custom_script() {
            wp_enqueue_script( 'custom_script', OCRSGF_PLUGIN_DIR.'/includes/js/front.js');
            wp_enqueue_style( 'OCGFRS-style-css', OCRSGF_PLUGIN_DIR . '/includes/css/style.css', false, '2.0.0' );
            wp_enqueue_script( 'OCGFRS-jquery-ui-touch-punch-js', OCRSGF_PLUGIN_DIR .'/includes/js/jquery.ui.touch-punch.min.js', false, '2.0.0' );
            wp_enqueue_style( 'OCGFRS-jquery-ui-css', OCRSGF_PLUGIN_DIR .'/includes/js/jquery-ui.css', false, '2.0.0' );
            wp_enqueue_script( 'jquery-ui-slider', false, array('jquery'));  
      }


      //Plugin Rating
      public static function do_activation() {
        set_transient('ocgfrs-first-rating', true, MONTH_IN_SECONDS);
      }


      public static function OCRSGF_instance() {
        if (!isset(self::$OCRSGF_instance)) {
          self::$OCRSGF_instance = new self();
          self::$OCRSGF_instance->init();
          self::$OCRSGF_instance->includes();
          }
        return self::$OCRSGF_instance;
          }
  		}
  		add_action('plugins_loaded', array('OCRSGF', 'OCRSGF_instance'));
      register_activation_hook(OCRSGF_PLUGIN_FILE, array('OCRSGF', 'do_activation'));
}
