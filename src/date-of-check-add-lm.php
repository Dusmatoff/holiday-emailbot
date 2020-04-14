<?php
require_once("includes/header.php");

if ( !isset($_POST['contact']['email']) && !isset($_POST['contact']['fields']) ){
  exit();
}

$email = $_POST['contact']['email'];
// $id = $_POST['contact']['id'];
$p = $_POST['contact']['fields'];
$month = explode('||', trim($p['_'], '||'));
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

$date = explode('.', date('d.m.Y'));

$keys = array_keys($month_list_2);
$now = (array_search($date[1], $keys));
$remaining_month_of_current_years = array_slice($month_list_2, $now, '13', true);
$remaining_month_of_current_years['13'] = 'Новый год';
$key_remaining_month_of_current_years = array_keys($remaining_month_of_current_years);
$subscriber_nearest_month = '';
$check_date = '';
$next_year = $date[2]+1;
$new_year_is_checked_and_need_check_verify_january_is_checked = false;
// когда найден первый месяц отмеченный у подписчика = true. условие: месяц настоящей текущей даты изначально не был отмечен у подписчика
$found_first_month_checked_by_subscriber = false;
// если у подписчика отмечены все 12 месяцев - очистка даты проверки
if(array_values($month_list_2) == array_intersect(array_values($month_list_2), $month)) {
	$contact_edit_param = array("email" => $email, "field[%CHECK_DATE%,0]" => '');
	$contact_edit = $ac->api("contact/sync", $contact_edit_param);
	// echo 'отмечены все 12 месяцев - дата проверки очищена';
	exit();
}
// последний, из отмеченных у подписчика, месяц (из оставшихся месяцев текущего года) ("крайний отмеченный месяц")
foreach ($remaining_month_of_current_years as $k_cy => $m_cy) {
	if(in_array($m_cy, $month)){
		if( $m_cy != 'Новый год' ){
			// определен первый отмеченный у подписчика месяц * (см. комментарий ниже)
			if($date[1] = $k_cy){
				$found_first_month_checked_by_subscriber = true;
				continue;
			} else {
				continue;
			}
		} else {
			$new_year_is_checked_and_need_check_verify_january_is_checked = true;
		}
	} else {
		// * у подписчика не указан ПЕРВЫЙ месяц, из списка оставшихся в этом году месяцев (т.е. вначале идет поиск первого ОТМЕЧЕННОГО у подписчика месяца (if(in_array($m_cy, $month)) == true), потом уже последнего отмеченного)
		if($date[1] = $k_cy && $found_first_month_checked_by_subscriber == false){
			continue;
		} else {
			if( $m_cy == 'Новый год' && $found_first_month_checked_by_subscriber == false){
				continue;
			} else {
				// у подписчика указан первый месяц, из списка оставшихся в этом году месяцев, а следующий - нет, следовательно "крайний месяц" = первый месяц, из списка оставшихся в этом году месяцев
				$prev_k_cy = $k_cy-1;
				$prev_k_cy = sprintf("%02d", $prev_k_cy);
				$prev_m_cy = $remaining_month_of_current_years[$prev_k_cy];
				$subscriber_nearest_month = $prev_m_cy;
				if($prev_m_cy == 'Февраль'){
					$check_date = $date[2].'-02-26';
				} else {
					$check_date = $date[2].'-'.array_search($prev_m_cy, $remaining_month_of_current_years).'-28';
				}
				$contact_edit_param = array("email" => $email, "field[%CHECK_DATE%,0]" => $check_date);
				$contact_edit = $ac->api("contact/sync", $contact_edit_param);
				// echo 'дата проверки: ' . $check_date;
				break;
			}
			
		}		
	}
}

// если у подписчика все месяца текущего года отмечены - поиск с января след. года ("крайний отмеченный месяц")
if ($subscriber_nearest_month == '') {
	$months_of_next_year_from_first = $month_list_2;
	if(in_array('Январь', $month)){
		foreach ($months_of_next_year_from_first as $k_ny => $m_ny) {
			if(!in_array($m_ny, $month)){
				$prev_k_ny = $k_ny-1;
				$prev_k_ny = sprintf("%02d", $prev_k_ny);
				$prev_k_ny = $months_of_next_year_from_first[$prev_k_ny];
				$subscriber_nearest_month = $prev_k_ny;

				if($prev_k_ny == 'Февраль'){
					$check_date = $next_year.'-02-26';
				} else {
					$check_date = $next_year.'-'.array_search($prev_k_ny, $months_of_next_year_from_first).'-28';
				}
				$contact_edit_param = array("email" => $email, "field[%CHECK_DATE%,0]" => $check_date);
				$contact_edit = $ac->api("contact/sync", $contact_edit_param);
				// echo 'дата проверки: ' . $check_date;
				break;
			}
		}
	} elseif ($new_year_is_checked_and_need_check_verify_january_is_checked && !in_array('Январь', $month)){
		$check_date = $next_year.'-01-01';
		$contact_edit_param = array("email" => $email, "field[%CHECK_DATE%,0]" => $check_date);
		$contact_edit = $ac->api("contact/sync", $contact_edit_param);
		// echo 'дата проверки: ' . $check_date;
	} else {
		// тег LM при таком варианте удаляется, т.е. выполняется другой скрипт	
	}
}
