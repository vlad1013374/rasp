<?php 
	require '../rb/rb.php';
	R::setup('mysql:host=localhost;dbname=vlad1013374_mail','vlad1013374_vladislav', 'rb049674');	

	$week = $_GET['week'];


	$mon_date = date('d.m', strtotime('monday '.$week.' week'));
	$tue_date = date('d.m', strtotime('tuesday '.$week.' week'));
	$wed_date = date('d.m', strtotime('wednesday '.$week.' week'));
	$firth_date = date('d.m', strtotime('thursday '.$week.' week'));
	$fri_date = date('d.m', strtotime('friday '.$week.' week'));
	$sat_date = date('d.m', strtotime('saturday '.$week.' week'));

	$monday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where   `time` = "1" and  `date`=? ', [$mon_date]);
	$tuesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where   `time` = "1" and  `date`=? ', [$tue_date]);
	$wednesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where   `time` = "1" and  `date`=? ', [$wed_date]);
	$firthday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `time` = "1" and  `date`=? ', [$firth_date]);
	$friday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where `time` = "1" and  `date`=? ', [$fri_date]);
	$saturday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable  where `time` = "1" and  `date`=? ', [$sat_date]);

	
	$subjects = R::getCol( 'SELECT `name` FROM subject');
	


	$time = array("8:45 - 10:20", "10:30 - 12:00", "12:30 - 14:05", "14:15 - 15:50");
	$classes = R::getCol( 'SELECT `name` FROM classes ');
	$audithories = array('','142', '143', '145', '146', '147', '148', '149', '151', '152');
	$colspan_day = count($classes)*2+2
				
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
		<form method="POST">
		<input type="submit" name="send" value="Сохранить" class="send">
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
			echo '<td class = "date" rowspan="4"><input type="text" placeholder="Дата" name="date[]" value="'.$mon_date.'"></td>';
			echo '<td class = "time" rowspan="1">8:45 - 10:20</td>';
			if(!empty($monday)){
			foreach ($monday as  $value) {
					
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-mon[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-mon[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
					
					
				}
			echo '</tr>';


				for ($i=2; $i < 5; $i++) { 
					$monday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `time` = ? and  `date`=? ', [$i, $mon_date]);
					echo '<tr>';
					
					echo '<td class = "time" >'.$time[$i - 1].'</td>';
					foreach ($monday as  $value) {
						echo '<td class = "subject">
						<select class="js-selectize" name="sub-mon[]">';
						if(!empty($value['subject'])){
							echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
						}
						foreach ($subjects as $subject) {
							echo '<option >'.$subject.'</option>';
						}'
						</select>
						</td>';
						
						echo '<td class="classroom">
						<select class="aud" name = "aud-mon[]">';
						echo '<option selected>'.$value['audithory'].'</option>';
						foreach ($audithories as $value) {
							echo '<option>'.$value.'</option>';
						}
						echo '</td>';
					}
					echo '</tr>';
					
				}
			}else{
				for ($i=0; $i < count($classes); $i++) { 
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-mon[]">';
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-mon[]">';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
				}
				echo '</tr>';

				for ($i=2; $i < 5; $i++) { 
					
					echo '<tr>';
					
					echo '<td class = "time" >'.$time[$i - 1].'</td>';
					for ($n=0; $n < count($classes); $n++) {
						echo '<td class = "subject">
						<select class="js-selectize" name="sub-mon[]">';
						
						foreach ($subjects as $subject) {
							echo '<option >'.$subject.'</option>';
						}'
						</select>
						</td>';
						
						echo '<td class="classroom">
						<select class="aud" name = "aud-mon[]">';
						
						foreach ($audithories as $value) {
							echo '<option>'.$value.'</option>';
						}
						echo '</td>';
					}
					echo '</tr>';
					
				}

			}
			
			


			
				
			?>

			<!-- Вторник -->
			<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Вторник</td>'
				?>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="4"><input type="text" placeholder="Дата" name="date[]" value="'.$tue_date.'"></td>';
			echo '<td class = "time" rowspan="1">8:45 - 10:20</td>';
				foreach ($tuesday as  $value) {
					
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-tue[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-tue[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
					
					
				}
				echo '</tr>';
					
				for ($i=2; $i < 5; $i++) { 
					$tuesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `time` = ? and  `date`=? ', [$i, $tue_date]);
					echo '<tr>';
					
					echo '<td class = "time" >'.$time[$i - 1].'</td>';
					foreach ($tuesday as  $value) {
						echo '<td class = "subject">
						<select class="js-selectize" name="sub-tue[]">';
						if(!empty($value['subject'])){
							echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
						}
						foreach ($subjects as $subject) {
							echo '<option >'.$subject.'</option>';
						}'
						</select>
						</td>';
						
						echo '<td class="classroom">
						<select class="aud" name = "aud-tue[]">';
						echo '<option selected>'.$value['audithory'].'</option>';
						foreach ($audithories as $value) {
							echo '<option>'.$value.'</option>';
						}
						echo '</td>';
					}
					echo '</tr>';
				
				}
			
			?>


			<!-- Среда -->

			<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Среда</td>'
				?>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="4"><input type="text" placeholder="Дата" name="date[]" value="'.$wed_date.'"></td>';
			echo '<td class = "time" rowspan="1">8:45 - 10:20</td>';
				foreach ($wednesday as  $value) {
					
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-wed[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-wed[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
					
					
				}
			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$wednesday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `time` = ? and  `date`=? ', [$i, $wed_date]);
				echo '<tr>';
				
				echo '<td class = "time" >'.$time[$i - 1].'</td>';
				foreach ($wednesday as  $value) {
					echo '<td class = "subject">
					<select class="js-selectize" name="sub-wed[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-wed[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
				}
				echo '</tr>';
				
			}
				
			?>

			<!-- Четверг -->

			<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Четверг</td>'
				?>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="4"><input type="text" placeholder="Дата" name="date[]" value="'.$firth_date.'"></td>';
			echo '<td class = "time" rowspan="1">8:45 - 10:20</td>';
				foreach ($firthday as  $value) {
					
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-firth[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-firth[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
					
					
				}
			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$firthday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `time` = ? and  `date`=? ', [$i, $firth_date]);
				echo '<tr>';
				
				echo '<td class = "time" >'.$time[$i - 1].'</td>';
				foreach ($firthday as  $value) {
					echo '<td class = "subject">
					<select class="js-selectize" name="sub-firth[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-firth[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
				}
				echo '</tr>';
				
			}
				
			?>


			<!-- Пятница -->

			<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Пятница</td>'
			?>			
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="4"><input type="text" placeholder="Дата" name="date[]" value="'.$fri_date.'"></td>';
			echo '<td class = "time" rowspan="1">8:45 - 10:20</td>';
				foreach ($friday as  $value) {
					
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-fri[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-fri[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
					
					
				}
			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$friday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where  `time` = ? and  `date`=? ', [$i, $fri_date]);
				echo '<tr>';
				
				echo '<td class = "time" >'.$time[$i - 1].'</td>';
				foreach ($friday as  $value) {
					echo '<td class = "subject">
					<select class="js-selectize" name="sub-fri[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-fri[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
				}
				echo '</tr>';
				
			}
				
			?>


			<!-- Суббота -->

			<?php
				echo '<td class = "day-border" colspan = "'.$colspan_day.'">Суббота</td>'
			?>
			<?php
			echo '<tr>';
			echo '<td class = "date" rowspan="4"><input type="text" placeholder="Дата" name="date[]" value="'.$sat_date.'"></td>';
			echo '<td class = "time" rowspan="1">8:45 - 10:20</td>';
				foreach ($saturday as  $value) {
					
					echo '<td class = "subject" >
					<select class="js-selectize"  name="sub-sat[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-sat[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
					
					
				}
			echo '</tr>';
				
			for ($i=2; $i < 5; $i++) { 
				$saturday = R::getAll( 'SELECT `subject`,`teacher`, `audithory` FROM timetable where `time` = ? and  `date`=? ', [$i, $sat_date]);
				echo '<tr>';
				
				echo '<td class = "time" >'.$time[$i - 1].'</td>';
				foreach ($saturday as  $value) {
					echo '<td class = "subject">
					<select class="js-selectize" name="sub-sat[]">';
					if(!empty($value['subject'])){
						echo '<option selected>'.$value['subject'].'/'.$value['teacher'].'</option>';
					}
					foreach ($subjects as $subject) {
						echo '<option >'.$subject.'</option>';
					}'
					</select>
					</td>';
					
					echo '<td class="classroom">
					<select class="aud" name = "aud-sat[]">';
					echo '<option selected>'.$value['audithory'].'</option>';
					foreach ($audithories as $value) {
						echo '<option>'.$value.'</option>';
					}
					echo '</td>';
				}
				echo '</tr>';
				
			}
				
			?>

			

		</table>
		</form>


		<link rel="stylesheet" href="js/selectize.js-master/dist/css/selectize.default.css">
		<script src="js/microplugin.js"></script>
		<script src="js/sifter.min.js"></script>
		<script src="js/selectize.js-master/dist/js/selectize.min.js"></script>
		<script>
			
			$(document).ready(function(){
				$('.js-selectize').selectize();
			});

			

		</script>
	</body>	
</html>	
		
<?php
$sub_classes = $classes;


$sub_mon = $_POST['sub-mon'];
$aud_mon = $_POST['aud-mon'];


$sub_tue = $_POST['sub-tue'];
$aud_tue = $_POST['aud-tue'];


$sub_wed = $_POST['sub-wed'];
$aud_wed = $_POST['aud-wed'];

$sub_firth = $_POST['sub-firth'];
$aud_firth = $_POST['aud-firth'];

$sub_fri = $_POST['sub-fri'];
$aud_fri = $_POST['aud-fri'];

$sub_sat = $_POST['sub-sat'];
$aud_sat = $_POST['aud-sat'];


$date = $_POST['date'];
$sub_time = array();

	for ($i=0; $i < 4; $i++) { 
		for ($n=0; $n < count($classes); $n++) { 
			array_push($sub_time , $i+1);
		}
		
	}

	

	for ($i=0; $i < 3; $i++) { 
		foreach ($classes as $value) {
			array_push($sub_classes, $value);
		}
	}



if (isset($_POST['send'])) {





	/*Понедельник*/
	$i = 0;
	$id = R::getCol( 'SELECT `id` FROM `timetable` WHERE  `date` = ?', [$mon_date]);
	if (!(empty($id[0]))) {
		foreach ($sub_mon as $sub) {
		$id = R::getCell( 'SELECT `id` FROM `timetable` WHERE  `class`=? and `time` = ? and `date` = ?', [$sub_classes[$i], $sub_time[$i], $mon_date]);
		
		$sub_r = explode('/', $sub);
		$timetable = R::load('timetable', $id);
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_mon[$i];
		$timetable->date = $date[0];
		R::store($timetable);
		$i = $i +1;
		
		}
	}else{
		foreach ($sub_mon as $sub) {
		$sub_r = explode('/', $sub);
		$timetable = R::dispense('timetable');
		$timetable->day = "Понедельник";
		$timetable->date = $date[0];
		$timetable->time = $sub_time[$i];
		$timetable->class = $sub_classes[$i];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_mon[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
		
	}



	/*Вторник*/
	$i = 0;
	$id = R::getCol( 'SELECT `id` FROM `timetable` WHERE `date` = ?', [$tue_date]);
	if (!(empty($id[0]))) {
		foreach ($sub_tue as $sub) {
		$id = R::getCell( 'SELECT `id` FROM `timetable` WHERE  `class`=? and `time` = ? and `date` = ?', [$sub_classes[$i], $sub_time[$i], $tue_date]);

		$sub_r = explode('/', $sub);
		$timetable = R::load('timetable', $id);
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_tue[$i];
		$timetable->date = $date[1];
		R::store($timetable);
		$i = $i +1;
		
		}
	}else{
		foreach ($sub_tue as $sub) {
		$sub_r = explode('/', $sub);
		$timetable = R::dispense('timetable');
		$timetable->day = "Вторник";
		$timetable->date = $date[1];
		$timetable->time = $sub_time[$i];
		$timetable->class = $sub_classes[$i];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_tue[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
	}



	/*Среда*/
	$i = 0;
	$id = R::getCol( 'SELECT `id` FROM `timetable` WHERE `date` = ?', [$wed_date]);
	if (!(empty($id[0]))) {
		foreach ($sub_wed as $sub) {
		$id = R::getCell( 'SELECT `id` FROM `timetable` WHERE  `class`=? and `time` = ? and `date` = ?', [$sub_classes[$i], $sub_time[$i], $wed_date]);

		$sub_r = explode('/', $sub);
		$timetable = R::load('timetable', $id);
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_wed[$i];
		$timetable->date = $date[2];
		R::store($timetable);
		$i = $i +1;
		
		}
	}else{
		foreach ($sub_wed as $sub) {
		$sub_r = explode('/', $sub);
		$timetable = R::dispense('timetable');
		$timetable->day = "Среда";
		$timetable->date = $date[2];
		$timetable->time = $sub_time[$i];
		$timetable->class = $sub_classes[$i];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_wed[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
	}

	/*Четверг*/
	$i = 0;
	$id = R::getCol( 'SELECT `id` FROM `timetable` WHERE `date` = ?', [$firth_date]);
	if (!(empty($id[0]))) {
		foreach ($sub_firth as $sub) {
		$id = R::getCell( 'SELECT `id` FROM `timetable` WHERE  `class`=? and `time` = ? and `date` = ?', [$sub_classes[$i], $sub_time[$i], $firth_date]);

		$sub_r = explode('/', $sub);
		$timetable = R::load('timetable', $id);
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_firth[$i];
		$timetable->date = $date[3];
		R::store($timetable);
		$i = $i +1;
		
		}
	}else{
		foreach ($sub_firth as $sub) {
		$sub_r = explode('/', $sub);
		$timetable = R::dispense('timetable');
		$timetable->day = "Четверг";
		$timetable->date = $date[3];
		$timetable->time = $sub_time[$i];
		$timetable->class = $sub_classes[$i];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_firth[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
	}



	/*Пятница*/
	$i = 0;
	$id = R::getCol( 'SELECT `id` FROM `timetable` WHERE `date` = ?', [$fri_date]);
	if (!(empty($id[0]))) {
		foreach ($sub_fri as $sub) {
		$id = R::getCell( 'SELECT `id` FROM `timetable` WHERE  `class`=? and `time` = ? and `date` = ?', [$sub_classes[$i], $sub_time[$i], $fri_date]);

		$sub_r = explode('/', $sub);
		$timetable = R::load('timetable', $id);
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_fri[$i];
		$timetable->date = $date[4];
		R::store($timetable);
		$i = $i +1;
		
		}
	}else{
		foreach ($sub_fri as $sub) {
		$sub_r = explode('/', $sub);
		$timetable = R::dispense('timetable');
		$timetable->day = "Пятница";
		$timetable->date = $date[4];
		$timetable->time = $sub_time[$i];
		$timetable->class = $sub_classes[$i];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_fri[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
	}




	/*Суббота*/
	$i = 0;
	$id = R::getCol( 'SELECT `id` FROM `timetable` WHERE  `date` = ?', [$sat_date]);
	if (!(empty($id[0]))) {
		foreach ($sub_sat as $sub) {
		$id = R::getCell( 'SELECT `id` FROM `timetable` WHERE  `class`=? and `time` = ? and `date` = ?', [$sub_classes[$i], $sub_time[$i], $sat_date]);

		$sub_r = explode('/', $sub);
		$timetable = R::load('timetable', $id);
		$timetable->date = $date[5];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_sat[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
	}else{
		foreach ($sub_sat as $sub) {
		$sub_r = explode('/', $sub);
		$timetable = R::dispense('timetable');
		$timetable->day = "Суббота";
		$timetable->date = $date[5];
		$timetable->time = $sub_time[$i];
		$timetable->class = $sub_classes[$i];
		$timetable->subject = $sub_r['0'];
		$timetable->teacher = $sub_r['1'];
		$timetable->audithory = $aud_sat[$i];
		R::store($timetable);
		$i = $i +1;
		
		}
	}

	
}
	



	

?>