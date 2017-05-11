<?php
require('./lib/init.php');
require('./lib/acc.php');

$cat_id = $_GET['cat_id'];
if(!is_numeric($cat_id)) {
  error('cat_id muse be number');
  exit;
}

$sql = "SELECT COUNT(*) FROM cat WHERE cat_id = " . $cat_id;

$yDB = new YDB();

if($yDB->getOne($sql) == 0) {
  error('this cat does not exist!');
  exit;
}

$sql = "SELECT catname FROM cat WHERE cat_id = " . $cat_id;
$cat = $yDB->getRow($sql);
if(empty($_POST)) {
  require(ROOT . '/view/admin/catedit.html');
} else {
  if($cat['catname'] == $_POST['catname']) {
    error('the catname must be change!');
    exit;
  }
  $sql = "UPDATE cat SET catname = '$_POST[catname]' WHERE cat_id = $cat_id"; 
  if(!$yDB->query($sql)) {
    error('cat edit fail!');
    exit;
  } else {
    succ('cat edit success!');
  }

}
