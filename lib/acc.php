<?php

/**
 * if login
 * $return boolean 
 */
function acc() {
  if(!isset($_COOKIE['name']) || !isset($_COOKIE['ccode']) ) {
    return false;
  }

  return $_COOKIE['ccode'] === addSalt($_COOKIE['name']);
}

if(!acc()) {
  header('Location:login.php');
}
