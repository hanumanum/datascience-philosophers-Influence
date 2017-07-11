<?php 

$id = $_GET["id"];
$bd = $_GET["bd"];

$conn = mysqli_connect("localhost","root","root","philos");
mysqli_set_charset($conn,'utf8');

$sql = "UPDATE philosopers SET birthyear=$bd WHERE birthyear=0 and id=$id";

$res = mysqli_query($conn,$sql);

mysqli_close($conn);