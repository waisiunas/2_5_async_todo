<?php require_once('./database/connection.php'); ?>

<!DOCTYPE html>
<html lang="en">

<?php
$title = 'Tasks';
require_once('./partials/styles.php');
?>

<body>
	<div class="wrapper">

		<?php require_once('./partials/side_navbar.php') ?>

		<div class="main">

			<?php require_once('./partials/top_navbar.php') ?>

			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Tasks</h1>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<h3 class="text-center">Add Task</h3>
									<div id="error"></div>
									<form action="" id="add-form">
										<div class="row">
											<div class="col-md-10">
												<input type="text" class="form-control" name="task-input" id="task-input" placeholder="Please enter the task!">
											</div>
											<div class="col-md-2">
												<input type="submit" value="Add" class="btn btn-primary">
											</div>
										</div>
									</form>
								</div>

								<div class="card-body">
									<div id="tasks">
										<!-- <div class="row mb-2">
											<div class="col-md-9">
												<input type="text" class="form-control" id="task-" value="Database Value" placeholder="Please enter the task!" readonly>
											</div>
											<div class="col">
												<button class="btn btn-info" id="edit-" onclick="editTask(1)">Edit</button>
											</div>
											<div class="col">
												<button class="btn btn-danger" id="delete-" onclick="editTask(1)">Delete</button>
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">

							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<?php require_once('./partials/scripts.php') ?>

	<script>
		function alertMsg(cls, msg) {
			return `<div class="alert alert-${cls} alert-dismissible fade show" role="alert">${msg}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
		}

		const addFormElement = document.getElementById('add-form');

		addFormElement.addEventListener('submit', function(e) {
			e.preventDefault();

			const taskElement = document.getElementById('task-input');

			const taskValue = taskElement.value;

			taskElement.classList.remove('is-invalid');
			error.innerHTML = '';

			if (taskValue == "" || taskValue === undefined) {
				taskElement.classList.add('is-invalid');
				let alert = alertMsg('danger', 'Please provide the task!');
				error.innerHTML = alert;
			} else {
				const data = {
					task: taskValue,
					submit: 1
				}

				fetch('./add-task.php', {
						method: 'POST',
						body: JSON.stringify(data),
						headers: {
							'Content-Type': 'application.json'
						}
					})
					.then(function(response) {
						return response.json();
					})
					.then(function(result) {
						if (result.taskError) {
							taskElement.classList.add('is-invalid');
							let alert = alertMsg('danger', result.taskError);
							error.innerHTML = alert;
						} else if (result.error) {
							let alert = alertMsg('danger', result.error);
							error.innerHTML = alert;
						} else if (result.success) {
							let alert = alertMsg('success', result.success);
							error.innerHTML = alert;
							addFormElement.reset();
							showTasks();
						} else {
							let alert = alertMsg('danger', 'Something went wrong!');
							error.innerHTML = alert;
						}
					})
			}
		});

		showTasks();

		function showTasks() {
			fetch('./show-tasks.php', {
					headers: {
						'Content-Type': 'application.json'
					}
				})
				.then(function(response) {
					return response.json();
				})
				.then(function(result) {
					const tasksElement = document.getElementById('tasks');
					let tasks = '';

					result.forEach(function(value) {
						tasks += `<div class="row mb-2"><div class="col-md-9"><input type="text" class="form-control" id="task-${value.id}" value="${value.task_body}" placeholder="Please enter the task!" readonly></div><div class="col"><button class="btn btn-info" id="edit-${value.id}" onclick="editTask(${value.id})">Edit</button></div><div class="col"><button class="btn btn-danger" id="delete-${value.id}" onclick="deleteTask(${value.id})">Delete</button></div></div>`;
					})

					tasksElement.innerHTML = tasks;

				})
		}

		function editTask(id) {
			const editInputElement = document.getElementById('task-' + id);
			const editBtnElement = document.getElementById('edit-' + id);

			if (editBtnElement.innerText.toLowerCase() == 'edit') {
				editBtnElement.innerText = 'Save'
				editInputElement.removeAttribute('readonly');
				let range = editInputElement.value.length;
				editInputElement.focus();
				editInputElement.setSelectionRange(range, range);
			} else {

				const editInputValue = editInputElement.value;

				editInputElement.classList.remove('is-invalid');
				error.innerHTML = '';

				if (editInputValue == "" || editInputValue === undefined) {
					editInputElement.classList.add('is-invalid');
					let alert = alertMsg('danger', 'Please provide the task!');
					error.innerHTML = alert;
				} else {
					const data = {
						task: editInputValue,
						id: id,
						submit: 1
					}

					fetch('./edit-task.php', {
							method: 'POST',
							body: JSON.stringify(data),
							headers: {
								'Content-Type': 'application.json'
							}
						})
						.then(function(response) {
							return response.json();
						})
						.then(function(result) {
							if (result.taskError) {
								editInputElement.classList.add('is-invalid');
								let alert = alertMsg('danger', result.taskError);
								error.innerHTML = alert;
							} else if (result.error) {
								let alert = alertMsg('danger', result.error);
								error.innerHTML = alert;
							} else if (result.success) {
								let alert = alertMsg('success', result.success);
								error.innerHTML = alert;
								editBtnElement.innerText = 'Edit'
								editInputElement.setAttribute('readonly', true);
							} else {
								let alert = alertMsg('danger', 'Something went wrong!');
								error.innerHTML = alert;
							}
						})
				}
			}
		}

		function deleteTask(id) {
			const data = {
						id: id,
						submit: 1
					}

					fetch('./delete-task.php', {
							method: 'POST',
							body: JSON.stringify(data),
							headers: {
								'Content-Type': 'application.json'
							}
						})
						.then(function(response) {
							return response.json();
						})
						.then(function(result) {
							if (result.success) {
								let alert = alertMsg('success', result.success);
								error.innerHTML = alert;
								showTasks();
							} else {
								let alert = alertMsg('danger', 'Something went wrong!');
								error.innerHTML = alert;
							}
						})

		}
	</script>

</body>

</html>