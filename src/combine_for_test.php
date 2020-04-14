<?php
require_once("includes/header.php");

// $email = $_POST['contact']['email'];
// $p = $_POST['contact']['fields'];
// $month = explode('||', trim($p['_'], '||')); // Месяц.
if ( isset( $_GET['email'] ) && isset( $_GET['date'] ) ) {

	$email = $_GET['email'];
	$contact_email = $ac->api( "contact/view?email=" . $email );
	// $contact_email->fields : 
	// {1}Месяц отдыха
	// {3}Открыта многократная виза шенген?
	// {4}Пауза подписки
	// {5}Интересуют автобусные туры?
	// {6}Компания
	// {7}Кол-во взрослых и детей
	// {8}1 период, с
	// {9}1 период, по
	// {10}Дата проверки
	// {11}
	// {12}Город вылета
	// {13}Ночей, от
	// {14}Ночей, до
	// {15}Отели только на первой линии
	// {17}Питание
	// {18}Звездность отеля
	// {19}Цена от
	// {20}Цена до
	// {21}Не предлагать страны

	$p = $contact_email->fields;
	$month = explode('||', trim($p->{1}->val, '||')); // Месяц.

	$month_list = array(
	  '01' => 'Январь',
	  '02' => 'Февраль',
	  '03' => 'Март',
	  '04' => 'Апрель',
	  '05' => 'Май',
	  '06' => 'Июнь',
	  '07' => 'Июль',
	  '08' => 'Август',
	  '09' => 'Сентябрь',
	  '10' => 'Октябрь',
	  '11' => 'Ноябрь',
	  '12' => 'Декабрь'
	);

	// $date = explode('.', date('d.m.Y'));
	$date = explode('.', $_GET['date']); // d.m.Y

	$tag_add_param = array("email" => $email, "tags" => "LM");

	if (strtotime('15.12.' . $date[2]) <= strtotime(implode('.', $date)) && in_array('Новый год', $month)) {
	  $tag_add = $ac->api("contact/tag_add", $tag_add_param);
	  echo 'LM tag added (дата находится в периоде "новый год", у подписчика в поле месяц есть новый год"<br>';
	  require_once("combine_add_lm.php");
	  exit();
	} else {
	  if ($date[0] >= '19' && $date[0] <= '26' && $date[1] == '02' && in_array('Март', $month)) {
	    $tag_add = $ac->api("contact/tag_add", $tag_add_param);
	    echo 'LM tag added (19-26.02, в полях отмечен Март)<br>';
	    require_once("combine_add_lm.php");
	    exit();
	  } elseif ($date[0] >= '19' && $date[0] <= '26' && $date[1] == '02' && !in_array('Март', $month)) {
	    	$tag_add = $ac->api("contact/tag_remove", $tag_add_param);
	        echo 'LM tag removed<br>';
	        require_once("combine_remove_lm.php");
	        exit();
	  } else {
	    if ($date[0] >= '1' && $date[0] <= '27' && in_array($month_list[$date[1]], $month)) {
	      $tag_add = $ac->api("contact/tag_add", $tag_add_param);
	      echo 'LM tag added (1-27, в полях отмечен текущий месяц)<br>';
	      require_once("combine_add_lm.php");
	      exit();
	    } else {
	      $current = $date[1];
	      $keys = array_keys($month_list);
	      $ordinal = (array_search($current, $keys) + 1) % count($keys);
	      $next_month = $keys[$ordinal];

	      if ($date[0] >= '21' && $date[0] <= '31' && in_array($month_list[$next_month], $month)) {
	        $tag_add = $ac->api("contact/tag_add", $tag_add_param);
	        echo 'LM tag added (21-31, в полях отмечен след. месяц)<br>';
	        require_once("combine_add_lm.php");
	        exit();
	      } else {
	        $tag_add = $ac->api("contact/tag_remove", $tag_add_param);
	        echo 'LM tag removed<br>';
	        require_once("combine_remove_lm.php");
	        exit();
	      }

	    }
	  }
	}


} else {
	echo "добавьте параметр email=, id= (данные подписчика) и date= ('текущая' дата) в url (date в формате d.m.Y, 01.05.2019)";
}
