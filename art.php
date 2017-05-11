<?php

require('./lib/init.php');

if(!isset($_GET['art_id']) || !is_numeric($_GET['art_id'])) {
  header('Location:index.php');
  exit;
}


$art_id = $_GET['art_id'];
$sql = "SELECT title, content, pubtime, catname, comm, pic, thumb FROM art LEFT JOIN cat ON art.cat_id = cat.cat_id WHERE art_id = " . $art_id;

$yDB = new YDB();

$art = $yDB->getRow($sql);

if(empty($art)) {
  header('Location:index.php');
  exit;
}

$sql = 'SELECT * FROM cat';

$cat = $yDB->getAll($sql);


if(!empty($_POST)) {
  $comm = array();
  $comm['art_id'] = $art_id;
  $comm['nick'] = $_POST['nick'];
  $comm['content'] = $_POST['content'];
  $comm['email'] = $_POST['email'];
  $comm['pubtime'] = time();

  $comm['ip'] = sprintf('%u', ip2long(getIp()));
  $rs = $yDB->exec('comment', $comm);

  $sql = "UPDATE art SET comm = comm + 1 WHERE art_id = " . $art_id;
  $yDB->query($sql);
  $ref = $_SERVER['HTTP_REFERER'];
  header("Location:" . $ref);
}

$sql = "SELECT * FROM comment WHERE art_id = " . $art_id;
$comment = $yDB->getAll($sql);

include(ROOT . '/view/front/art.html');
