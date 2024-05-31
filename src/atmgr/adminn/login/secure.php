<?php
//error_reporting(0);
session_start();
if(!session_is_registered('admin_id'))
header('Location: ad_login.php?msg=invalid_session');
?>