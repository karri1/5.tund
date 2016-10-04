<?php
 require("functions.php");
 
//kui ei ole kasutaja id'd

if(!isset ($_SESSION["userId"])){
	
	//suunan sisselogimise lehele
	//header("Location: logi.php");	
}

if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: logi.php");
}


?>

<h1>See on data leht</h1>

<p>Tere tulemast <?=$_SESSION["userEmail"];?>!
<a href = "?logout=1">Logi välja</a>
</P>