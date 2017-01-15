<?php
/**
 * Sample class for email data
 */
class ym_http_email_sample{

  function __construct(){
    add_action( 'json_api_yandex_money_get_data', array($this, 'json_api_yandex_money_get_data_mail'), $priority = 10, $accepted_args = 2 );
  }



    function json_api_yandex_money_get_data_mail($body, $data_request){

      if( ! get_option( 'ym_http_mail_enable', $default = false ) )
        return;

      $to = get_option( 'ym_http_mail_addresses', get_option('admin_email') );

      $message = 'Поступил платеж';
      $message .= '<br/>';

      $message .= sprintf('<hr><pre>%s</pre>', $body);

      $data = print_r($data_request, true);
      $message .= sprintf('<hr><pre>%s</pre>', $data);

      $subject = apply_filters( 'ym_http_subject_mail', 'Поступил платеж через ЯДеньги' );

      add_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );
      $result = wp_mail( $to, $subject, $message);
      remove_filter( 'wp_mail_content_type', array($this, 'set_html_content_type') );


    }

    function set_html_content_type(){
      return 'text/html';
    }

}
new ym_http_email_sample;
