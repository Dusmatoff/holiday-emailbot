<?php
// require_once ("includes/stdout.php");
// require_once("includes/header.php");

// if ( !isset($_POST['contact']['email']) && !isset($_POST['contact']['fields']) ){
//   exit();
// }

// $email = $_POST['contact']['email'];
// $p = $_POST['contact']['fields'];

// $board = trim($p['custom_0_1'], '||');    // Питание.
// $month = trim($p['_'], '||');      // Месяц
// $departure = trim($p['departure_city'], '||');      // Город вылета
// $night_from = trim($p['nights_from'], '||');      // Ночей, от
// $night_to = trim($p['nights_to'], '||');      // Ночей, до
// $first_line = trim($p['first_line_only'], '||');      // Отели только на первой линии
// $stars = trim($p['hotel_star'], '||');      // Звездность отеля
// $price_min = trim($p['price_from'], '||');      // Цена, от
// $price_max = trim($p['price_to'], '||');      // Цена, до
// $stop = trim($p['do_not_offer_countries'], '||');      // Не предлагать страны
// $list_id = "7"; // id списка, к сегменту которого будут привязываться все создаваемые кампании
// $segmentid = "117"; // id сегмента

// echo "OK";

// /************************************************************************************************************
//  * СОСТАВЛЕНИЕ НАЗВАНИЯ КАМПАНИИ ИЗ ДАННЫХ ПОДПИСЧИКА
//  */
// $cn_param = array();
// // дата	
// $cn_param[] = date("Y-m-d");
// // месяц
// if ($month) {
//   $month = tolat($month);
//   if (strpos($month, 'ANY') === false) {
//     $cn_param[] = 'MONTH=' . trim($month, ',');
//   } else {
//     $cn_param[] = 'MONTH=ANY';
//   }
// }
// // город вылета
// if ($departure) {
//   $departure_lat = tolat($departure);
//   $cn_param[] = 'NY_DEPARTURE=' . $departure_lat;
// }
// // количество ночей: от, до
// if ($night_from) {
//   $cn_param[] = 'NIGHTS-FROM=' . str_replace('||', ',', $night_from);
// }
// if ($night_to) {
//   $cn_param[] = 'NIGHTS-TO=' . str_replace('||', ',', $night_to);
// }
// // первая береговая линия
// if ($first_line) {
//   $first_line = tolat($first_line);
//   $cn_param[] = 'FIRST-LINE=' . $first_line;
// }
// // питание
// if ($board) {
//   $board_lat = tolat($board);
//   $cn_param[] = 'BOARD=' . $board_lat;
// }
// // звездность отеля
// if ($stars) {
//   $stars_lat = tolat($stars);
//   $cn_param[] = 'STARS=' . $stars_lat;
// }
// // цена: от, до
// if ($price_min) {
//   $cn_param[] = 'PRICE-MIN=' . str_replace('||', ',', $price_min);
// }
// if ($price_max) {
//   $cn_param[] = 'PRICE-MAX=' . str_replace('||', ',', $price_max);
// }
// // не предлагать страны
// if ($stop) {
//   $stop_lat = tolat($stop);
//   $cn_param[] = 'STOP=' . $stop_lat;
// }
// // итоговое название кампании
// $cn = 'LM_Avia_' . implode('_', $cn_param);


// /************************************************************************************************************
//  * ФОРМИРОВАНИЕ RSS ЛЕНТЫ И ТЕМЫ ПИСЬМА
//  */
// $theme_param = array('date' => '', 'price' => '', 'night' => '', 'departure' => '', 'board' => '', 'stars' => '',);
// $rss_url = 'https://www.holiday.by/callbacks/subscription/rss/v2.0/hot-tours.xml?order=price&dir=asc';
// $rss_param = array();

// // ФОРМИРОВАНИЕ RSS
// // питание: rss
// $rss_board_arr = array(
//   'Только завтрак' => '1',
//   'Все включено' => '2',
//   'Ультра все включено' => '3',
//   'Завтрак, обед и ужин' => '4',
//   'Завтрак и ужин (или Завтрак и обед)' => '5',
//   'Без питания' => '6'
// );

// if ($board && !stristr($board, '||') && array_key_exists($board, $rss_board_arr)) {
//   $rss_param[] = 'board=' . $rss_board_arr[$board];
// }
// // линия пляжа: rss
// if ($first_line && $first_line == 'да') {
//   $rss_param[] = 'beach-line=1';
// }
// // город вылета: rss
// $rss_depart_arr = array(
//   'Минск' => '1',
//   'Брест' => '2',
//   'Витебск' => '3',
//   'Гомель' => '4',
//   'Могилев' => '6',
//   'Москва' => '7',
//   'Киев' => '8',
//   'Варшава' => '17',
//   'Вильнюс' => '10',
//   'Гродно' => '5'
// );

// if ($departure && !stristr($departure, '||') && array_key_exists($departure, $rss_depart_arr)) {
//   $rss_param[] = 'departure=' . $rss_depart_arr[$departure];
// }
// // не предлагать страны: rss
// $rss_stop_arr = array(
//   'Албания' => 'Albania',
//   'Болгария' => 'Bulgaria',
//   'Греция' => 'Greece',
//   'Грузия' => 'Georgia',
//   'Египет' => 'Egypt',
//   'Израиль' => 'Israel',
//   'Индия' => 'India',
//   'Испания' => 'Spain',
//   'Италия' => 'Italy',
//   'Кипр' => 'Cyprus',
//   'Турция' => 'Turkey',
//   'Украина' => 'Ukraine',
//   'Франция' => 'France',
//   'Черногория' => 'Montenegro',
//   'Шри-Ланка' => 'Sri_Lanka',
//   'Россия' => 'Russia'
// );

// if ($stop) {
//   $stop_step1 = array_flip(explode('||', $stop));
//   $stop_step2 = array_merge($stop_step1, array_intersect_key($rss_stop_arr, $stop_step1));
//   $rss_param[] = 'exclude-countries=' . implode(',', $stop_step2);
// }
// // цена от: rss
// if ($price_min) {
//   $rss_param[] = 'price-from=' . $price_min;
// }
// // цена до: rss
// if ($price_max) {
//   $rss_param[] = 'price-to=' . $price_max;
// }
// // количество ночей от: rss
// if ($night_from) {
//   $rss_param[] = 'nights-from=' . $night_from;
// }
// // количество ночей до: rss
// if ($night_to) {
//   $rss_param[] = 'nights-to=' . $night_to;
// }
// // звездность отеля: rss
// $rss_star_array = array('Не ниже 3*' => '3-4-5', 'Не ниже 4*' => '4-5', '5*' => '5');
// if ($stars && !stristr($stars, '||') && array_key_exists($stars, $rss_star_array)) {
//   $rss_param[] = 'hotel-class=' . $rss_star_array[$stars];
// }
// // определение rss
// if ($rss_param) {
//   $rss_url = 'https://www.holiday.by/callbacks/subscription/rss/v2.0/hot-tours.xml?order=price&dir=asc&transport=1&' . implode('&', $rss_param);
// } else {
//   $rss_url = 'https://www.holiday.by/callbacks/subscription/rss/v2.0/hot-tours.xml?order=price&dir=asc&transport=1';
// }

// // ФОРМИРОВАНИЕ ТЕМЫ ПИСЬМА		
// // дата: тема
// // реальная дата
// $month_list = array(
//   'январе',
//   'феврале',
//   'марте',
//   'апреле',
//   'мае',
//   'июне',
//   'июле',
//   'августе',
//   'сентябре',
//   'октябре',
//   'ноябре',
//   'декабре'
// );

// $date = explode('.', date('d.m.Y'));
// $day = (int)$date[0];
// $mon = (int)$date[1];
// if ($day < 24) {
//   $theme_param['date'] = ' в ' . $month_list[$mon - 1];
// } elseif ($day >= 24 && $day <= 27 && $mon != '12') {
//   $theme_param['date'] = ' в ' . $month_list[$mon - 1] . '-' . $month_list[$mon];
// } elseif ($day >= 24 && $day <= 27 && $mon == '12') {
//   $theme_param['date'] = ' в ' . $month_list[$mon - 1] . '-' . $month_list[0];
// } elseif ($day >= 28 && $day <= 31 && $mon != '12') {
//   $theme_param['date'] = ' в ' . $month_list[$mon];
// } elseif ($day >= 28 && $day <= 31 && $mon == '12') {
//   $theme_param['date'] = ' в ' . $month_list[0];
// }
// // получение данных из rss
// include 'includes/simplehtml/simple_html_dom.php';
// $dom_xml = new DomDocument;
// $dom_xml->load($rss_url);
// if ($dom_xml) {
//   $mod = $dom_xml->getElementsByTagName('html');
//   if ($mod) {
//     $prices_arr = array();
//     $night_arr = array();
//     foreach ($mod as $key => $element) {
//       if ($key < '11') {
//         $html = '';
//         $html = new simple_html_dom();
//         $html->load($element->nodeValue);
//         if ($html) {
//           // цена от, до: тема (начало)
//           $prices = $html->find('.email-item-price');
//           if ($prices) {
//             foreach ($prices as $price) {
//               $num_curr = stristr($price->plaintext, 'BYN', true);
//               $prices_arr[$num_curr] = (int)str_replace(' ', '', $num_curr);
//             }
//           }
//           // количество ночей от, до: тема (начало)
//           $nights = $html->find('.email-item-day');
//           if ($nights) {
//             foreach ($nights as $night) {
//               $num_night = stristr($night->plaintext, 'ночей', true);
//               if (!$num_night) {
//                 $num_night = stristr($night->plaintext, 'ночи', true);
//                 if (!$num_night) {
//                   $num_night = stristr($night->plaintext, 'ночь', true);
//                   if (!$num_night) {
//                     continue;
//                   }
//                 }
//               }
//               $night_arr[] = (int)str_replace(' ', '', $num_night);
//             }
//           }
//           $html->clear();
//           unset($html);
//         } // end if ( $html )
//       } // end if ( $key < '11' )
//     } // end foreach ( $mod as $key => $element )
// // цена от, до: тема (продолжение)
//     if ($prices_arr) {
//       $mins = stristr(array_search(min($prices_arr), $prices_arr), ',', true);
//       $maxs = stristr(array_search(max($prices_arr), $prices_arr), ',', true);
//       $theme_param['price'] = ' от ' . $mins . ' до ' . $maxs . ' BYN';
//     } else {
//       $tag_add_param = array(
//         "email" => $email,
//         "tags" => "empty-results",
//       );
//       $tag_add = $ac->api("contact/tag_add", $tag_add_param);
//       fwrite($stdout, date("Y-m-d H:i") . " for " . $email . " rss was empty. " . $rss_url . " Message was not sent." . "\n");
//       exit();
//     }
// // количество ночей от, до: тема (продолжение)
//     if ($night_arr) {
//       $min_night = min($night_arr);
//       $max_night = max($night_arr);
//       $word_end = '';
//       if ($max_night == 1) {
//         $word_end = ' ночь';
//       } elseif ($max_night == 2 || $max_night == 3) {
//         $word_end = ' ночи';
//       } else {
//         $word_end = ' ночей';
//       }
//       if ($min_night == $max_night) {
//         $theme_param['night'] = ' на ' . $max_night . $word_end;
//       } else {
//         $theme_param['night'] = ' на ' . $min_night . '-' . $max_night . $word_end;
//       }
//     }
//   } // end if ( $mod )
// } // end if ( $dom_xml )

// // город вылета: тема
// $sity_list = array(
//   'Минск' => 'Минска',
//   'Брест' => 'Бреста',
//   'Витебск' => 'Витебска',
//   'Гомель' => 'Гомеля',
//   'Гродно' => 'Гродно',
//   'Могилев' => 'Могилева',
//   'Москва' => 'Москвы',
//   'Киев' => 'Киева',
//   'Вильнюс' => 'Вильнюса',
//   'Варшава' => 'Варшавы'
// );

// if ($departure && !stristr($departure, '||') && array_key_exists($departure, $sity_list)) {
//   $theme_param['departure'] = ' из ' . $sity_list[$departure];
// }
// // питание: тема
// $food_list = array(
//   'Только завтрак' => 'завтраки',
//   'Завтрак и ужин (или Завтрак и обед)' => 'двухразовое',
//   'Завтрак, обед и ужин' => 'трехразовое'
// );

// if ($board && !stristr($board, '||') && array_key_exists($board, $food_list)) {
//   if ($board == 'Все включено' || $board == 'Ультра все включено') {
//     $theme_param['board'] = '. ' . $board;
//   } else {
//     $theme_param['board'] = '. Питание: ' . $food_list[$board];
//   }
// }
// // линия пляжа: тема
// if ($first_line && $first_line = 'да') {
//   $theme_param['stars'] = ', только первая линия';
// }

// $theme = 'Горящие туры ' . $theme_param['date'] . $theme_param['price'] . $theme_param['departure'] . $theme_param['night'] . $theme_param['board'] . $theme_param['stars'];


// /************************************************************************************************************
//  * ПРОВЕРКА НАЛИЧИЯ КАМПАНИИ ПОД КРИТЕРИИ ПОДПИСЧИКА И ЕЕ ОТПРАВКА
//  */
// // фильтр списка кампаний по названию, определенному выше
// $compaign = $ac->api("campaign/list?ids=500,501,502,503,504,505,506,507,508,509,510,511,512,513,514,515,516,517,518,519,520,521,522,523,524,525,526,527,528,529,530,531,532,533,534,535,536,537,538,539,540,541,542,543,544,545,546,547,548,549,550,551,552,553,554,555,556,557,558,559,560,561,562,563,564,565,566,567,568,569,570,571,572,573,574,575,576,577,578,579,580,581,582,583,584,585,586,587,588,589,590,591,592,593,594,595,596,597,598,599,600,601,602,603,604,605,606,607,608,609,610,611,612,613,614,615,616,617,618,619,620,621,622,623,624,625,626,627,628,629,630,631,632,633,634,635,636,637,638,639,640,641,642,643,644,645,646,647,648,649,650,651,652,653,654,655,656,657,658,659,660,661,662,663,664,665,666,667,668,669,670,671,672,673,674,675,676,677,678,679,680,681,682,683,684,685,686,687,688,689,690,691,692,693,694,695,696,697,698,699,700,701,702,703,704,705,706,707,708,709,710,711,712,713,714,715,716,717,718,719,720,721,722,723,724,725,726,727,728,729,730,731,732,733,734,735,736,737,738,739,740,741,742,743,744,745,746,747,748,749,750,751,752,753,754,755,756,757,758,759,760,761,762,763,764,765,766,767,768,769,770,771,772,773,774,775,776,777,778,779,780,781,782,783,784,785,786,787,788,789,790,791,792,793,794,795,796,797,798,799,800,801,802,803,804,805,806,807,808,809,810,811,812,813,814,815,816,817,818,819,820,821,822,823,824,825,826,827,828,829,830,831,832,833,834,835,836,837,838,839,840,841,842,843,844,845,846,847,848,849,850,851,852,853,854,855,856,857,858,859,860,861,862,863,864,865,866,867,868,869,870,871,872,873,874,875,876,877,878,879,880,881,882,883,884,885,886,887,888,889,890,891,892,893,894,895,896,897,898,899,900,901,902,903,904,905,906,907,908,909,910,911,912,913,914,915,916,917,918,919,920,921,922,923,924,925,926,927,928,929,930,931,932,933,934,935,936,937,938,939,940,941,942,943,944,945,946,947,948,949,950,951,952,953,954,955,956,957,958,959,960,961,962,963,964,965,966,967,968,969,970,971,972,973,974,975,976,977,978,979,980,981,982,983,984,985,986,987,988,989,990,991,992,993,994,995,996,997,998,999,1000,1001,1002,1003,1004,1005,1006,1007,1008,1009,1010,1011,1012,1013,1014,1015,1016,1017,1018,1019,1020,1021,1022,1023,1024,1025,1026,1027,1028,1029,1030,1031,1032,1033,1034,1035,1036,1037,1038,1039,1040,1041,1042,1043,1044,1045,1046,1047,1048,1049,1050,1051,1052,1053,1054,1055,1056,1057,1058,1059,1060,1061,1062,1063,1064,1065,1066,1067,1068,1069,1070,1071,1072,1073,1074,1075,1076,1077,1078,1079,1080,1081,1082,1083,1084,1085,1086,1087,1088,1089,1090,1091,1092,1093,1094,1095,1096,1097,1098,1099,1100,1101,1102,1103,1104,1105,1106,1107,1108,1109,1110,1111,1112,1113,1114,1115,1116,1117,1118,1119,1120,1121,1122,1123,1124,1125,1126,1127,1128,1129,1130,1131,1132,1133,1134,1135,1136,1137,1138,1139,1140,1141,1142,1143,1144,1145,1146,1147,1148,1149,1150,1151,1152,1153,1154,1155,1156,1157,1158,1159,1160,1161,1162,1163,1164,1165,1166,1167,1168,1169,1170,1171,1172,1173,1174,1175,1176,1177,1178,1179,1180,1181,1182,1183,1184,1185,1186,1187,1188,1189,1190,1191,1192,1193,1194,1195,1196,1197,1198,1199,1200,1201,1202,1203,1204,1205,1206,1207,1208,1209,1210,1211,1212,1213,1214,1215,1216,1217,1218,1219,1220,1221,1222,1223,1224,1225,1226,1227,1228,1229,1230,1231,1232,1233,1234,1235,1236,1237,1238,1239,1240,1241,1242,1243,1244,1245,1246,1247,1248,1249,1250,1251,1252,1253,1254,1255,1256,1257,1258,1259,1260,1261,1262,1263,1264,1265,1266,1267,1268,1269,1270,1271,1272,1273,1274,1275,1276,1277,1278,1279,1280,1281,1282,1283,1284,1285,1286,1287,1288,1289,1290,1291,1292,1293,1294,1295,1296,1297,1298,1299,1300,1301,1302,1303,1304,1305,1306,1307,1308,1309,1310,1311,1312,1313,1314,1315,1316,1317,1318,1319,1320,1321,1322,1323,1324,1325,1326,1327,1328,1329,1330,1331,1332,1333,1334,1335,1336,1337,1338,1339,1340,1341,1342,1343,1344,1345,1346,1347,1348,1349,1350,1351,1352,1353,1354,1355,1356,1357,1358,1359,1360,1361,1362,1363,1364,1365,1366,1367,1368,1369,1370,1371,1372,1373,1374,1375,1376,1377,1378,1379,1380,1381,1382,1383,1384,1385,1386,1387,1388,1389,1390,1391,1392,1393,1394,1395,1396,1397,1398,1399,1400,1401,1402,1403,1404,1405,1406,1407,1408,1409,1410,1411,1412,1413,1414,1415,1416,1417,1418,1419,1420,1421,1422,1423,1424,1425,1426,1427,1428,1429,1430,1431,1432,1433,1434,1435,1436,1437,1438,1439,1440,1441,1442,1443,1444,1445,1446,1447,1448,1449,1450,1451,1452,1453,1454,1455,1456,1457,1458,1459,1460,1461,1462,1463,1464,1465,1466,1467,1468,1469,1470,1471,1472,1473,1474,1475,1476,1477,1478,1479,1480,1481,1482,1483,1484,1485,1486,1487,1488,1489,1490,1491,1492,1493,1494,1495,1496,1497,1498,1499,1500&filters[name]=" . $cn);
// // создание сообщения
// if (file_exists("mail_template.php")) {
//   $template = include("mail_template.php");
// } else {
//   fwrite($stdout, date("Y-m-d H:i") . " error message template for NEW campaign " . $cn . ": not found" . "\n");
//   exit();
// }
// $message = array(
//   "format" => "mime",
//   "subject" => $theme,
//   "fromemail" => "contact@holiday.by",
//   "fromname" => "holiday.by",
//   "html" => $template,
//   "p[{$list_id}]" => $list_id,
// );
// $message_add = $ac->api("message/add", $message);
// if (!(int)$message_add->success) {
//   fwrite($stdout, date("Y-m-d H:i") . " error creating message for " . $cn . ": " . $message_add->error . "\n");
//   exit();
// } else {
//   $message_id = (int)$message_add->id;
// }
// // если кампания указанным названием есть - отправление копии на email подписчика
// if ($compaign->result_code == '1') {
//   $campaign_send = $ac->api("campaign/send?email=" . $email . "&campaignid=" . $compaign->{0}->id . "&messageid=0&type=mime&action=copy");
//   if ((int)$campaign_send->success) {
//     fwrite($stdout, date("Y-m-d H:i") . " success sending campaign " . $cn . ", created BEFORE, to " . $email . "\n");
//     exit();
//   } else {
//     fwrite($stdout, date("Y-m-d H:i") . " error sending campaign " . $cn . ", created BEFORE: " . $campaign_send->error . "\n");
//     exit();
//   }
// } // если кампании нет - создание кампании на сегмент спец. списка и отправление копии на email подписчика
// elseif ($compaign->result_code == '0') {
// // создание компании
//   $campaign = array(
//     "type" => "single",
//     "name" => $cn,
//     "segmentid" => $segmentid,
//     "status" => 1,
//     "public" => 1,
//     "tracklinks" => "all",
//     "trackreads" => 1,
//     "htmlunsub" => 1,
//     "p[{$list_id}]" => $list_id,
//     "m[{$message_id}]" => 100,
//   );
//   $campaign_create = $ac->api("campaign/create", $campaign);
// // отправка созданной кампании
//   if ($campaign_create->result_code == '1') {
//     $new_campaign_send = $ac->api("campaign/send?email=" . $email . "&campaignid=" . $campaign_create->id . "&messageid=0&type=mime&action=copy");
//     if (!(int)$new_campaign_send->success) {
//       fwrite($stdout, date("Y-m-d H:i") . " error sending NEW campaign " . $cn . ": " . $new_campaign_send->error . "\n");
//     } else {
//       fwrite($stdout, date("Y-m-d H:i") . " success sending NEW campaign " . $cn . " to " . $email . "\n");
//     }
//   }
// } // elseif ( $compaign->result_code == '0' )
// else {
//   fwrite($stdout, date("Y-m-d H:i") . " error when found or/and create campaign" . "\n");
// }


// function tolat($str)
// {
//   $tr = array(
//     'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D',
//     'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
//     'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N',
//     'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
//     'У' => 'U', 'Ф' => 'F', 'Х' => 'KH', 'Ц' => 'TS', 'Ч' => 'CH',
//     'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
//     'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'A', 'б' => 'B',
//     'в' => 'V', 'г' => 'G', 'д' => 'D', 'е' => 'E', 'ё' => 'YO',
//     'ж' => 'ZH', 'з' => 'Z', 'и' => 'I', 'й' => 'J', 'к' => 'K',
//     'л' => 'L', 'м' => 'M', 'н' => 'N', 'о' => 'O', 'п' => 'P',
//     'р' => 'R', 'с' => 'S', 'т' => 'T', 'у' => 'U', 'ф' => 'F',
//     'х' => 'KH', 'ц' => 'TS', 'ч' => 'CH', 'ш' => 'SH', 'щ' => 'SCH',
//     'ъ' => '', 'ы' => 'Y', 'ь' => '', 'э' => 'E', 'ю' => 'YU',
//     'я' => 'YA', ' ' => '-', '.' => '', ',' => '', '/' => '-',
//     '—' => '', '–' => '-', '||' => ',',
//     'Любой месяц' => 'ANY', 'Январь' => 'JAN', 'Февраль' => 'FEB', 'Март' => 'MAR', 'Апрель' => 'APR', 'Май' => 'MAY',
//     'Июнь' => 'JUNE', 'Июль' => 'JULY', 'Август' => 'AUG', 'Сентябрь' => 'SEPT', 'Октябрь' => 'OCT',
//     'Ноябрь' => 'NOV', 'Декабрь' => 'DEC', 'Новый год' => 'NEWYEAR',
//     'да' => 'Y',
//     'Все равно' => 'ANY', 'Не ниже 3*' => '3', 'Не ниже 4*' => '4', '5*' => '5',
//     'Любое' => 'ANY', 'Без питания' => 'ОВ', 'Только завтрак' => 'BВ', 'Завтрак и ужин (или Завтрак и обед)' => 'HВ',
//     'Завтрак, обед и ужин' => 'FВ', 'Все включено' => 'Al', 'Ультра все включено' => 'UAI',

//   );
//   return strtr($str, $tr);
// }
