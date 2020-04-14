<?php
require_once("includes/header.php");

if ( !isset($_POST['contact']['email']) && !isset($_POST['contact']['fields']) ){
//   exit();
  // for test
  $_POST['contact']['email'] = 'kanthrad@bk.ru';
  $_POST['contact']['fields']['_'] = '||Апрель||Декабрь||Новый год||';
}

$email = $_POST['contact']['email'];
$p = $_POST['contact']['fields'];
$month = explode('||', trim($p['_'], '||'));
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
echo '1';
$date = explode('.', date('d.m.Y'));

$tag_add = $ac->api("contact/tag_remove", array("email" => $email, "tags" => "check-LM"));

$tag_add_param = array("email" => $email, "tags" => "LM");

if (strtotime('15.12.' . $date[2]) <= strtotime(implode('.', $date)) && in_array('Новый год', $month)) {
  $tag_add = $ac->api("contact/tag_add", $tag_add_param);
  $contact_add_to_automation = $ac->api("automation/contact_add", array( "contact_email" => $email, "automation" => "19"));
  print_r($contact_add_to_automation);
  // echo 'LM tag added (дата находится в периоде "новый год", у подписчика в поле месяц есть новый год"<br>';
  exit();
} else {
  if ($date[0] >= '19' && $date[0] <= '26' && $date[1] == '02' && in_array('Март', $month)) {
    $tag_add = $ac->api("contact/tag_add", $tag_add_param);
    $contact_add_to_automation = $ac->api("automation/contact_add", array( "contact_email" => $email, "automation" => "19"));
    print_r($contact_add_to_automation);
    // echo 'LM tag added (19-26.02, в полях отмечен Март)<br>';
    exit();
  } elseif ($date[0] >= '19' && $date[0] <= '26' && $date[1] == '02' && !in_array('Март', $month)) {
      $tag_add = $ac->api("contact/tag_remove", $tag_add_param);
      $contact_add_to_automation = $ac->api("automation/contact_add", array( "contact_email" => $email, "automation" => "21"));
    print_r($contact_add_to_automation);
      // echo 'LM tag removed<br>';
      exit();
  } else {
    if ($date[0] >= '1' && $date[0] <= '27' && in_array($month_list[$date[1]], $month)) {
      $tag_add = $ac->api("contact/tag_add", $tag_add_param);
      $contact_add_to_automation = $ac->api("automation/contact_add", array( "contact_email" => $email, "automation" => "19"));
      print_r($contact_add_to_automation);
      // echo 'LM tag added (1-27, в полях отмечен текущий месяц)<br>';
      exit();
    } else {
      $current = $date[1];
      $keys = array_keys($month_list);
      $ordinal = (array_search($current, $keys) + 1) % count($keys);
      $next_month = $keys[$ordinal];

      if ($date[0] >= '21' && $date[0] <= '31' && in_array($month_list[$next_month], $month)) {
        $tag_add = $ac->api("contact/tag_add", $tag_add_param);
        $contact_add_to_automation = $ac->api("automation/contact_add", array( "contact_email" => $email, "automation" => "19"));
        print_r($contact_add_to_automation);
        // echo 'LM tag added (21-31, в полях отмечен след. месяц)<br>';
        exit();
      } else {
        $tag_add = $ac->api("contact/tag_remove", $tag_add_param);
        $contact_add_to_automation = $ac->api("automation/contact_add", array( "contact_email" => $email, "automation" => "21"));
        print_r($contact_add_to_automation);
        // echo 'LM tag removed<br>';
        exit();
      }

    }
  }
}
