<?php
/**
 * Plugin Name: Unique User ID for WooCommerce
 * Description: A plugin that adds a unique 10-digit ID to each user in WooCommerce.
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

// Ensure WordPress is loaded
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Load plugin textdomain for translations
function unique_user_id_load_textdomain() {
    load_plugin_textdomain( 'unique-user-id', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'unique_user_id_load_textdomain' );

// Function to generate a unique 10-digit ID
function generate_unique_user_id() {
    return mt_rand(1000000000, 9999999999); // Generates a random 10-digit number
}

// Function to assign the unique ID to a user when they register
function assign_unique_user_id( $user_id ) {
    // Check if the unique ID is already assigned to the user
    if ( ! get_user_meta( $user_id, 'unique_user_id', true ) ) {
        $unique_id = generate_unique_user_id(); // Generate the unique ID
        // Save the unique ID in user meta data
        update_user_meta( $user_id, 'unique_user_id', $unique_id );
    }
}
add_action( 'user_register', 'assign_unique_user_id', 10, 1 );

// Function to display the unique user ID in the user's account page
function display_unique_user_id_in_account( $user ) {
    $unique_user_id = get_user_meta( $user->ID, 'unique_user_id', true );
    if ( $unique_user_id ) {
        echo '<h3>' . __( 'Your Unique User ID', 'unique-user-id' ) . '</h3>';
        echo '<p>' . $unique_user_id . '</p>';
    }
}
add_action( 'woocommerce_account_dashboard', 'display_unique_user_id_in_account' );
