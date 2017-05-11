<?php
require('./lib/init.php');
$yDB = new YDB();
$rs = $yDB->exec('cat', array('catname' => '1234'), 'update', "catname ='123'");
var_dump($rs);

