<?php
require('./lib/init.php');
require('./lib/acc.php');

if(empty($_GET)) {
  error('comment_id is empty!');
  exit;
}

if(!is_numeric($comment_id = $_GET['comment_id'])) {
  error('comment_id muse be a number!');
  exit;
}

$yDB = new YDB();

$sql = 'SELECT COUNT(*) FROM comment WHERE comment_id = ' . $comment_id;

if($yDB->getOne($sql) == 0) {
  error('this comment does not exist!');
  exit;
}

//get art_id
$sql = 'SELECT art_id FROM comment WHERE comment_id = ' . $comment_id;
$art_id = $yDB->getOne($sql);


$sql = 'DELETE FROM comment WHERE comment_id = ' . $comment_id;

if(!$yDB->query($sql)) {
  error('delete comment fail!');
  exit;
}


//make comm -1 
$sql = 'UPDATE art SET comm = comm - 1 art_id = ' . $art_id;
$yDB->query($sql);
  
//return the last page
$ref = $_SERVER['HTTP_REFERER'];
  
header("Location: $ref");

