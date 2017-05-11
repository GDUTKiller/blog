<?php
/**
* hint of success
*/

function succ($res) {
    $result = 'succ';
    require(ROOT . '/view/admin/info.html');
    exit();
}

/**
* �hint of fail
*/

function error($res) {
    $result = 'fail';
    require(ROOT . '/view/admin/info.html');
    exit();
}

/**
 * get ip
 * @return str $realip ip地址
 */
function getIp() {
    static $realip = null;
    if($realip !== null) {
        return $realip;
    }

    if(getenv('HTTP_X_FORWARDED_FOR')) {
        $realip = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_CLIENT_IP')){
        $realip = getenv('HTTP_CLIENT_IP');
    } else {
        $realip = getenv('REMOTE_ADDR');
    }

    return $realip;
}


/**
 * transfer arr
 * @param arr the arr that will be transfer , add '\'
 * @param the arr that haven been transfered 
 */
function _addslashes($arr) {
  foreach ($arr as $k => $v) {
    if(is_string($v)) {
      $arr[$k] = addslashes($v);
    } else if(is_array($v)) {
      $arr[$k] = _addslashes($v);
    }
  }

  return $arr;
}

/**
 * add salt
 * @param str $name 
 * @return str the md5 string of $salt + $name
 */
function addSalt($name) {
  $cfg = require(ROOT . '/lib/config.php');
  $salt = $cfg['salt'];
  return md5($salt . '|' . $name);
}

