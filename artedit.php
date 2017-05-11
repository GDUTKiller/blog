<?php
require('./lib/init.php');
require('./lib/acc.php');

$yDB = new YDB();
$art_id = $_GET['art_id'];

if(!is_numeric($art_id)) {
  error('art_id must be a number!');
  exit;
}
$sql = "SELECT COUNT(*) FROM art WHERE art_id = " . $art_id;
if($yDB->getOne($sql) == 0) {
  error('the art does not exist!');
  exit;
}

if(empty($_POST)) {
  $sql = "SELECT * FROM art WHERE art_id = $art_id";
  $art = $yDB->getRow($sql);
  $sql = "SELECT * FROM cat";
  $cat = $yDB->getAll($sql);
  $sql = "SELECT tag FROM tag WHERE art_id = $art_id";
  $tag = $yDB->getAll($sql);
  $tags = '';
  foreach ($tag as $t) {
    $tags .= $t['tag'] . ',';
  }
  $tags = rtrim($tags, ',');
  include(ROOT . '/view/admin/artedit.html');
} else {
  //if the art_id is not a number
  if(!is_numeric($art_id)) {
    error("the art_id must be a number!");
    exit;
  }

  if(empty($art['title'] = trim($_POST['title']))) {
    error('title can not be empty!');
    exit;
  }

  if(!is_numeric($art['cat_id'] = $_POST['cat_id'])) {
    error('the cat_id must be a number!');
    exit;
  }
  if(empty($art['content'] = trim($_POST['content']))) {
    error('content can not be empty!');
    exit;
  }

  $sql = "SELECT COUNT(*) FROM art WHERE art_id = " . $art_id;
  if($yDB->getOne($sql) == 0) {
    error('this art dose not exist!');
    exit;
  }
  
  $art['lastup'] = time();
  $art['arttag'] = trim($_POST['tags']);
 
  if(!$yDB->exec('art', $art, 'update', 'art_id='.$art_id)) {
    error('art change fail!');
    exit;
  } else {
    $tags = $_POST['tags'];
    if(empty($tags)) {
      succ('art change success!');
    } else {
      $sql = "DELETE FROM tag WHERE art_id = " . $art_id;
      $yDB->query($sql);
      $tags = explode(",", $tags);
      $sql = "INSERT INTO tag (art_id, tag) VALUES ";
      foreach ($tags as $v) {
        $sql .= "(" . $art_id . ",'" . $v . "'),";
      }
      $sql = rtrim($sql, ',');
      if(!$yDB->query($sql)) {
        error('art edit success, but tags change fail!');
      } else {
        succ('art change success!');
      }
    }
  }
}

