<?php
require('./lib/init.php');
require('./lib/acc.php');
if(empty($_POST))  {
  include(ROOT .  '/view/admin/catadd.html');
} else {
  $cat['catname'] = trim($_POST['catname']);
  
  if(empty($cat['catname'])) {
    error('catname can not be empty');    
    exit;
  } 
  $sql = "SELECT COUNT(*) FROM cat WHERE catname = '$cat[catname]'";
  
  $yDB = new YDB();

  if($yDB->getOne($sql) != 0) {
    error('this cat areadly exists!');
    exit;
  }

  if(!$yDB->exec('cat', $cat)) {
    error('cat insert fail!');
   
  } else {
    succ('cat insert success!');
 
  }
}
?>
