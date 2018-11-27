<?
header('Content-Type: application/json');

@session_start();

require('inc/autoload.php'); //автозагрузка классов
require('../inc/db.php'); //коннектимся к базе
require('../inc/utils.php'); //разные полезные функции
require('../inc/tree.php'); //работа с деревом
require('../inc/advanced/advanced.php'); //"навороты" к сайту

require('special.php'); //функции специально для админки
require('phpzip.php'); //класс для архивирования файла/каталога

require('../inc/special.php'); //функции специально для данной системы

?>