<!DOCTYPE html>
<?php error_reporting(0);?>
<html>
<head>
<title>API TRACEON</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<meta charset="utf-8">
</head>
<body>

<form name="frmMain" method="post" action="">
	<h2>API TRACEON</h2>Command : 
	<select id="command" name="command">
			<option></option>
            <option <?php if($_POST["command"] == 'checkpatron'){ echo "selected";} ?> value="checkpatron">Checkpatron</option>
            <option <?php if($_POST["command"] == 'checkout'){ echo "selected";} ?> value="checkout">Checkout</option>
			<option <?php if($_POST["command"] == 'checkout_again'){ echo "selected";} ?> value="checkout_again">Checkout Again</option> 
            <option <?php if($_POST["command"] == 'checkin'){ echo "selected";} ?> value="checkin">Checkin</option>
			<option <?php if($_POST["command"] == 'checkstatus'){ echo "selected";} ?> value="checkstatus">Checkstatus</option> 
			<option <?php if($_POST["command"] == 'checksearch'){ echo "selected";} ?> value="checksearch">Checksearch</option>
			<option <?php if($_POST["command"] == 'randomBook'){ echo "selected";} ?> value="randomBook">Random Book</option>
			<option <?php if($_POST["command"] == 'popularWeekly'){ echo "selected";} ?> value="popularWeekly">Popular Weekly</option>
			<option <?php if($_POST["command"] == 'popularMonthly'){ echo "selected";} ?> value="popularMonthly">Popular Monthly</option>
			<option <?php if($_POST["command"] == 'justReturn'){ echo "selected";} ?> value="justReturn">Just Return</option>
			<option <?php if($_POST["command"] == 'newReleases'){ echo "selected";} ?> value="newReleases">New Releases</option>
	</select>
	   Patron ID : <input type="text" name="PatronID" size="20" maxlength="100" value="<?php echo $_POST["PatronID"];?>">
	   Barcode : <input type="text" name="Barcode" size="20" maxlength="100" value="<?php echo $_POST["Barcode"];?>">
	   Keyword : <input type="text" name="Keyword" size="20" maxlength="100" value="<?php echo $_POST["Keyword"];?>">
	  <input type="submit" name="Submit" value="Submit">
</form>
<?php
			include("nusoap.php");
			$client = new nusoap_client("localhost/self_check/_api/api.php?wsdl",true); 
			if($_POST['PatronID'] != "" && $_POST['command'] == "checkpatron")
				{
					$checkpatron = array(
							'PatronID' => $_POST["PatronID"]
					);
					$result = $client->call('checkpatron',$checkpatron); 
					//echo json_encode($result); 	
					echo "<hr><pre>";
					print_r($result);
					echo "</pre>";
				/*
					?>
					<table width="500" border="1">
						<tr>
							<td>CustomerID</td>
							<td>Name</td>
						</tr>
					<?php
						foreach ($result as $dataresult) 
						{
					?>
						<tr>
							<td><?php echo $dataresult["name"];?></td>
							<td><?php foreach($dataresult["checkout_list"] as $checkout){ echo $checkout["title"]; } ?></td>
						</tr>
					<?php
						}
				
*/


				}
			else if($_POST['PatronID'] != "" && $_POST['command'] == "checkout" && $_POST['Barcode'] != "")
				{
					$checkout = array(
							'PatronID' => $_POST["PatronID"],
							'Barcode' => $_POST["Barcode"]
					);
					$result = $client->call('checkout',$checkout); 
					//echo json_encode($result); 
					echo "<hr><pre>";
					print_r($result);
					echo "</pre>";
				}

			else if($_POST['command'] == "checkin" && $_POST['Barcode'] != "")
				{
					$checkin = array(
							'Barcode' => $_POST["Barcode"]
					);
					$result = $client->call('checkin',$checkin); 
					//echo json_encode($result); 
					echo "<hr><pre>";
					print_r($result);
					echo "</pre>";
				}

			else if($_POST['PatronID'] != "" && $_POST['command'] == "checkout_again" && $_POST['Barcode'] != "")
				{
					$checkout_again = array(
						    'PatronID' => $_POST["PatronID"],
							'Barcode' => $_POST["Barcode"]
					);
					$result = $client->call('checkout_again',$checkout_again); 
					//echo json_encode($result); 
					echo "<hr><pre>";
					print_r($result);
					echo "</pre>";
				}

			else if($_POST['command'] == "checkstatus" && $_POST['Barcode'] != "")
				{
					$checkstatus = array(
							'Barcode' => $_POST["Barcode"]
					);
					$result = $client->call('checkstatus',$checkstatus); 

					//echo json_encode($result); 
					echo "<hr><pre>";
					print_r($result);
					echo "</pre>";

				}

			else if($_POST['command'] == "checksearch" && $_POST['Keyword'] != "")
				{
					$checksearch = array(
							'Keyword' => $_POST["Keyword"]
					);
					$result = $client->call('checksearch',$checksearch); 

					//echo json_encode($result); 
					echo "<hr><pre>";
					print_r($result);
					echo "</pre>";
				}

			else if($_POST['command'] == "randomBook")
				{
					echo "YES RANDOM 24 LIST";

					$randomBook = array();
					$result = $client->call('randomBook',$randomBook);

					echo "<hr><pre>";
					print_r($result);
					echo "</pre>"; 
				}

			else if($_POST['command'] == "popularWeekly")
				{
					echo "POPULAR WEEKLY LIMIT 4";

					$popularWeekly = array();
					$result = $client->call('popularWeekly',$popularWeekly);

					echo "<hr><pre>";
					print_r($result);
					echo "</pre>"; 
				}

			else if($_POST['command'] == "popularMonthly")
				{
					echo "POPULAR MONTHLY LIMIT 4";

					$popularMonthly = array();
					$result = $client->call('popularMonthly',$popularMonthly);

					echo "<hr><pre>";
					print_r($result);
					echo "</pre>"; 
				}

			else if($_POST['command'] == "justReturn")
				{
					echo "JUST RETURN BOOK";

					$justReturn = array();
					$result = $client->call('justReturn',$justReturn);

					echo "<hr><pre>";
					print_r($result);
					echo "</pre>"; 
				}

			else if($_POST['command'] == "newReleases")
				{
					echo "New Releases NEW! NEW!";

					$newReleases = array();
					$result = $client->call('newReleases',$newReleases);

					echo "<hr><pre>";
					print_r($result);
					echo "</pre>"; 
				}

?>
</body>
</html>