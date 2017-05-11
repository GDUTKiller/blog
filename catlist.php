<?php
require('./lib/init.php');
require('./lib/acc.php');

$sql = "SELECT * FROM cat";

$yDB = new YDB();


$cat = $yDB->getAll($sql);

require(ROOT . '/view/admin/catlist.html');
