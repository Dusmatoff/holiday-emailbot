<?php
require_once("includes/header.php");

if ( !isset($_POST['contact']['email']) && !isset($_POST['contact']['fields']) ){
  exit();
}

$email = $_POST['contact']['email'];
// $id = $_POST['contact']['id'];
$p = $_POST['contact']['fields'];
$month = explode('||', trim($p['_'], '||'));
$date = explode('.', date('d.m.Y'));
$month_list_2 = array(
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
  '12' => 'Декабрь',
);

$keys = array_keys($month_list_2);
$now = (array_search($date[1], $keys));
$remaining_month_of_current_years = array_slice($month_list_2, $now, '13', true);
$remaining_month_of_current_years['13'] = 'Новый год';
$subscriber_nearest_month = '';
$present_month_checked_in_subscriber_field = false;
$check_date = '';
$next_year = $date[2]+1;
// поиск первого отмеченного у подписчика месяца из оставшихся в текущем году месяцев 
foreach ($remaining_month_of_current_years as $k_cy => $m_cy) {
	if(!in_array($m_cy, $month)){
		if(true == $present_month_checked_in_subscriber_field){
			$present_month_checked_in_subscriber_field = false;
		}
		continue;
	} else {
		// у подписчика отмечен один из оставшихся в текущем году месяцев
		// если это текущий месяц, то его пропускаем
		if($k_cy == $date[1]){
			$present_month_checked_in_subscriber_field = true;
			continue;
		}
		// если текущий месяц, отмечен в полях подписчика - вначале ищем первый неотмеченный месяц, с которого уже запускется стандартная схема
		if(true == $present_month_checked_in_subscriber_field){
			continue;
		} else {
			// это не текущий месяц: дата проверки - предыдущий месяц ("крайний не отмеченный месяц"). месяца следующего года не требуют проверки
			$subscriber_nearest_month = $m_cy;
			$prev_k_cy = $k_cy-1;
			$prev_k_cy = sprintf("%02d", $prev_k_cy);
			$prev_m_cy = $remaining_month_of_current_years[$prev_k_cy];
			if($prev_m_cy == 'Февраль'){
				$check_date = $date[2].'-02-19';
			} elseif($prev_m_cy == 'Декабрь'){
				$check_date = $date[2].'-12-15';
			} else {
				$check_date = $date[2].'-'.array_search($prev_m_cy, $remaining_month_of_current_years).'-21';
			}
		}		
		$contact_edit_param = array("email" => $email, "field[%CHECK_DATE%,0]" => $check_date);
		$contact_edit = $ac->api("contact/sync", $contact_edit_param);
		// echo 'дата проверки: ' . $check_date;
		break;

	}
}

// если у подписчика все месяца текущего года не отмечены - поиск с января след. года
if ($subscriber_nearest_month == '') {
	$months_of_next_year_from_first = $month_list_2;
	foreach ($months_of_next_year_from_first as $k_ny => $m_ny) {
		if(!in_array($m_ny, $month)){
			continue;
		} else {
			$subscriber_nearest_month = $m_ny;
			//  если первый отмеченный месяц - январь, то дата проверки в прошлом году
			if($m_ny == 'Январь'){
				$check_date = $date[2].'-12-21';
			} else {
				$prev_k_ny = $k_ny-1;
				$prev_k_ny = sprintf("%02d", $prev_k_ny);
				$prev_m_ny = $months_of_next_year_from_first[$prev_k_ny];
				if($prev_m_ny == 'Февраль'){
					$check_date = $next_year.'-02-26';
				} else {
					$check_date = $next_year.'-'.array_search($prev_m_ny, $months_of_next_year_from_first).'-21';
				}
			}
			$contact_edit_param = array("email" => $email, "field[%CHECK_DATE%,0]" => $check_date);
			$contact_edit = $ac->api("contact/sync", $contact_edit_param);
			// echo 'дата проверки: ' . $check_date;
			break;
		}
	}
}
