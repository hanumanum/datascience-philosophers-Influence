<?php 
$limit = 3000;
$conn = mysqli_connect("localhost","root","root","philos");

mysqli_set_charset($conn,'utf8');

if(isset($_GET["info"]) && !isset($_GET["source"]) && $_GET["info"]=="pairs"){
	$sql = "SELECT * FROM influences LIMIT 0,$limit";
	$pairs = [];

	$res = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($res)){
		array_push($pairs, $row);
	}

	if($pairs){
		$json = json_encode($pairs,JSON_UNESCAPED_UNICODE); 
		echo $json;
	}
}

else if(isset($_GET["info"]) && $_GET["info"]=="names"){
	$sql = "SELECT * FROM philosopers ORDER BY infForce LIMIT 0,$limit";
	$names = [];
	$res = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($res)){
		array_push($names, $row);
	}

	if($names){
		$json = json_encode($names,JSON_UNESCAPED_UNICODE); 
		echo $json;
	}

}
else if(isset($_GET["info"]) && isset($_GET["source"]) && $_GET["info"]=="pairs"){
	$source  = $_GET["source"];
	$sql = "SELECT * FROM `influences` WHERE `source`='$source'";
	$names = [];
	$res = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($res)){
		array_push($names, $row);
	}

	if($names){
		$json = json_encode($names,JSON_UNESCAPED_UNICODE); 
		echo $json;
	}

}
else{
	die();
}


mysqli_close();