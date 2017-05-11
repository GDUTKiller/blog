<?php

class YImage {

  private function randStr($length = 8) {
    $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
    return substr($str, 0, $length);
  }


  public function makeThumb($ori, $dw=200, $dh=200) {
    $path = dirname($ori) . '/' . $this->randStr() . '.png';

    $opic = ROOT . $ori;
    $opath = ROOT . $path;

    if(!list($sw, $sh, $type) = getimagesize($opic)) {
        return false;
    }

    $map = array(
        1 => 'imagecreatefromgif',
        2 => 'imagecreatefromjpeg',
        3 => 'imagecreatefrompng',
        6 => 'imagecreatefromwbmp',
        15=> 'imagecreatefromwbmp'
    );

    if(!isset($map[$type])) {
        return false;
    }

    $func = $map[$type];
    $big = $func($opic);
    $small = imagecreatetruecolor($dw, $dh);
    $white = imagecolorallocate($small, 255, 255, 255);
    imagefill($small, 0, 0, $white);

    $rate = min($dw/$sw, $dh/$sw);

    $rw = $rate * $sw;
    $rh = $rate * $sh;
    imagecopyresampled($small, $big, 0, 0, 0, 0, $rw, $rh, $sw, $sh);

    imagepng($small, $opath);

    imagedestroy($big);
    imagedestroy($small);

    return $path;
    
  }


}
