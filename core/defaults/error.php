<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>An error has occurred in your application!</title>
		
		<style>
			* {
				margin: 0;
				padding: 0;
				
				-webkit-font-smoothing: antialiased;
			}
			
			body {
				background: #e6e8ed;
				color: #575757;
				
				font: 15px/25px "Helvetica Neue", sans-serif;
			}
			
			.error {
				width: 840px;
				height: 360px;
				margin: -200px 0 0 -450px;
				padding: 20px 30px;
				
				position: absolute;
				left: 50%;
				top: 50%;
				
				background: #fff;
				border-radius: 5px;
				box-shadow: 0 1px 2px rgba(0,0,0,.2);
			}
				.error h1 {
					background: #d53b2b;
					color: #fff;
					
					font-size: 21px;
					font-weight: lighter;
					text-shadow: 0 1px 1px rgba(0,0,0,.25);
					
					margin: -20px -30px 20px;
					padding: 15px 30px;
					
					border-radius: 5px 5px 0 0;
					box-shadow: inset 0 -1px 2px rgba(0,0,0,.1), 0 1px 1px rgba(0,0,0,.1);
				}
		</style>
	</head>
	<body>
		<div class="error">
			<h1>Error: <?php echo $message; ?>
				<span><?php echo $file; ?>, line <b><?php echo $line; ?></b></span>
			</h1>
			<p>Unfortunately, you&rsquo;ve got an error on line <code><?php echo $line; ?></code> of <code><?php echo $file; ?></code>.</p>
			
			<p>Just so you know, the function called was <code><?php echo (isset($trace[0]['class']) ? $trace[0]['class'] . '::' : '') . $trace[0]['function']; ?>('<?php echo join('\', \'', $trace[0]['args']); ?>')</code>, and the full stack is as follows:</p>
			
			<?php dump($trace); ?>
		</div>
	</body>
</html>