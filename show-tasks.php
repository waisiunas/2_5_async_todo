<?php require_once('./database/connection.php'); ?>

<?php
session_start();
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: ./sign-in.php');
}


$sql = "SELECT * FROM `tasks` WHERE `user_id` = $user_id";
$result = $conn->query($sql);
$tasks = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($tasks);
