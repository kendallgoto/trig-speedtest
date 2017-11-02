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
