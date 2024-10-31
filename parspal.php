<?php
/*
Plugin Name: Parspal
Plugin URI: http://iran98.org/category/wordpress/parspal/
Description: Parspas getway for wordpress
Version: 1.2
Author: Mostafa Soufi
Author URI: http://iran98.org/
License: GPL2
*/
	load_plugin_textdomain('parspal','wp-content/plugins/parspal/langs');

	include_once('inc/parspal.class.php');
	$parspal = new Parspal;

	if(get_option('MerchantID') && get_option('port_password')) {
		$parspal->MerchantID = get_option('MerchantID');
		$parspal->Password = get_option('port_password');
	}

	function parspal_menu() {
		if (function_exists('add_options_page')) {
			add_menu_page(__('ParsPal', 'parspal'), __('ParsPal', 'parspal'), 'manage_options', 'parspal/setting.php', 'parspal_menupage', plugin_dir_url( __FILE__ ).'/images/Parspal_favicon.png');
			add_submenu_page('parspal/setting.php', __('Parspal Setting', 'parspal'), __('Parspal Setting', 'parspal'), 'manage_options', 'parspal/setting.php', 'parspal_menupage');
		}
	}
	add_action('admin_menu', 'parspal_menu');

	function parspal_menupage() {
		if (!current_user_can('manage_options')) {
			wp_die(__('You do not have sufficient permissions to access this page.', 'parspal'));
		}

		settings_fields('parspal_options');
		function register_parspal() {
			register_setting('parspal_options', 'MerchantID');
			register_setting('parspal_options', 'port_password');
		}

		include_once('setting.php');
	}

	function parspal_form() {

		if(is_user_logged_in()) {

			global $current_user, $parspal;
			include_once('inc/form.php');

			if($_POST['submit_payment']) {

				if($_POST['payer_name'] && $_POST['payer_email'] && $_POST['payer_mobile'] && $_POST['payer_price'] && $_POST['description_payment']) {

					$parspal->Price = $_POST['payer_price'];
					$parspal->ReturnPath = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
					$parspal->ResNumber = preg_replace("/[^0-9]/", "", uniqid());
					$parspal->Description = $_POST['description_payment'];
					$parspal->Paymenter = $_POST['payer_name'];
					$parspal->Email = $_POST['payer_email'];
					$parspal->Mobile = $_POST['payer_mobile'];

					if($parspal->Request()) {

						switch($parspal->Request()) {

							case 'Ready':
								echo '<p class="error-payment">' . __('Error! No action has been.', 'parspal') . '</p>';
								break;

							case 'GetwayUnverify':
								echo '<p class="error-payment">' . __('Error! Your port is disabled.', 'parspal') . '</p>';
								break;

							case 'GetwayIsExpired':
								echo '<p class="error-payment">' . __('Error! Your port is invalid.', 'parspal') . '</p>';
								break;

							case 'GetwayIsBlocked':
								echo '<p class="error-payment">' . __('Error! Your port is blocked.', 'parspal') . '</p>';
								break;

							case 'GetwayInvalidInfo':
								echo '<p class="error-payment">' . __('Error! Your user code or password is incorrect.', 'parspal') . '</p>';
								break;

							case 'UserNotActive':
								echo '<p class="error-payment">' . __('Error! User is inactive.', 'parspal') . '</p>';
								break;

							case 'InvalidServerIP':
								echo '<p class="error-payment">' . __('Error! IP server is invalid.', 'parspal') . '</p>';
								break;

							case 'Failed':
								echo '<p class="error-payment">' . __('Error! Operation fails.', 'parspal') . '</p>';
								break;
						}
					} else {
						add_option('user_price_' . $current_user->ID, $_POST['payer_price']);
						update_option('user_price_' . $current_user->ID, $_POST['payer_price']);
					}
				} else {
					echo '<p class="error-payment">' . __('Error! Please Complate all field.', 'parspal') . '</p>';
				}
			}

			$parspal->Price = get_option('user_price_' . $current_user->ID);

			switch($parspal->Verify()) {

				case 'Ready':
					echo '<p class="error-payment">' . __('Error! No action has been.', 'parspal') . '</p>';
					continue;

				case 'NotMatchMoney':
					echo '<p class="error-payment">' . __('Error! Paid the amount requested is not equa.', 'parspal') . '</p>';
					continue;

				case 'Verifyed':
					echo '<p class="error-payment">' . __('Error! Has already been paid.', 'parspal') . '</p>';
					continue;

				case 'InvalidRef':
					echo '<p class="error-payment">' . __('Error! Receipt number is not acceptable.', 'parspal') . '</p>';
					continue;

				case 'success':
					echo '<p class="success-payment">' . sprintf(__('Transaction was successful. <br /> Your tracking number: %s <br /> Payment price : %s <br /> Your Order ID: %s', 'parspal'), $parspal->RefNumber, number_format($parspal->PayPrice, 0, '.', ''), $parspal->ResNumber) . '</p>';
					continue;
			}

			delete_option('user_price_' . $current_user->ID);

		} else {
			echo sprintf(__('This form is for registeration users. please <a href="%s">login</a> to site.', 'parspal'), wp_login_url());
		}
	}
	
	add_shortcode('parspal', 'parspal_form');
	add_filter('widget_text', 'do_shortcode');
?>