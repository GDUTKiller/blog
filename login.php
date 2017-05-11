<?php
require('./lib/init.php');

if(empty($_POST)) {
  include(ROOT . '/view/front/login.html');
} else {
  $name = trim($_POST['name']);
  if(empty($name)) {
    error('please type user name');
    exit;
  }
  $password = trim($_POST['password']);
  if(empty($password)) {
    error('please type user password');
    exit;
  }
  $password = trim($_POST['password']);
  $sql = "SELECT  * FROM user WHERE name = '" . $name . "'";
  $yDB = new YDB();
  $user = $yDB->getRow($sql);
  if(empty($user)) {
    error('the user does not exist!');
    exit;
  } else if(md5($user['salt'] . $password) !== $user['password']) {
    error('password is not correct!');
    exit;
  } else {
    setcookie('name', $user['name'], time()+3600*24*30);
    setcookie('ccode',addSalt($user['name']), time()+3600*24*30);
    header("Location:index.php");
  }
}
