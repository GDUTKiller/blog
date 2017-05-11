<?php
require('./lib/init.php');
require('./lib/acc.php');

$art_id = $_GET['art_id'];
$sql = "DELETE FROM art WHERE art_id = $art_id";
$yDB = new YDB();
if(!$yDB->query($sql)) {
    error('art delete fail!');
} else {
    succ('art del success!');
    header("Location:artlist.php");
}
