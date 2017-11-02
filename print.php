<?php
if(!isset($_GET['count']))
	$_GET['count'] = 80;
?>
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
	<style>
		@page {
		   size: 11in 8.5in;
		   margin: 0.5in 0.5in 0.5in 0.5in;
		}
		html, body, table, .container {
			width: 100%;
			height: 100%;
			padding: 0;
			margin: 0;
			max-width: none;
			font-size: 0.9rem;
		}
		table {
			table-layout: fixed;
			page-break-after: always;
		}
		table, td, th {
			border: 1px solid black;
		}
		td {
			padding: 10px;
		}
		.quest {
		}
		.answer {
			color: red;
			font-size: 1rem;
			float: left;
		}
		#table td {
			padding-right: 70%;
		}
		#table { display: none; }
		.printbtn {
			background: rgba(255, 255, 255, 0.9);
			padding: 10px;
			position: fixed;
			right: 0;
			top: 0;
			border-bottom-left-radius: 5px;
		}
		@media print {
			.printbtn {
				display: none;
			}
			#table {
				display: table;
			}
			.answer {
				color: black;
			}
		}
	</style>
  </head>

  <body>
      <div class="container">
		  <div class="printbtn">
			  <a href="javascript:window.print();">Print Questions &amp; Key</a> | <a href="javascript:window.location.reload();">New Sheet</a>

		  </div>
		  <table id="table">
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
		  </table>
		  <table id="key">
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
			  <tr></tr>
		  </table>
      </div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.min.js" integrity="sha256-dxKVPdWCaZTdphHQqQEc0GSDAVZJCxshwn3ZrvHtqgo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.16.1/math.min.js" integrity="sha256-wJQ5XiravbKAJOLaaVRSETNZdRi9ne55xWeA04OCEsY=" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<script src="/trig/script.js?nov2"></script>
	<script>
		//generate!
		function stack(goal) {
			return $.Deferred(function() {
				var result = [];
				while(result.length < goal) { 
					var data = generateQuestion(); 
					if(typeof data !== undefined && data != null) { 
						result.push(data);
					}
					console.log('aa');
				}
				console.log(result);
				this.resolve(result);
				return; 
			});
		}
		
		stack(<?php echo $_GET['count'] ?>).done(function(data) {
			data.forEach(function(ele, indx) {
				var row = Math.floor(indx / 10);
				var $target = null;
				$target = $('#table tr').eq(row);
				$target2 = $('#key tr').eq(row);
				console.log(row);
				console.log(ele);
				$target.append("<td>"+ele.question+"</td>");
				$target2.append("<td><div class=\"quest\">"+ele.question+"</div><div class=\"answer\">"+ele.translated+"</div></td>");
			});
			window.print();
		});
	</script>
  </body>
</html>
