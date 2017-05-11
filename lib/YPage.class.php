<?php
class YPage{
  public $size = 5;
  public $error = '';
  public $offset = 0;

  
  /**
   * count page
   * @param int $num the count
   * @param int $cnt the pages count
   * @param int $curr the cunrrent page
   * @return arr 
   */
  public function pagination($num, $cnt, $curr) {
    $max = ceil($num / $cnt);
    //count the leftmost page
    $left = max($curr - 2, 1);
    //count the rightmost page
    $right = $left + 4;
    $right = min($max, $right);

    //when the page close to right, no enough to 5 page ,examples 6 7 [8] 9
    //count the leftmost page again
    $left = $right - 4;
    $left = max($left, 1);

    $pagers = array();
    for($i = $left; $i <= $right; $i++) {
        $arr['page'] = $i;
        $pagers[$i] = http_build_query($arr);
    }

    return $pagers;
  }

}
