<?php
//error_reporting(0);
session_start();
if(!session_is_registered('member_ID'))
header('Location: login/index.php');
?>