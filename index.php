<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Test</title>
  </head>
  <body>
    <?php
		$url_get = "https://graph.facebook.com/v9.0/100004511048197_1636017283225291?fields=shares,reactions.summary(total_count)&access_token=EAAAAZAw4FxQIBAHRaauv6S0L7ZAPZBH2SWjHHNZAnOqzDPjNb1iBK1LfKZCtX94uahrCfRswDQmSwdZCJnCyVX2heSqsHFYNTFuJuvj0iVrl7dVSEm3L1ghETQOtxC6rKltZBfJaIYLn6zEKZA32rJg1uSU97HLgMJDFVO2bLjT6gwZDZD";
		$c = curl_init($url_get);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$json_string = curl_exec($c);
		$array = json_decode($json_string, true);
		//$array_data = $array["data"];
		var_dump($array);
		die();
	?>

	<button onclick="tableToExcel('tblData', 'W3C Example Table')">Export Table Data To Excel File</button>
	<table id="tblData" class="table">
	  <thead>
	    <tr>
	      <th scope="col">ID</th>
	      <th scope="col">Name</th>
	      <th scope="col">ID User</th>
	      <th scope="col">Message</th>
	      <th scope="col">Created Time</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php foreach($array_data as $row) : ?>
		    <tr>
		      <th scope="row"><?php echo $row["id"]; ?></th>
		      <td><?php echo $row["from"]["name"]; ?></td>
		      <td><?php echo $row["from"]["id"]; ?></td>
		      <td><?php echo $row["message"]; ?></td>
		      <td><?php echo $row["created_time"]; ?></td>
		    </tr>
		<?php endforeach; ?>
	  </tbody>
	</table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript" src="script.js"></script>
  </body>
</html>