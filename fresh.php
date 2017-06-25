<!DOCTYPE html>
<html>
	<?php 
		$movie = $_REQUEST["film"];
		
		$movie_file =  "samples/" . $movie . "/";
		$info = file($movie_file . "info.txt");
		$movie_poster_src =  $movie_file . "overview.png";
		$movie = $info[0];
		$movie_year = $info[1];
		$movie_rating = $info[2];

		$reviews = glob($movie_file . "review*.txt");
		$review_count = count($reviews);
		$reviews_column_left = array();

		array_reverse($reviews);
		
		$i = 0;
		while ($i <= ceil($review_count/2)-1){
			$reviews_column_left[] = array_pop($reviews);
			$i++;
		}

		$reviews_column_right = array_reverse($reviews);
		
		function column_reviews($column)
		{
			foreach($column as $single_review)
			{
				
				$content = file($movie_file . $single_review);
				$review_summary = trim($content[1]);
				$review_text = $content[0];
				$reviewer_name = $content[2];
				$reviewer_company = $content[3];
				
				?>
				<p id = "single_review">
				<?
					
					if ($review_summary == "FRESH"){
						$review_icon = "img/fresh.gif";
					} 
					else {
						$review_icon = "img/rotten.gif";			
					}
				?>
					<img id = "review_icon" src="<?= $review_icon ?>" alt="Rotten">
				
					<q><?= $review_text ?></q>
				</p>
				<div id = "reviewer">
					<div id = "reviewer_img">
						<img id = "review_icon" src="img/critic.gif" alt="Critic">
					</div>
					<div id = "reviewer_name">
						<?= $reviewer_name ?><br>
						<div id = "company">
							<?= $reviewer_company ?>
						</div>
					</div>
				</div>
				<?
				
			}
		}
	?>
		
	<head>
		<title><?= $movie ?> - Rancid Tomatoes</title>

		<meta charset="utf-8" />
		<link rel="icon" href="<?= $review_icon ?>">    
		<link href="fresh.css" type="text/css" rel="stylesheet">
	</head>
	<div id='banner' >
		<center>
			<img src="img/banner.png" alt="Rancid Tomatoes" />
		</center>
	</div>
	<body>

		<h1><?= $movie ?>(<?= trim($movie_year)?>)</h1>
		<div id ="allcontent">
			<div id="main">
				<!--- Reviews -->
				<div id = "left">
					<div id ="rating">
						<?
							if ($movie_rating < "60"){
								?>
								<img id="overall_rating_tomato" src="img/rottenbig.png" alt="Fresh" />
								<?
							} else {
								?>
								<img id="overall_rating_tomato" src="img/freshbig.png" alt="Fresh" /><?
							}
							?>
						<?= $movie_rating ?>%
					</div>
					<div id = "reviews">
						<div id = "review_column_left">
							<? column_reviews($reviews_column_left)?>
						</div>
						<div id = "review_column_left">
							<? column_reviews($reviews_column_right)?>
						</div>
					</div>
				
				</div>

				<!--- Movie Details -->

				<div id ="right">
					<div id ="poster_placeholder">
						<img id = "movie_poster" src="<?= $movie_poster_src ?>" alt="general overview">
					</div>
					<div id="movieinfo">
					<dl>
						<?
							$overview = file($movie_file . "overview.txt");

							foreach($overview as $line)
							{	
								$line_sep = explode(":", $line,2);
								$line_items = $line_sep[1];
								?>
								<dt><?= $line_sep[0] ?></dt>
								<dd><?= trim($line_items)?></dd>
								<?
								
							}		
						?>
					</dl>
					</div>
				</div>
			</div>
			<div id = "pagenum">(1-<?= $review_count?>) of <?= $review_count?></div>
		
		</div>
		<div id = "validator">
			<p>
      			<a href="http://validator.w3.org/check?uri=referer">
      			<img id = "validator_img"src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0!" height="31" width="88" /></a>

    		</p>
  
			<a href="../../css_validator.php"><img id ="validator_img" src="img/w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</body>
</html>