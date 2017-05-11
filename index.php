<meta charset="utf8">
<?php
require('./lib/init.php');
$yDB = new YDB();

if(isset($_GET['cat_id'])) {
    $where = ' and art.cat_id = ' . $_GET['cat_id'];
} else {
    $where = '';
}

$sql = "SELECT COUNT(*) FROM art WHERE 1" . $where;
$num = $yDB->getOne($sql);
$cnt = 3;  // show how many article in one page
$curr = isset($_GET['page']) ? $_GET['page'] : 1;

$yPage = new YPage();
$pagers = $yPage->pagination($num, $cnt, $curr);

$sql = "SELECT art_id, art.cat_id, user_id, nick, pubtime, title, pic, content, cat.catname, comm, arttag, thumb FROM art LEFT JOIN cat ON art.cat_id = cat.cat_id WHERE 1 " . $where . " ORDER BY art_id DESC LIMIT " .($curr - 1)*$cnt . "," . $cnt;
$art = $yDB->getAll($sql);

$sql = "SELECT * FROM cat";
$cat = $yDB->getAll($sql);

include("./view/front/index.html");
