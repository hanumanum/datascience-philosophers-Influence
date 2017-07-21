<?php
$conn = mysqli_connect("localhost","root","root","philos");
mysqli_set_charset($conn,'utf8');

echo "<pre>";
var_dump($_POST);
echo "</pre>";
if(isset($_POST["submit"])){
    if(isset($_POST["nodata"])){
            $l = $_POST["link"];
            $sql = "UPDATE failed_urls SET nodata=1 WHERE link='$l'";
            mysqli_query($conn, $sql);
    }
}

if(isset($_POST["submit"])){
    if(isset($_POST["review"])){
            $l = $_POST["link"];
            $sql = "UPDATE failed_urls SET reviewXPAth=1 WHERE link='$l'";
            mysqli_query($conn, $sql);
    }
}

$sql = "SELECT DISTINCT link FROM failed_urls WHERE nodata=false and reviewXPAth=false";
$res  = mysqli_query($conn, $sql);

echo "<ul>";
while($r = mysqli_fetch_array($res)){
    $link = $r["link"];
    echo "<li>";
    echo "<a target='_blank' href='$link'>$link</a>";
    echo "<form method='POST'>";
    echo "<input type='checkbox' name='nodata' value='nodata'> nodata";
    echo "<input type='checkbox' name='review' value='review'> reviewXPATH";    
    echo "<input type='submit' name='submit' value='submit'>";
    echo "<input type='hidden' name='link' value='$link'>";
    echo "</form>";
    echo "</li>";
}
echo "</ul>";


mysqli_close($conn);