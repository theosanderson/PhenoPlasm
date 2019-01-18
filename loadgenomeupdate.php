<? 

include("header.php")
?>
<?
?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">PBANKA_0000101.1

                    <div class="col-lg-12">
                        <h2 class="page-header">Load genome</h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				                <div class="row">
                    <div class="col-lg-12">
                        
						<?
						$filename = 'pvimport.txt';
$contents = file($filename);
$x=0;
foreach($contents as $line) {
$x++;
if($x>$_GET['start']&&$x<$_GET['end']){
$line=mysqli_real_escape_string(rtrim($line));
//echo $line;
//echo "<br>";
    list($geneid, $org,$product,$ortholog,  $symbol, $previd)=explode("\t",rtrim($line));
	
	
	$sql="SELECT id AS geneID, LastChecked FROM `plasmogmdb`.`genes` WHERE `GeneID`='$geneid'";
	$result=mysqli_query($link, $sql);
	if(!(mysqli_num_rows($result))){
		//echo("A");
	$sql="SELECT id AS geneID,LastChecked FROM  `plasmogmdb`.`genes` WHERE `GeneID`='$geneid.1'";
	$result=mysqli_query($link, $sql);
	if(!(mysqli_num_rows($result))){
		//echo("B");
	$sql="SELECT id AS geneID,LastChecked FROM  `plasmogmdb`.`genes` WHERE '$previd' LIKE 
  CONCAT('%', `GeneID`, '%')";

	$result=mysqli_query($link, $sql);
	
	if(mysqli_num_rows($result))
	{
		//echo("C");
$row=mysqli_fetch_assoc($result);
		$id=$row['geneID'];
		$sql="SELECT id AS geneID,LastChecked FROM  `plasmogmdb`.`genes` WHERE `id`=$id";
		$result=mysqli_query($link, $sql);
	}
	
	}
	}
	
		if((mysqli_num_rows($result))){
			$row=mysqli_fetch_assoc($result);
		//echo "<br>WOOO";
		//echo $row['geneID'];
		$id=$row['geneID'];
		$lastchecked=$row['LastChecked'];
			$sql2="SELECT id FROM `plasmogmdb`.genesnew WHERE `id`=$id";
			$result2=mysqli_query($link, $sql2);
			if(mysqli_num_rows($result2)==0){
				$allok=true;
			}
			else{
				$allok=false;
			}
		}
		else{
			$allok=false;
		}
		
	if($allok){
	
		
		//echo "<br>";
		$sql="INSERT INTO `plasmogmdb`.`genesnew` ( `id`,`GeneID`, `Organism`, `Symbol`, `PrevIDs`, `ProdDesc`, `ortholog`,`LastChecked`) VALUES ($id, '$geneid', '$org', '$symbol', '$previd', '$product',  '$ortholog',$lastchecked)";
		mysqli_query($link, $sql);
		
	
	
	}
	else{
	//	echo"<br>PROBLEM2<br>";
		$sql="INSERT INTO `plasmogmdb`.`genesnew` ( `GeneID`, `Organism`, `Symbol`, `PrevIDs`, `ProdDesc`, `ortholog`) VALUES ( '$geneid', '$org', '$symbol', '$previd', '$product',  '$ortholog') ";
		mysqli_query($link, $sql);
		
	}
	echo("<br>".$sql."<br>");
	
	if(trim($previd)!=""&&trim($previd)!="null"){
	$previd.=", ".$geneid;
}
else{
$previd=$geneid;
}
$previd=str_replace("Previous IDs: ","",$previd);
$aliases=explode(", ",$previd);
	$sql="SELECT id FROM genesnew WHERE GeneID='$geneid'";
echo $sql;
	$result = mysqli_query($link, $sql);
$value = mysqli_fetch_object($result);
$lastid = $value->id;
$sql="INSERT INTO `plasmogmdb`.`aliasesnew` ( `geneid`,`alias`) VALUES ($lastid,'".implode("'),($lastid,'",$aliases)."') ON DUPLICATE KEY UPDATE alias=alias;";
echo $sql;
mysqli_query($link, $sql);
}
}
 include("footer.php") ?>