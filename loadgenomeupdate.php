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
$line=mysql_real_escape_string(rtrim($line));
//echo $line;
//echo "<br>";
    list($geneid, $org,$product,$ortholog,  $symbol, $previd)=explode("\t",rtrim($line));
	
	
	$sql="SELECT id AS geneID, LastChecked FROM `plasmogmdb`.`genes` WHERE `GeneID`='$geneid'";
	$result=mysql_query($sql);
	if(!(mysql_num_rows($result))){
		//echo("A");
	$sql="SELECT id AS geneID,LastChecked FROM  `plasmogmdb`.`genes` WHERE `GeneID`='$geneid.1'";
	$result=mysql_query($sql);
	if(!(mysql_num_rows($result))){
		//echo("B");
	$sql="SELECT id AS geneID,LastChecked FROM  `plasmogmdb`.`genes` WHERE '$previd' LIKE 
  CONCAT('%', `GeneID`, '%')";

	$result=mysql_query($sql);
	
	if(mysql_num_rows($result))
	{
		//echo("C");
$row=mysql_fetch_assoc($result);
		$id=$row['geneID'];
		$sql="SELECT id AS geneID,LastChecked FROM  `plasmogmdb`.`genes` WHERE `id`=$id";
		$result=mysql_query($sql);
	}
	
	}
	}
	
		if((mysql_num_rows($result))){
			$row=mysql_fetch_assoc($result);
		//echo "<br>WOOO";
		//echo $row['geneID'];
		$id=$row['geneID'];
		$lastchecked=$row['LastChecked'];
			$sql2="SELECT id FROM `plasmogmdb`.genesnew WHERE `id`=$id";
			$result2=mysql_query($sql2);
			if(mysql_num_rows($result2)==0){
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
		mysql_query($sql);
		
	
	
	}
	else{
	//	echo"<br>PROBLEM2<br>";
		$sql="INSERT INTO `plasmogmdb`.`genesnew` ( `GeneID`, `Organism`, `Symbol`, `PrevIDs`, `ProdDesc`, `ortholog`) VALUES ( '$geneid', '$org', '$symbol', '$previd', '$product',  '$ortholog') ";
		mysql_query($sql);
		
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
	$result = mysql_query($sql);
$value = mysql_fetch_object($result);
$lastid = $value->id;
$sql="INSERT INTO `plasmogmdb`.`aliasesnew` ( `geneid`,`alias`) VALUES ($lastid,'".implode("'),($lastid,'",$aliases)."') ON DUPLICATE KEY UPDATE alias=alias;";
echo $sql;
mysql_query($sql);
}
}
 include("footer.php") ?>