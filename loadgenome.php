<? include("header.php")
?>
<?
?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Load genome</h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				                <div class="row">
                    <div class="col-lg-12">
                        
						<?
						$filename = 'plasmodb.txt';
$contents = file($filename);
$x=0;
foreach($contents as $line) {
$x++;
if($x>$_GET['start']&&$x<$_GET['end']){
$line=mysqli_real_escape_string(rtrim($line));
    list($geneid, $org, $symbol, $previd, $product, $ortholog)=explode("\t",rtrim($line));
	$sql="INSERT INTO `plasmogmdb`.`genes` ( `GeneID`, `Organism`, `Symbol`, `PrevIDs`, `ProdDesc`, `ortholog`) VALUES ( '$geneid', '$org', '$symbol', '$previd', '$product',  '$ortholog') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id), Organism= '$org', Symbol= '$symbol', PrevIDs= '$previd', ProdDesc = '$product', ortholog= '$ortholog';";
	$lastid= mysqli_insert_id();
	
	
	echo($sql."<br>");
	$result=mysqli_query($sql);
	if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
if(trim($previd)!=""&&trim($previd)!="null"){
	$previd.=", ".$geneid;
}
else{
$previd=$geneid;
}
$aliases=explode(", ",$previd);
	$sql="SELECT id FROM genes WHERE GeneID='$geneid'";
	$result = mysqli_query($sql);
$value = mysqli_fetch_object($result);
$lastid = $value->id;
$sql="INSERT INTO `plasmogmdb`.`aliases` ( `geneid`,`alias`) VALUES ($lastid,'".implode("'),($lastid,'",$aliases)."') ON DUPLICATE KEY UPDATE alias=alias;";
echo($sql."<br>");
	
	$result=mysqli_query($sql);
	if (!$result) {
    echo('<br><strong>Invalid query: ' . mysqli_error()."</strong><br>");

}
}
}
						?>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

<? include("footer.php") ?>