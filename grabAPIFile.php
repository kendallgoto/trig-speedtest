<?php
	
function get() {
	$angles = [0, 30, 45, 60, 90, 120, 135, 150, 180, 210, 225, 240, 270, 300, 315, 330, 360];
	$radians = ["0π", "π/6", "π/4", "π/3", "π/2", "2π/3", "3π/4", "5π/6", "π", "7π/6", "5π/4", "4π/3", "3π/2", "5π/3", "7π/4", "11π/6", "2π"];
	$real = [0, 0.5235987756, 0.7853981634, 1.0471975512, 1.5707963268, 2.0943951024, 2.3561944902, 2.617993878, 3.1415926536, 3.6651914292, 3.926990817, 4.1887902048, 4.7123889804, 5.235987756, 5.4977871438, 5.7595865316, 6.2831853072];
	$ops = ['none', 'sin', 'cos', 'tan'];
	
	$target_op = $ops[mt_rand(0, count($ops) - 1)];
	$answer = "";
	$question = "";
	switch($target_op) {
		case "none":
			//deg to rad
			$target = mt_rand(0, count($angles) - 1);
			$answer = $real[$target];
			$question = $angles[$target]."°";
			break;
		case "cos":
		case "sin":
		case "tan":
			$target = mt_rand(0, count($angles) - 1);
			$toUse = "";
			if((bool)mt_rand(0, 1))
				$toUse = $angles[$target];
			else
				$toUse = $radians[$target];
			if($angles[$target] == 90 || $angles[$target] == 270) //tan is undef
				$target_op = "sin";
			$question = $target_op . " " . $toUse;
			if($target_op == "cos") 
				$answer = cos($real[$target]);
			else if($target_op == "sin") 
				$answer = sin($real[$target]);
			else if($target_op == "tan") 
				$answer = tan($real[$target]);
	}

	$answerCheck = ["-1", "1", "0", "sqrt(3)/2", "-sqrt(3)/2", "sqrt(2)/2", "-sqrt(2)/2", "0.5", "-0.5", "-sqrt(3)/3", "sqrt(3)/3", "sqrt(3)", "-sqrt(3)"];
	$answerCheckActual = [-1, 1, 0, 0.866, -0.866, 0.7071, -0.7071, 0.5, -0.5, -0.577, 0.577, 1.732, -1.732];
	$actualIndx = -1;
	foreach($answerCheck as $index=>$answerr) {
		$thisAnswer = $answerCheck[$index];
		$thisActual = $answerCheckActual[$index];
	
		if(abs($thisActual-$answer) < 0.01) {
			//this answer is correct
			$actualIndx = $index;
			break;
		}
	}

	if($actualIndx == -1) {
		if($target_op == 'none') {
			//return rad value
			$trans = $radians[$target];
		} else
			exit("error");
	}
	else $trans = $answerCheck[$actualIndx];
	return json_encode([
		"question" => $question,
		"answer" => $answer,
		"translated" => $trans
	]);
}
if(isset($_GET['printL'])) {
	$mix = array();
	for($i = 0; $i < $_GET['printL']; $i++) {
		$mix[] = json_decode(get(), true);
	}
	echo json_encode($mix);
}
else echo get();
?>