<?php
	include_once ('templates/header.php'); 
	include_once ('config/db_connect.php');
?>

<!DOCTYPE html>
<html>

	<div class="container center grey-text">
		<?php 

			if(isset($_POST['delete'])){
				$id_to_delete = mysqli_real_escape_string($connect, $_POST['id_to_delete']);
				$query = "DELETE FROM pizzas WHERE id = $id_to_delete"; 
				if(mysqli_query($connect,$query)){
					header("Location:index.php");
				}else{
					echo("Cannot delete data");
				}
			} 
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$query = "SELECT * FROM pizzas WHERE id = $id";
				$result = mysqli_query($connect,$query);
				$pizza = mysqli_fetch_assoc($result); // we use mysqli_fetch_assoc for instead loop data 
			}
			
		?>
			<h4><?php echo $pizza['title']; ?></h4>
			<p>Created by <?php echo $pizza['email'];  ?></p>
			<h5>Ingredients:</h5>
			<p><?php echo $pizza['ingredients']; ?></p>

			<!-- DELETE FORM -->
			<form action="details.php" method="POST">
				<input type="hidden" name="id_to_delete" value=" <?php echo $pizza['id'];?> ">
				<input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
			</form>

			<h5>No such pizza exists.</h5>
		<?php include_once ('templates/footer.php'); ?>
	</div>

</html>