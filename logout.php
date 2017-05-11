<?php
require('./lib/init.php');

setcookie('name', null, 0);
setcookie('ccode', null, 0);


header('Location:login.php');
