<?php require_once('./database/connection.php'); ?>

<?php
session_start();
session_destroy();
header('location: ./sign-in.php');