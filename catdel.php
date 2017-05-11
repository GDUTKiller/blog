<?php
require('./lib/init.php');
require('./lib/acc.php');

$cat_id = $_GET['cat_id'];

if(!is_numeric($cat_id)) {
  error('the catid muse be number');
  exit;
}

$sql = "SELECT COUNT(*) FROM cat WHERE cat_id = " . $cat_id;

$yDB = new YDB();

if($yDB->getOne($sql) == 0) {
  error('this cat does not exist!');
  exit;
}

$sql = "SELECT COUNT(*) FROM art WHERE cat_id = " . $cat_id;

if($yDB->getOne($sql) != 0) {
  error('this cat has art so it cat not be deleted!');
  exit;
}

$sql = "DELETE FROM cat WHERE cat_id = " . $cat_id;

if(!$yDB->query($sql)) {
  error('delete fail!');
  exit;
} else {
  succ('delete success!');
}

