<?php
$mysqli = new mysqli('kanthrv2.beget.tech', 'kanthrv2_mail', '22danker', 'kanthrv2_mail');
$num_rows = '';

/* проверка соединения */
if (mysqli_connect_errno()) {
    printf("Error: %s\n", mysqli_connect_error());
    exit();
}

if ($result = $mysqli->query("SELECT n FROM counting_successful_sendings")) {
    $num_rows = $result->num_rows;

    /* очищаем результирующий набор */
    $result->close();
}

/* закрытие соединения */
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-153173820-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-153173820-1', {
			'custom_map': {
				'dimension3': 'name_sum',
				'metric3': 'mails_sum'
			}
		});
	</script>
</head>
<body>
	<script>
		gtag('event', 'mails_successful_sendings', {
			'name_sum': 'total',
			'mails_sum': <?php echo $num_rows; ?>
		});
	</script>
</body>
</html>
