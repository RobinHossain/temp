<?php

/**
 * The plugin bootstrap file
 *
 * @since             1
 * @package           Customer_Account_Creator
 *
 * @wordpress-plugin
 * Plugin Name:       Customer Account Creator
 * Description:       Customer Account Creator is a plugin to create new customers based on third-party request calls.
 * Version:           1
 * Requires at least: 4.0
 * Tags: account creator, customer
 * Tested up to: 5.8
 * Author:            W3BD
 * Author URI:        http://w3bd.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       customer-account-creator
 *
 */


/**
 * A simple method to create WP User
 */
function method_customer_ac() {

	$post = $_POST;
	$user_id = 0;
	$response = [];

	if(!empty($post['name']) && !empty($post['email']) && !email_exists($post['email'])){
		$name = $post['name'];
		$email = $post['email'];

		$breakNames = explode(" ", $name);
		if(count($breakNames) > 1) {
			$lastname = array_pop($breakNames);
			$firstname = implode(" ", $breakNames);
		} else {
			$firstname = $name;
			$lastname = "";
		}

		$user_id = wp_insert_user( array(
			'user_login' => strtolower($firstname),
			'user_pass' => wp_generate_password(),
			'user_email' => $email,
			'first_name' => $firstname,
			'last_name' => $lastname,
			'display_name' => $name,
			'role' => 'subscriber'
		));

		if( $user_id && !empty($post['lara_id']) ){
			update_user_meta($user_id, 'lara_id', $post['lara_id']);
			$response['account_created'] = true;
		}
	}

	$response['user_id'] = $user_id;

	echo json_encode($response);
}
add_action( 'admin_post_nopriv_customer_ac', 'method_customer_ac' );
add_action( 'admin_post_customer_ac', 'method_customer_ac' );

/**
 * Add a tiny button link on the WP user list's username column hover section
 * @param $actions
 * @param $user
 *
 * @return mixed
 */
function add_view_lara_profile ($actions, $user) {
	$lara_site_url = "http://127.0.0.1:8000";
	$lara_id = get_user_meta($user->ID, 'lara_id', true);
	if(!empty($lara_id)){
		$actions['add_view_lara_profile'] = "<a href='$lara_site_url/customers/details/$lara_id'>View Lara Profile</a>" ;
	}
	return ($actions) ;
}
add_filter ('user_row_actions', 'add_view_lara_profile', 10, 2) ;