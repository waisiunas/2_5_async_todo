<?php
session_start();

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
} else {
    header('location: ./sign-in.php');
}

$sql = "SELECT * FROM `users` WHERE `id` = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

?>
<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">


            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <span class="text-dark"><?php echo $user['name']; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">

                    <a class="dropdown-item" href="./sign-out.php">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>