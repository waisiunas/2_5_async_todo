<?php require_once('./database/connection.php'); ?>

<?php
$name = $email = '';

if (isset($_POST['submit'])) {
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$c_password = htmlspecialchars($_POST['cPassword']);


	if (empty($name)) {
		$error = 'Please provide your name!';
	} elseif (empty($email)) {
		$error = 'Please provide your email!';
	} elseif (empty($password)) {
		$error = 'Please provide your password!';
	} elseif (strlen($password) < 5) {
		$error = 'Minimum password length is 5!';
	} elseif ($password != $c_password) {
		$error = 'Password does not match!';
	} else {
		$sql = "SELECT * FROM `users` WHERE `email` = '$email'";
		$result = $conn->query($sql);

		if ($result->num_rows == 0) {
			$encrypted_password = sha1($password);
			$sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name', '$email', '$encrypted_password')";

			if ($conn->query($sql)) {
				header('Location: ./sign-in.php');
			} else {
				$error = 'Failed to register!';
			}

		} else {
			$error = 'Email already exists!';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Sign Up';
require_once('./partials/styles.php');
?>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Get started</h1>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
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
											<label class="form-label">Name</label>
											<input class="form-control form-control-lg" type="text" name="name" placeholder="Enter your name" value="<?php echo $name; ?>">
										</div>

										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>">
										</div>

										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter password" />
										</div>

										<div class="mb-3">
											<label class="form-label">Confirm Password</label>
											<input class="form-control form-control-lg" type="password" name="cPassword" placeholder="Confirm your password" />
										</div>

										<div class="text-center mt-3">
											<input type="submit" value="Sign up" class="btn btn-lg btn-primary" name="submit">
										</div>
									</form>

									Already have an account? <a href="./sign-in.php">Sign in</a>
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