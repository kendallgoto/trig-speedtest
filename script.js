var currentQuestion, correct, incorrect, answered, timeAsked, timeAnswered;
correct = 0;
incorrect = 0;
var globalTime = 0;

var MQ = MathQuill.getInterface(2);
function enterCommand() {
	//evaluate
	timeAnswered = globalTime;
	var said = field.text();
	try {
		var answer = math.eval(field.text());
	}
	catch(err) {
		answer = -100000;
	}
	field.latex('');
	//see if correct
	var correctAns = currentQuestion.answer;
	answered++;
	if(Math.abs(answer - correctAns) < 0.01) {
		$("#answerBox").stop().css("background-color", "#9CFF9C").animate({ backgroundColor: "#FFFFFF"}, 500);
		correct++;
		console.log("CORRECT: " + currentQuestion.question + " | " + currentQuestion.answer.toFixed(2));
		createPastTempl(true, currentQuestion.question, said, currentQuestion.translated);
	}
	else {
		$("#answerBox").stop().css("background-color", "#FF9C9C").animate({ backgroundColor: "#FFFFFF"}, 500);
		incorrect++;
		console.log("INCORRECT: " + currentQuestion.question + " | " + currentQuestion.answer.toFixed(2) + " | You guessed: " + answer);
		createPastTempl(false, currentQuestion.question, said, currentQuestion.translated);
		
	}
	
	update();
	
}
var latexPrev = "";
var field = MQ.MathField(document.getElementById('math-field'), {
	spaceBehavesLikeTab: true,
	autoCommands: 'pi sqrt',
	autoOperatorNames: 'sin cos tan',
	handlers: {
		enter: function() {
			enterCommand();
		},
		edit: function(msg) {
			if(field.latex() == "\\sqrt{2}" && latexPrev == "\\sqrt{ }")
				field.moveToRightEnd();
			if(field.latex() == "\\sqrt{3}" && latexPrev == "\\sqrt{ }")
				field.moveToRightEnd();
			latexPrev = field.latex();
		}
	}
});
var avg = 0;
function quickButton(ele) {
	var latex = $(ele).attr('data-latex');
	field.latex(latex);
	field.focus();
	enterCommand();
	console.log(latex);
}
function createPastTempl(correctAns, question, entered, correct) {
	var templ = $('#pastTempl').clone().removeAttr('id');
	$(templ).removeClass('template');
	$('.questionAsked', templ).text(""+question + " @ " + Math.floor(timeAsked / 60) + ":" + ("00"+timeAsked%60).slice(-2));
	$('.yousaid', templ).text("\""+entered + "\" @ " + Math.floor(timeAnswered / 60) + ":" + ("00"+timeAnswered%60).slice(-2));
	var timeDiff = timeAnswered - timeAsked;
	var avgDiff = (timeDiff - avg).toFixed(2);
	avg = (timeDiff+avg)/2;
	$('.rightans', templ).text("\""+correct + "\" ("+Math.floor(timeDiff / 60) + ":" + ("00"+timeDiff%60).slice(-2)+" to solve, "+avgDiff+" from avg)");
	if(correctAns) {
		$(templ).addClass('success');
	}
	else {
		$(templ).addClass('failure');
	}
	
	$(templ).prependTo('.card-columns');
}
function getQuestion() {
	return $.ajax('grab.json', {
		dataType: 'json'
	});
}
function getQuestion() {
	return $.Deferred(function() {
		while(true) { 
			var data = generateQuestion(); 
			if(typeof data !== undefined && data != null) { 
				this.resolve(data); return; 
			}
		}
	});
}
var failcount = 0;
function update() {
	$('#scoreKeeper .left').text(correct);
	$('#scoreKeeper .right').text(incorrect);
	getQuestion().done(function(data) {
		failcount = 0;
		timeAsked = globalTime;
		if(currentQuestion && data.question == currentQuestion.question) {
			console.log("duplicate question!");
			update(); //dupe
			return;
		}
		currentQuestion = data;
		console.log(data);
		$('#questionLoad').html(currentQuestion.question);
	}).fail(function(msg) {
		console.log(msg);
		failcount++;
		if(failcount > 5)
			return;
		update();
	})
}
var repeat;
function addSecond() {
	globalTime++;
	$('.time .pull-left').text(Math.floor(globalTime / 60) + ":" + ("00"+globalTime%60).slice(-2));
}
repeat = setInterval(addSecond, 1000);
function reset() {
	globalTime = -1;
	addSecond();
	clearInterval(repeat);
	repeat = setInterval(addSecond, 1000);
	correct = 0;
	incorrect = 0;
	$('#scoreKeeper .left').text(correct);
	$('#scoreKeeper .right').text(incorrect);
	field.focus();
	$('.card-columns').children().not('.template').remove();
	avg = 0;
	update();
}
addSecond();
update();
$(function() {
	field.focus();
});



//PHP code
/* my original PHP can  be found at https://github.com/kendallgoto/trig-speedtest/blob/master/grabAPIFile.php */
function generateQuestion() {
	var angles = [0, 30, 45, 60, 90, 120, 135, 150, 180, 210, 225, 240, 270, 300, 315, 330, 360];
	var radians = ["0π", "π/6", "π/4", "π/3", "π/2", "2π/3", "3π/4", "5π/6", "π", "7π/6", "5π/4", "4π/3", "3π/2", "5π/3", "7π/4", "11π/6", "2π"];
	var real = [0, 0.5235987756, 0.7853981634, 1.0471975512, 1.5707963268, 2.0943951024, 2.3561944902, 2.617993878, 3.1415926536, 3.6651914292, 3.926990817, 4.1887902048, 4.7123889804, 5.235987756, 5.4977871438, 5.7595865316, 6.2831853072];
	var ops = ['none', 'sin', 'cos', 'tan'];

	var target_op = ops[Math.floor(Math.random() * ops.length)];
	var answer = "";
	var equation = "";
	var lasting = -1;
	switch(target_op) {
		case "none": 
			var targetIndx = Math.floor(Math.random() * angles.length);
			answer = real[targetIndx];
			question = angles[targetIndx]+"°";
			lasting = targetIndx;
			break;
		case "cos":
		case "sin":
		case "tan":
			var targetIndx = Math.floor(Math.random() * angles.length);
			var toUse = "";
			if(Math.random() >= 0.5)
				toUse = angles[targetIndx];
			else
				toUse = radians[targetIndx];
			if(target_op == "tan" && (angles[targetIndx] == 90 || angles[targetIndx] == 270)) //tan is undef
				target_op = "sin";
			question = target_op + " " + toUse;
			if(target_op == "cos") 
				answer = Math.cos(real[targetIndx]);
			else if(target_op == "sin") 
				answer = Math.sin(real[targetIndx]);
			else if(target_op == "tan") 
				answer = Math.tan(real[targetIndx]);
	}
	var answerCheck = ["-1", "1", "0", "sqrt(3)/2", "-sqrt(3)/2", "sqrt(2)/2", "-sqrt(2)/2", "0.5", "-0.5", "-sqrt(3)/3", "sqrt(3)/3", "sqrt(3)", "-sqrt(3)"];
	var answerCheckActual = [-1, 1, 0, 0.866, -0.866, 0.7071, -0.7071, 0.5, -0.5, -0.577, 0.577, 1.732, -1.732];
	var actualIndx = -1;
	for(var i = 0; i < answerCheck.length; i++) {
		var answerr = answerCheck[i];
		var actual = answerCheckActual[i];
		
		if(Math.abs(actual-answer) < 0.01) {
			actualIndx = i;
			break;
		}
	}
	var trans = "";
	if(actualIndx == -1) {
		if(target_op == 'none') {
			trans = radians[lasting];
		} else { console.log("error"); return; }
	}
	else trans = answerCheck[actualIndx];
	
	return {
		"question": question,
		"answer": answer,
		"translated": trans
	};
}
