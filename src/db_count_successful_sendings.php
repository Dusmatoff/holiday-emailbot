<?php
// $mysqli = new mysqli('localhost', 'kanthrv2_mail', '22danker', 'kanthrv2_mail');
$mysqli = new mysqli('10.245.222.215', 'holiday-emailbot', 'holiday-emailbot', 'holiday-emailbot');

/* проверка соединения */
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_error());
    exit();
}

$mysqli->query("CREATE TABLE IF NOT EXISTS `counting_successful_sendings` ( `n` int(2) ) ENGINE=InnoDB");

$query = "INSERT INTO counting_successful_sendings VALUES (1)";
$mysqli->query($query);

printf ("success");

/* закрытие соединения */
$mysqli->close();
