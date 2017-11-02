
<!DOCTYPE html>
<html lang="en">
  <head>
  	<!-- Global site tag (gtag.js) - Google Analytics -->
  	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108111485-1"></script>
  	<script>
  	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());

  	gtag('config', 'UA-108111485-1');
  	</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Trigonometry Speed Tester: tests quick solving of basic trig facts, like converting degrees to radians and unit-circle sin's, cos's, and tan's.">
    <meta name="author" content="Kendall Goto">
    <title>kgo.to | trigonometry speedtests</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.css" integrity="sha256-Z0FmvP1JtDmwVaHpsgu75FrC/SInDnlFWL95M65PCr4=" crossorigin="anonymous" />
	<link rel="stylesheet" href="/trig/style.css"/>
	<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
	<link rel="manifest" href="/img/manifest.json">
	<link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#5c60ff">
	<link rel="shortcut icon" href="/img/favicon.ico">
	<meta name="apple-mobile-web-app-title" content="kgo.to">
	<meta name="application-name" content="kgo.to">
	<meta name="msapplication-config" content="/img/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	
  </head>

  <body>
      <div class="container">
  	  <div class="col-xs-12 col-sm-10 col-md-6 ml-auto mr-auto">
		  <div class="card">
		    <ul class="list-group list-group-flush">
		      <li class="list-group-item">
  		      	<h3 class="card-title">Trig Speedtest <a href="/trig/print.php">(printable)</a></h3>
  		      	<p class="card-text">This site is designed to help students practice their speed on providing basic trig facts. It tests degree to radian conversions, as well as cos/sin/tan of basic angles (0, 30, 45, 60 ... etc). All answers should be exact.</p>
		      </li>
		      <li class="list-group-item" id="answerBox">
  		      	<h4 class="card-title" id="questionLoad">Loading Question</h4>
				<span id="math-field"></span>
				<br>
				<div class="buttonHolder">
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="-\sqrt{3}"><img src="/trig/icons/-sqrt3.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="-1"><img src="/trig/icons/-1.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="-\frac{\sqrt{3}}{2}"><img src="/trig/icons/-sqrt3:2.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="-\frac{\sqrt{3}}{3}"><img src="/trig/icons/-sqrt3:3.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="-\frac{\sqrt{2}}{2}"><img src="/trig/icons/-sqrt2:2.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="-\frac{1}{2}"><img src="/trig/icons/-1:2.png"></img></button>
				</div>
				<div class="buttonHolder">
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="\frac{\sqrt{3}}{2}"><img src="/trig/icons/sqrt3:2.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="1"><img src="/trig/icons/1.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="\sqrt{3}"><img src="/trig/icons/sqrt3.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="\frac{1}{2}"><img src="/trig/icons/1:2.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="\frac{\sqrt{2}}{2}"><img src="/trig/icons/sqrt2:2.png"></img></button>
					<button type="button" class="btn btn-secondary quickBtn" onclick="quickButton(this)" data-latex="\frac{\sqrt{3}}{3}"><img src="/trig/icons/sqrt3:3.png"></img></button>
				</div>
		      </li>
		    </ul>
		  </div>
        </div>
		<br>
    	<div class="col-xs-12 col-sm-10 col-md-8 ml-auto mr-auto">
			<div class="card-columns">
	  		  <div class="card template" id="pastTempl">
	  		    <ul class="list-group list-group-flush">
	  		      <li class="list-group-item">
	    		      	<h4 class="card-title questionAsked">2pi/3</h4>
		  		      	<p class="card-text">You said: <span class="yousaid"></span></p>
		  		      	<p class="card-text">Correct: <span class="rightans"></span></p>
	  		      </li>
	  		    </ul>
	  		  </div>
		  </div>
		  <p class="copyright">Copyright &copy; 2017 Kendall Goto
         </div>
      </div>
	  <div class="d-none d-md-block" id="timer">
		  <div class="score" id="scoreKeeper">
			  <div class="pull-left left">0</div>
			  <div class="pull-right right">0</div>
		  </div>
		  <div class="clearfix"></div>
		  <div class="time">
			  <div class="pull-left">
				  0:00
			  </div>
			  <div class="pull-right">
				  <a class="btn btn-danger" href="javascript:reset();" style="display: block; line-height:32px;">Reset</a>
			  </div>
			  <div class="clearfix"></div>
		</div>
	  </div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.js" integrity="sha256-dxKVPdWCaZTdphHQqQEc0GSDAVZJCxshwn3ZrvHtqgo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.16.1/math.min.js" integrity="sha256-wJQ5XiravbKAJOLaaVRSETNZdRi9ne55xWeA04OCEsY=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="/trig/script.js"></script>
  </body>
</html>
