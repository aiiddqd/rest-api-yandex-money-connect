<?php

/**
 *
 */
class json_api_yandex_money_shortcode
{

  var $account = '41001388230059';
  function __construct()
  {
    add_shortcode( 'ym_pay', array($this, 'display_form') );
  }

  function display_form(){

    ob_start();
    ?>
      <form method="POST" action="https://money.yandex.ru/quickpay/confirm.xml">
        <input type="hidden" name="receiver" value="<?php echo $this->account ?>">
        <input type="hidden" name="formcomment" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
        <input type="hidden" name="short-dest" value="Проект «Железный человек»: реактор холодного ядерного синтеза">
        <input type="hidden" name="label" value="$order_id">
        <input type="hidden" name="quickpay-form" value="donate">
        <input type="hidden" name="targets" value="транзакция {order_id}">
        <input type="hidden" name="sum" value="4568.25" data-type="number">
        <input type="hidden" name="comment" value="Хотелось бы дистанционного управления.">
        <input type="hidden" name="need-fio" value="true">
        <input type="hidden" name="need-email" value="true">
        <input type="hidden" name="need-phone" value="false">
        <input type="hidden" name="need-address" value="false">
        <label><input type="radio" name="paymentType" value="PC">Яндекс.Деньгами</label>
        <label><input type="radio" name="paymentType" value="AC">Банковской картой</label>
        <input type="submit" value="Перевести">
      </form>
    <?php

    return ob_get_clean();
  }
}
new json_api_yandex_money_shortcode;
