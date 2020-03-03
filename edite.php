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
				$id_to_update = mysqli_real_escape_string($connect, $_POST['id_to_update']);
                $email = mysqli_real_escape_string($connect, $_POST['email']);
				$title = mysqli_real_escape_string($connect, $_POST['title']);
				$ingredients = mysqli_real_escape_string($connect, $_POST['ingredients']);
                
				$query = "UPDATE pizzas SET email = '$email', title = '$title', ingredients = '$ingredients' WHERE id = $id_to_update";
				$result = mysqli_query($connect, $query);

				if($result) {
					header("Location:index.php");
				}else{
					echo (" Cannot update data");
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
    	<?php
		if(isset($_GET['id'])){
			$id = mysqli_real_escape_string($connect, $_GET['id']);
			$query = "SELECT * FROM pizzas WHERE id = $id";
			$result = mysqli_query($connect, $query);
			$pizza = mysqli_fetch_assoc($result);
		}
	?>

<!DOCTYPE html>
<html>
	
	<section class="container grey-text">
		<h4 class="center">Add a Pizza</h4>
		<form class="white" action="#" method="post">
			<label>Your Email</label>
			<input type="text" name="email" value="<?php echo $pizza['email'] ?>">
			<div class="red-text"><?php echo $errors['email'] ?></div>
			<label>Pizza Title</label>
			<input type="text" name="title" value="<?php echo $pizza['title'] ?>">
			<div class="red-text"><?php echo $errors['title'] ?></div>
			<label>Ingredients (comma separated)</label>
			<input type="text" name="ingredients" value="<?php echo $pizza['ingredients'] ?>">
			<div class="red-text"><?php echo $errors['ingredients'] ?></div>
			<div class="center">
            <input type="hidden" name="id_to_update" value=" <?php echo $pizza['id'];?> ">
				<input type="submit" name="submit" value="Submit" class="btn brand z-depth-0">
			</div>
		</form>
	</section>

	<?php include_once('templates/header.php');  ?>

</html>