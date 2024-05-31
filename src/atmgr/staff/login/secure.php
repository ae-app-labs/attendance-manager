<?php
//error_reporting(0);
session_start();
if(!session_is_registered('staff_id'))
header('Location: ../index.php?msg=invalid_session');
?>