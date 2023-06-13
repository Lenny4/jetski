<?php
/**
 * Plugin Name: jetski
 * Version: 1.0.0
 * Plugin URI: http://www.hughlashbrooke.com/
 * Description: This is your starter template for your next WordPress plugin.
 * Author: Hugh Lashbrooke
 * Author URI: http://www.hughlashbrooke.com/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: jetski
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author Hugh Lashbrooke
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load plugin class files.
require_once 'includes/class-jetski.php';
require_once 'includes/class-jetski-settings.php';

// Load plugin libraries.
require_once 'includes/lib/class-jetski-admin-api.php';
require_once 'includes/lib/class-jetski-post-type.php';
require_once 'includes/lib/class-jetski-taxonomy.php';

/**
 * Returns the main instance of jetski to prevent the need to use globals.
 *
 * @return object jetski
 * @since  1.0.0
 */
function jetski()
{
    $instance = jetski::instance(__FILE__, '1.0.0');

    if (is_null($instance->settings)) {
        $instance->settings = jetski_Settings::instance($instance);
    }

    return $instance;
}

jetski();
