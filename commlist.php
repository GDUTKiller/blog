<?php
require('./lib/init.php');
require('./lib/acc.php');
$yDB = new YDB();

if(empty($_GET)) {
  error('art_id does not set!');
  exit;
}

if(!is_numeric($art_id = $_GET['art_id'])) {
  error('art_id must be a number!');
  exit;
}
$sql = "SELECT * FROM comment WHERE art_id = $art_id ORDER BY comment_id DESC";
$comm = $yDB->getAll($sql);
include(ROOT . '/view/admin/commlist.html');
