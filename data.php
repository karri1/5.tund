<?php
 require("functions.php");
 
//kui ei ole kasutaja id'd

if(!isset ($_SESSION["userId"])){
	
	//suunan sisselogimise lehele
	header("Location: logi.php");	
}

if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: logi.php");
}

$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
		
		//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
		unset($_SESSION["message"]);
	}
	
	if ( isset($_POST["plate"]) && 
		isset($_POST["plate"]) && 
		!empty($_POST["color"]) && 
		!empty($_POST["color"])
	  ) {
		  
		saveCar($_POST["plate"], $_POST["color"]);
		
	}
?>

<h1>See on data leht</h1>
<?=$msg;?>
<p>Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href = "?logout=1">Logi välja</a>
</p>


<h2>Salvesta auto</h2>
<form method="POST">
	
	<label>Auto nr</label><br>
	<input name="plate" type="text">
	<br><br>
	
	<label>Auto värv</label><br>
	<input type="color" name="color" >
	<br><br>
	
	<input type="submit" value="Salvesta">
	
	
</form>