<?php 
include_once ('templates/header.php'); 
include_once ('config/db_connect.php');
?>
	<?php
		$email = "";
		$title = "";
		$ingredients = "";
		$errors = array('email' => '', 'title' => '', 'ingredients' => '');
		if(isset($_POST["submit"])) {
			$email = $_POST["email"];
			$title = $_POST["title"];
			$ingredients = $_POST["ingredients"];

			if(array_filter($errors)){
				echo ("errors");
			}else{
				$email = mysqli_real_escape_string($connect, $_POST['email']);
				$title = mysqli_real_escape_string($connect, $_POST['title']);
				$ingredients = mysqli_real_escape_string($connect, $_POST['ingredients']);

				$query = "INSERT INTO pizzas(email, title, ingredients) VALUE('$email', '$title', '$ingredients') ";
				$result = mysqli_query($connect, $query);

				if($result) {
					header("Location:index.php");
				}else{
					echo (" Cannot insert data".mysqli_query($connect));
				}
			}
			
			// check email
			if(empty($email)) {
				$errors['email'] = " an email cannot empty";
			}else{
				$email = $_POST['email'];
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
					$errors['email'] = "Email not validation formation";
				}
			}
		

			// check title
			if(empty($title)){
				$errors['title'] = "a title can not empty";
			}else{
				$title = $_POST['title'];
				if(!preg_match('/^[a-zA-Z\s]+$/',$title )){
					$errors['title'] = "text and speace only";
				}
			}


			if(empty($ingredients)) {
				$errors['ingredients'] = " an ingredients cannot empty";
			}else{
				$ingredients = $_POST['ingredients'] = "It is ingredients";
				if(!preg_match('/^([a-zA-z\s]+)(, \s*[a-zA-z\s]*)*$/', $ingredients)){
					$ingredients = $_POST['ingredients'] = "Ingredients require";

				}
			}

		}
	?>

<!DOCTYPE html>
<html>
	
	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<form class="white" action="#" method="post">
			<label>Your Email</label>
			<input type="text" name="email" value="<?php  ?>">
			<div class="red-text"><?php echo $errors['email'] ?></div>
			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php ?>">
			<div class="red-text"><?php echo $errors['title'] ?></div>
			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php ?>">
			<div class="red-text"><?php echo $errors['ingredients'] ?></div>
			<div class="center">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include_once('templates/header.php');  ?>

</html>