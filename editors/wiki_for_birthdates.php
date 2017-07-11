<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>


<div class="container">
<div class="row">
<div class="col-md-4">

<?php 
$conn = mysqli_connect("localhost","root","root","philos");
mysqli_set_charset($conn,'utf8');

$sql = "SELECT * FROM philosopers WHERE birthyear=0 ORDER BY name DESC";


$res = mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($res)){
	echo "<a target='_blank' href='https://en.wikipedia.org/wiki/".str_replace(" ","_",$row["name"])."'>" . $row["name"] . "</a>";
	echo "<input type='text' dataid='".$row["id"]."'><br>"; 
}
?>
</div>
<div class="col-md-8">
	<iframe src="http://ablog.gratun.am" id="fra" width="800" height="800" frameborder="0"></iframe>
</div>

</div>
</div>


<script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


<script type="text/javascript">
	$(document).ready(function(){
		$("a").click(function(e){
			e.preventDefault();
			$("#fra").attr("src",(this.href));
		});

		$("input").change(function(event) {
			id = $(this).attr("dataid");
			value = $(this).val();
			$.get( "update.php?id="+id+"&bd="+value, function( data ) {

			});

		});
		
	});
</script>

</body>
</html>






