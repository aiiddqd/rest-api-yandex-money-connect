<?php
/*
Plugin Name: Yandex Money Reciver via HTTP
Version: 0.2
Plugin URI: https://github.com/yumashev/rest-api-yandex-money-connect
Description: Получает и обрабатывает сообщения о платежая на Яндекс Деньги (class json_api_yandex_money). Endpoint /wp-json/yandex-money/v1/notify/
Author: yumashev@fleep.io
Author URI: https://github.com/yumashev/
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once 'inc/class-form-pay.php';
require_once 'inc/class-menu-settings.php';
require_once 'inc/class-email-sample.php';


class json_api_yandex_money {

  var $secret = '';

  function __construct(){
    add_filter('rest_enabled', '__return_true');
    add_action( 'rest_api_init', array($this, 'rest_api_init_callback') );

  }

  function rest_api_init_callback(){

    register_rest_route( 'yandex-money/v1', '/test/', array(
      'methods' => 'GET',
      'callback' => array($this, 'get_data'),
    ) );

    // Add deep-thoughts/v1/get-all-post-ids route
    register_rest_route( 'yandex-money/v1', '/notify/', array(
      'methods' => WP_REST_Server::CREATABLE,
      'callback' => array($this, 'save_data'),
    ));

  }

  function save_data($data_request){

    try {

      $body = print_r($data_request->get_body(), true);

      do_action( 'json_api_yandex_money_get_data', $body, $data_request );

      //check key with saved value
      // @todo = do it right
      $this->secret = get_option('ym_http_key', '');

      $response = new WP_REST_Response( array('success', 'Data received successfully') );
      $response->set_status( 200 );

    } catch (WP_REST_Exception $e) {
        $response = new WP_REST_Response( array('fail', 'Data not received') );
        $response->set_status( 500 );
    }

    return $response;

  }

  function get_data() {
  	return array('yandex-money', 'test ok');
  }

}

new json_api_yandex_money;
