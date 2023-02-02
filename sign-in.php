<?php require_once('./database/connection.php'); ?>

<?php
session_start();
$email = '';

if (isset($_POST['submit'])) {
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);

	if (empty($email)) {
		$error = 'Please provide your email!';
	} elseif (empty($password)) {
		$error = 'Please provide your password!';
	} else {
		$encrypted_password = sha1($password);
		$sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$encrypted_password'";
		$result = $conn->query($sql);

		if ($result->num_rows == 1) {
			$user = $result->fetch_assoc();
			$_SESSION['user_id'] = $user['id'];
			header('location: ./index.php');
		} else {
			$error = 'Invalid Combination!';
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Sign In';
require_once('./partials/styles.php');
?>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back, Magician</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">

									</div>
									<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
										<div class="mb-3">
											<?php
											if (isset($error) && !empty($error)) { ?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert">
													<?php echo $error; ?>
													<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
												</div>
											<?php
											}
											?>
										</div>

										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" value="<?php echo $email ?>">
										</div>

										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />

										</div>

										<div class="text-center mt-3">
											<input type="submit" value="Sign in" class="btn btn-lg btn-primary" name="submit">
										</div>
									</form>
									Don't have an account? <a href="./sign-up.php">Sign up</a>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<?php require_once('./partials/scripts.php') ?>

</body>

</html>