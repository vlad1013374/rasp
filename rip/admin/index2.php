<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="js/jquery-3.6.0.js"></script>
</head>
<body>
	
	Изменить расписание на
		<select id="week">
			<option value="this">эту</option>
			<option value="next">следущую</option>
		</select>
		неделю
		<button class="but" > Показать</button>
		
		<form method="POST">
		<input type="submit" name ="exit" value= "Выйти">
		</form>


		<script>
			
			$(".but").click(function() {
				var week = $("#week").val();
				location.href = "?week=" + week;
			 });
		</script>

		<?php
			if (isset($_POST['exit'])) {
				session_destroy();
				header ('Location:'.$_SERVER['PHP_SELF']);

			}
			if (isset($_GET['week'])) {
				require_once 'index3.php';
			}

		?>
</body>
</html>