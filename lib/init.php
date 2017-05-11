<?php
header('Content-type:text/html;charset=utf8');
define('ROOT', dirname(__DIR__));

require(ROOT . '/lib/func.php');
require(ROOT . '/lib/YDB.class.php');
require(ROOT . '/lib/YUp.class.php');
require(ROOT . '/lib/YImage.class.php');
require(ROOT . '/lib/YPage.class.php');

//tansfer forbidden character
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);
