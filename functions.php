<?php

 /*funktsioonide näited
 
 function sum ($x, $y) {
	 
	 return $x + $y;	 
 }
 
 echo sum(20, 20);
 echo "<br>";
 echo sum(15, 15);

 function hello ($eesnimi, $perenimi) {
	 
	 return "Tere tulemast "  .$eesnimi . " " .$perenimi;
		
}
echo "<br>";
echo hello ("Peeter", "Puravik");

********************************************
*/

// see fail peab olema kõigil lehtedel, kus tahan kasutada SESSION muutujat
session_start();

function signUp ($email, $password) {
	
	$database = "if16_karin";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
	$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
	echo $mysqli -> error;   //see on igaks juhuks
		
	$stmt -> bind_param("ss", $email, $password ); 

		if ($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
	$stmt->close();
	$mysqli->close();
	
}

function login($email, $password){
	
	$error = "";
	
	$database = "if16_karin";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created 
		FROM user_sample
		WHERE email = ?");
	
		echo $mysqli->error;
		
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		// on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "Kasutaja logis sisse ".$id;
				
				//määran sessiooni muutujad, millele saan ligi teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				header("Location: data.php");
			}else {
				$error = "vale parool";
			}
			
			
		} else {
			
			// ei leidnud kasutajat selle meiliga
			$error = "Ei ole sellist emaili";
		}
		
		return $error;
	}

?>

