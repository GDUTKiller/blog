<?php
require('./lib/init.php');
require('./lib/acc.php');


$yDB = new YDB();

$sql = "SELECT art.*, cat.catname FROM art, cat WHERE art.cat_id = cat.cat_id;";

$art = $yDB->getAll($sql);

include(ROOT . '/view/admin/artlist.html');
