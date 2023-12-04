<?php
// if(imaxgetcookie('userslno'); == false) { $url = '../index.php'; header("Location:".$url); }
// echo(imaxgetcookie('userslno'););
?>


<?php
if (!isset($_COOKIE['userslno'])) {
    $url = '../index.php';
    header("Location: " . $url);
    exit(); 
}

echo $_COOKIE['userslno']; 
?>
