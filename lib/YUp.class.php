<?php
class YUp {
  private $allowExt = array('jpg', 'jpeg', 'png', 'rar');
  private $maxSize = 5;  //Mb
  protected $error = '';
  

  /**
   * analyse the message of $name 
   * @param str $name the file name
   * @return arr $info
   */
  public function getInfo($name) {
    return $_FILES[$name];  
  }


  /**
   * get extension
   * @param str $name the file name
   * return str exmpales 'jpg', 'png'
   */
  public function getExt($name) { 
    return ltrim(strrchr($name, '.'), '.');
  }

  /**
   * create a directory
   * @return str dir name example '/upload/2017/0306'  | false
   */
  public function createDir() {
    //relative path '/upload/2017/0117'
    $path = '/upload/' . date('Y/md');
    //absolute path
    $abs = ROOT . $path;
    if(is_dir($abs) || mkdir($abs, 0777, true)) {
        return $path;
    } else {
        return false;
    }
  
  }

  
  /**
   * create a random file name
   * @param int $len the random file name length
   * @return str random string
   */
  public function randStr($len=8) {
    $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
    return substr($str, 0, $len);

  }

  
  /**
   * upload file
   * @param str $name 
   * @return str the upload file path , for example '/upload/2017/0306/a.jpg'
   */
  public function up($name) {
    $info = $this->getInfo($name);

    if( !$this->checkType( $this->getExt($info['name']) ) ) {
       $this->error = 'ths file`s extension is not allowed!';
       error('the file`s extension is not be allowed!');
       exit;
    }
    if( !$this->checkSize($_FILES['pic']['size']) ) {
      $this->error = 'the file`s size is too big!';
      error('this file`s size is not be allowed!');
      exit;
    }
    $des = $this->createDir() . '/' . $this->randStr() . '.' . $this->getExt($info['name']);
    if(move_uploaded_file($info['tmp_name'], ROOT.$des) ) {
      return $des;
    }
    return false;
  }


  /**
   * check the type of file, allow jpg, jpeg, png, rar, not allow rar
   * @param $ext the file`s ext
   * @return boolean
   */
  public function checkType($ext) {
    return in_array($ext, $this->allowExt);
  }
  
  /**
   * check the size of file
   * @param int $size the size of file
   * @return boolean
   */
  protected function checkSize($size) {
    return $size <= $this->maxSize * 1024 * 1024;
  }


  /**
   * get the error message
   */
  public function getError() {
    return $this->error;
  }
}
