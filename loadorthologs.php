<? include("header.php")
?>
<?
?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Load PlasmoGEM data</h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				                <div class="row">
                    <div class="col-lg-12">
                        
						<?
						function trysql($n)
{
echo($n."<br>");
	$result=mysqli_query($link, $n);
	if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
}

	


$result = mysqli_query($link, 'SELECT * FROM genes');
$genes = array();
while($row=mysqli_fetch_assoc($result)){
$genes[$row['GeneID']]=$row['id'];
}
//print_r($genes);



						$filename = 'Orthologs.txt';
$contents = file($filename);
$x=0;
$sql="";
foreach($contents as $line) {
$x++;

if($x>$_GET['start']&&$x<$_GET['end']){
$line=mysqli_real_escape_string(rtrim($line));
    list($destination,$commas)=explode("\t",rtrim($line));
	
	$sources=explode(",",rtrim($commas));
	$destid=$genes[$destination];
	if($destid=="")
	{echo($destination."\n");}
else{
	foreach($sources as $source){
		$sourceid=$genes[$source];
		if($sourceid=="")
	{echo("");}else{
 $sql.="($sourceid, $destid),\n";}
	}
	}
	
	

	
}}
$sql.="(0,0)";
	mysqli_query($link, "INSERT INTO orthlinks (source, dest) VALUES ".$sql);
						?>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

<? include("footer.php") ?>