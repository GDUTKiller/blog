<?php
require('./lib/init.php');
require('./lib/acc.php');

$yDB = new YDB();

$sql = "SELECT * FROM cat";

$cat = $yDB->getAll($sql);

if(empty($_POST)) {
  include(ROOT . '/view/admin/artadd.html');

} else {
  $art['title'] = trim($_POST['title']);
  if(empty($art['title'])) {
    error('title can not be empty!');
    exit;
  }
  
  $art['cat_id'] = $_POST['cat_id'];
  if(!is_numeric($art['cat_id'])) {
    error('cat_id must be a number!');
    exit;
  }
  
  $art['content'] = trim($_POST['content']);
  if(empty($art['content'])) {
    error('content can not be empty!');
    exit;
  }

  $art['pubtime'] = time();

  if(!empty($_FILES) && $_FILES['pic']['error'] == 0) {
   $yUp = new YUp();
   $art['pic'] = $yUp->up('pic');
   
   $yImage = new YImage();
   $art['thumb'] = $yImage->makeThumb($art['pic']);
  }  

  if(!$yDB->exec('art', $art)) {
    error('art public fail!');
    exit;
  } else {
    $art_id = $yDB->getLastId();
    //make cat num+1
    $sql = "UPDATE cat SET num = num + 1 WHERE cat_id = " . $art['cat_id'];
    $yDB->query($sql);

    $tag = trim($_POST['tag']);
    if(empty($tag)) {
      succ('art public success!');
    } else {
      
      //make string tag to array
      $tag = explode(',', $tag);
      $sql = "INSERT INTO tag (art_id, tag) VALUES";
      foreach ($tag as $v) {
        $sql .= '(' . $art_id . ',"' . $v . '"),';
      }
      $sql = rtrim($sql, ',');
     
      if(!$yDB->query($sql)) {
        $sql = "DELETE FROM art WHERE art_id = " . $art_id;
        $yDB->query($sql);
        error('art public fail!');
      } else {
        succ('art public success!');
      }
    }
  }
}
