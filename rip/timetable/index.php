<?php 
	require '../rb/rb.php';
	R::setup('mysql:host=localhost;dbname=vlad1013374_mail','vlad1013374_vladislav', 'rb049674');
	
	
	

	$week = $_GET['week'];
	settype($_GET['week'], 'integer');
	$class_like = $_GET['class']."%";


	$mon_date = date('d.m', strtotime('monday '.$week.' week'));
	$tue_date = date('d.m', strtotime('tuesday '.$week.' week'));
	$wed_date = date('d.m', strtotime('wednesday '.$week.' week'));
	$firth_date = date('d.m', strtotime('thursday '.$week.' week'));
	$fri_date = date('d.m', strtotime('friday '.$week.' week'));
	$sat_date = date('d.m', strtotime('saturday '.$week.' week'));

	$monday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  class like ?  and `time` = "1" and  `date`=? ', [$class_like,$mon_date]);
	$tuesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where class like ?  and `time` = "1" and  `date`=? ', [$class_like,$tue_date]);
	$wednesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where class like ?  and `time` = "1" and  `date`=? ', [$class_like,$wed_date]);
	$firthday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where class like ? and `time` = "1" and  `date`=? ', [$class_like,$firth_date]);
	$friday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where class like ? and `time` = "1" and  `date`=? ', [$class_like,$fri_date]);
	$saturday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where class like ? and `time` = "1" and  `date`=? ',[$class_like,$sat_date]);

	
	$subjects = R::getCol( 'SELECT `name` FROM subject');
	


	$time = array("8:45 - 10:20", "10:30 - 12:00", "12:30 - 14:05", "14:15 - 15:50");
	$classes = R::getCol( 'SELECT `name` FROM classes where name like ? ', [$class_like]);
	$audithories = array('','142', '143', '145', '146', '147', '148', '149', '151', '152');

	$colspan_day = count($classes)*2+2;
				
?>




<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Расписание2</title>
		<script src="js/jquery-3.6.0.js"></script>
		<style>
			.main	
			{
				width: 100%;
				height: 100%; 
				margin: 0px;
				padding: 0px;
			}

			.day-border
			{
				border: solid 3px black;
				background-color: #DFC8B8;
			}

			.classroom
			{
				width: 2%;
				background-color: #E4D8A6;
			}
			.week-num
			{
				width: 12%;
			}
			.time
			{
				width: 5%;
				height: 70px;
				font-style: italic;
				background-color: #E4D8A6;
			}
			.cls
			{
				width: 20%;

			}
			.time-t
			{
				text-align: center;
				width: 100%;
				
			}

			.subject
			{
				font-size: 20px;
				font-weight: bold;
				height: 30px;
			}
			.subject:hover
			{
				cursor: pointer;
				background-color: #C8C1D5;
			}
			.teacher
			{
				font-size: 14px;
				color: 	black;
				height: 15px;
				font-style: oblique;
			}

			.t-head, .cls, .date, .week-num, .day
			{
				background: #E5E2E1;
			}
			.t-head, .cls, .week-num
			{
				border: solid 0.5px black;
			}

			.day
			{
				font-size: 20px;
			}

			.date
			{
				background-color: #E4D8A6;
				width: 5%;
			}

			.subject, .teacher
			{
				background: #E2DBF0;
			}

			.extra-subject
			{
				background-color: #BDBAC6;
			}

			.extra-subject:hover
			{
				color: white;
				cursor: pointer;
			}
			.date > input{
				width: 35px;
				border: none;
				background-color: #E4D8A6;
				height: 30px;
			}
			.send{
				margin: 10px;
				float: right;
			}
			.aud{
				width: 45px;
				border-radius: 5px;
				background-color: #E4D8A6;
				height: 30px;
				cursor: pointer;
				
			}

		</style>
	</head>
	<body class = "main">
		
		<table cellpadding="4" cellspacing="0" border="1" class="time-t">
			<tr>
				<td class="week-num" colspan = "2">10 уч. неделя</td>

				<?php 
					foreach ($classes as  $class) {
						echo '<td class="cls" colspan="2">'.$class.'</td>';
					}
				?>
				
			</tr>
			<!--Понедельник-->
			<tr>
				<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Понедельник</td>'
				?>
			</tr>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="8">'.$mon_date.'</td>';
			echo '<td class = "time" rowspan="2">8:45 - 10:20</td>';
				foreach ($monday as  $value) {
					
						echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
					

				}
			echo '</tr>';
			echo '<tr>';
				foreach ($monday as  $value) {
					echo '<td class="teacher">'.$value['teacher'].'</td>';
					echo '<td class="classroom">'.$value['audithory'].'</td>';
				}


			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$monday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `class` like ?  and `time` = ? and  `date`=? ', [$class_like, $i, $mon_date]);
				echo '<tr>';
				echo '<td class = "time" rowspan="2">'.$time[$i - 1].'</td>';
					foreach ($monday as  $value) {
						
							echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
						
					}
				echo '</tr>';
				echo '<tr>';
					foreach ($monday as  $value) {
						echo '<td class="teacher">'.$value['teacher'].'</td>';
						echo '<td class="classroom">'.$value['audithory'].'</td>';
					}


				echo '</tr>';	
			}
				
			?>

			<!--Вторник-->
			<tr>
				<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Вторник</td>'
				?>
			</tr>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="8">'.$tue_date.'</td>';
			echo '<td class = "time" rowspan="2">8:45 - 10:20</td>';
				foreach ($tuesday as  $value) {
					
						echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
					

				}
			echo '</tr>';
			echo '<tr>';
				foreach ($tuesday as  $value) {
					echo '<td class="teacher">'.$value['teacher'].'</td>';
					echo '<td class="classroom">'.$value['audithory'].'</td>';
				}


			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$tuesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  class like ?  and `time` = ? and  `date`=? ', [$class_like, $i, $tue_date]);
				echo '<tr>';
				echo '<td class = "time" rowspan="2">'.$time[$i - 1].'</td>';
					foreach ($tuesday as  $value) {
						
							echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
						
					}
				echo '</tr>';
				echo '<tr>';
					foreach ($tuesday as  $value) {
						echo '<td class="teacher">'.$value['teacher'].'</td>';
						echo '<td class="classroom">'.$value['audithory'].'</td>';
					}


				echo '</tr>';	
			}
				
			?>


			<!--Среда-->
			<tr>
				<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Среда</td>'
				?>
			</tr>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="8">'.$wed_date.'</td>';
			echo '<td class = "time" rowspan="2">8:45 - 10:20</td>';
				foreach ($wednesday as  $value) {
					
						echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
					

				}
			echo '</tr>';
			echo '<tr>';
				foreach ($wednesday as  $value) {
					echo '<td class="teacher">'.$value['teacher'].'</td>';
					echo '<td class="classroom">'.$value['audithory'].'</td>';
				}


			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$wednesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  class like ? and `time` = ? and  `date`=? ', [$class_like, $i, $wed_date]);
				echo '<tr>';
				echo '<td class = "time" rowspan="2">'.$time[$i - 1].'</td>';
					foreach ($wednesday as  $value) {
						
							echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
						
					}
				echo '</tr>';
				echo '<tr>';
					foreach ($wednesday as  $value) {
						echo '<td class="teacher">'.$value['teacher'].'</td>';
						echo '<td class="classroom">'.$value['audithory'].'</td>';
					}


				echo '</tr>';	
			}
				
			?>

			<!--Четверг-->
			<tr>
				<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Четверг</td>'
				?>
			</tr>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="8">'.$firth_date.'</td>';
			echo '<td class = "time" rowspan="2">8:45 - 10:20</td>';
				foreach ($firthday as  $value) {
					
						echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
					

				}
			echo '</tr>';
			echo '<tr>';
				foreach ($firthday as  $value) {
					echo '<td class="teacher">'.$value['teacher'].'</td>';
					echo '<td class="classroom">'.$value['audithory'].'</td>';
				}


			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$firthday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  class like ?  and `time` = ? and  `date`=? ', [$class_like, $i, $firth_date]);
				echo '<tr>';
				echo '<td class = "time" rowspan="2">'.$time[$i - 1].'</td>';
					foreach ($firthday as  $value) {
						
							echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
						
					}
				echo '</tr>';
				echo '<tr>';
					foreach ($firthday as  $value) {
						echo '<td class="teacher">'.$value['teacher'].'</td>';
						echo '<td class="classroom">'.$value['audithory'].'</td>';
					}


				echo '</tr>';	
			}
				
			?>


			<!--Пятница-->
			<tr>
				<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Пятница</td>'
				?>
			</tr>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="8">'.$fri_date.'</td>';
			echo '<td class = "time" rowspan="2">8:45 - 10:20</td>';
				foreach ($friday as  $value) {
					
						echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
					

				}
			echo '</tr>';
			echo '<tr>';
				foreach ($friday as  $value) {
					echo '<td class="teacher">'.$value['teacher'].'</td>';
					echo '<td class="classroom">'.$value['audithory'].'</td>';
				}


			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$friday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  class like ?  and `time` = ? and  `date`=? ', [$class_like, $i, $fri_date]);
				echo '<tr>';
				echo '<td class = "time" rowspan="2">'.$time[$i - 1].'</td>';
					foreach ($friday as  $value) {
						
							echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
						
					}
				echo '</tr>';
				echo '<tr>';
					foreach ($friday as  $value) {
						echo '<td class="teacher">'.$value['teacher'].'</td>';
						echo '<td class="classroom">'.$value['audithory'].'</td>';
					}


				echo '</tr>';	
			}
				
			?>


			<!--Суббота-->
			<tr>
				<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Суббота</td>'
				?>
			</tr>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="8">'.$sat_date.'</td>';
			echo '<td class = "time" rowspan="2">8:45 - 10:20</td>';
				foreach ($saturday as  $value) {
					
						echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
					

				}
			echo '</tr>';
			echo '<tr>';
				foreach ($saturday as  $value) {
					echo '<td class="teacher">'.$value['teacher'].'</td>';
					echo '<td class="classroom">'.$value['audithory'].'</td>';
				}


			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$saturday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  class like ?  and `time` = ? and  `date`=? ', [$class_like, $i, $sat_date]);
				echo '<tr>';
				echo '<td class = "time" rowspan="2">'.$time[$i - 1].'</td>';
					foreach ($saturday as  $value) {
						
							echo '<td class = "subject" colspan = "2">'.$value['subject'].'</td>';
						
					}
				echo '</tr>';
				echo '<tr>';
					foreach ($saturday as  $value) {
						echo '<td class="teacher">'.$value['teacher'].'</td>';
						echo '<td class="classroom">'.$value['audithory'].'</td>';
					}


				echo '</tr>';	
			}
				
			?>
				
			

			

		</table>
		


		
	</body>	
</html>	