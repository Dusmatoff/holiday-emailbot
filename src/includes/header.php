<?php
header("Content-Type: text/html; charset=utf-8");
require_once("includes/api/ActiveCampaign.class.php");
$ac = new ActiveCampaign("https://holidayby.api-us1.com", "e3ab0c56fb0b7c7be13aad370a7aa9c3efbfcecbe6400a49c1aae2f8d7f4864185a6536f");
// Проверка прав
if (!(int)$ac->credentials_test()) {
  exit();
}
$ac->version(1);