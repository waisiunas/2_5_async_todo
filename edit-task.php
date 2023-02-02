<?php require_once('./database/connection.php'); ?>

<?php
session_start();
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header('location: ./sign-in.php');
}

$form_data = file_get_contents("php://input");
$_POST = json_decode($form_data, true);

if (isset($_POST['submit'])) {
    $task = htmlspecialchars($_POST['task']);
    $id = htmlspecialchars($_POST['id']);

    if (empty($task)) {
        echo json_encode(['taskError' => 'Please provide the task!']);
    } else {
        $sql = "UPDATE `tasks` SET `task_body` = '$task' WHERE `id` = $id";
        if ($conn->query($sql)) {
            echo json_encode(['success' => 'Magic has been spelled']);
        } else {
            echo json_encode(['error' => 'Magic has failed to spell']);
        }
    }
}
