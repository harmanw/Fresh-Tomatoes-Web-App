<!DOCTYPE html>
<html>
	<?php 
		$movie = $_REQUEST["film"];
		
		$movie_file =  $movie . "/";
		$info = file($movie_file . "info.txt");
		$movie_poster_src = $movie_file . "overview.png";
    	echo "<script>console.log('$movie_poster_src');</script>";

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
				
				$review_summary = $content[1];
				$review_text = $content[0];
				$reviewer_name = $content[2];
				$reviewer_company = $content[3];
				
				?>
				<p id = "single_review">
				<?
				
				if ($review_summary == "ROTTEN")
				{
					?>
					<img id = "review_icon" src="rotten.gif" alt="Rotten">
					<?
				} 
				else 
				{
					?>
					<img id = "review_icon" src="fresh.gif" alt="Fresh">
					<?				
				}
				?>
				
					<q><?= $review_text ?></q>
				</p>
				<div id = "reviewer">
					<div id = "reviewer_img">
						<img id = "review_icon" src="critic.gif" alt="Critic">
					</div>
					<div id = "reviewer_name">
						<?= $reviewer_name ?><br>						<div id = "company">							<?= $reviewer_company ?>
							</div>
					</div>
				</div>
				<?
				
			}
		}
	?>
		
	<!-- CSCB20 Assignment 2: Fresh Tomatoes Web page -->
	<head>
		<title><?= $movie ?> - Fresh Tomatoes</title>

		<meta charset="utf-8" />
		<!-- this "base" element allows all image references below to be "relative",
		     meaning that you the image name, such as "overview.png", is appended
		     to this base URL.  NOTE however, that the same behavior will apply
		     to any other URL's below, and so those will have to be replaced with
		     absolute URL's written as "https://mathlab.../path_to_your_files".-->
		<link rel="icon" href="rotten.gif">    
		<link href="fresh.css" type="text/css" rel="stylesheet">
		<base href="/courses/webspace/cscb20w17/wadhwaha/a2/">
		<!-- Link to CSS file that you should create -->
		
	</head>

	<body>

		<div class='banner' >
			<center>
				<img src="banner.png" alt="Rancid Tomatoes" />
			</center>
		</div>

		<h1><?= $movie ?>(<?= $movie_year?>)</h1>

		<div id ="allcontent">
		
			<div id="main">

				<!--- Reviews -->

				<div id = "left">
					<div id ="rating">
						<?
							if ($movie_rating < "60"){
								?>
								<img id="overall_rating_tomato" src="rottenbig.png" alt="Fresh" />
								<?
									
							} else {
								?>
								<img id="overall_rating_tomato" src="freshbig.png" alt="Fresh" /><?
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

						<img id ="movie_poster" src="<?= $movie_poster_src ?>" alt="general overview" />
					</div>
					<div id="movieinfo">
					<dl>
						<?
							$overview = file($movie_file . "overview.txt");

							foreach($overview as $line)
							{	
								
								$line_sep = explode(":", $line);
								$line_items = $line_sep[1];
								$line_items = explode(",",$line_sep[1]);
								
								?>
								<dt><?= $line_sep[0] ?></dt>
									<?
										foreach($line_items as $item)
										{
											?>
											<dd><?= trim($item)?></dd>
											<?
										}
							}		
							?>
					</dl>			
					</div>
				</div>

			</div>
		<div id = "pagenum">(1-10) of 10</div>
		</div>
		<div id = "validator">
			<p>
      			<a href="http://validator.w3.org/check?uri=referer">
      			<img id = "validator_img"src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0!" height="31" width="88" /></a>

    		</p>
  
			<a href="../../css_validator.php"><img id ="validator_img" src="w3c-css.png" alt="Valid CSS" /></a>
		</div>
	</body>
</html>