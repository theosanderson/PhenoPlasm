
<? 
//file_put_contents("xml/dump.xml",file_get_contents("http://www.pberghei.eu/csv/rmgm_phenotype_list.php"));
include("header.php");


function trysql($n){
echo($n."<br>");
echo $sql;
	$result=mysql_query($n);
	if (!$result) {
    die('Invalid query: ' . mysql_error());
}
}
$result = mysql_query('SELECT * FROM genes');
$genes = array();
while($row=mysql_fetch_assoc($result)){
$genes[$row['GeneID']]=$row['id'];
}
	
	
$cont=file_get_contents("xml/allMMP.txt");
$lines=explode("/mapdetails",$cont);
foreach($lines as $line){
	list($a,$b,$c)=explode("\t",$line);
	$gene=substr($a,strpos($a,"pfid=")+5,100);
	$id=$genes[strtoupper($gene)];
	//echo $c."<br>";
	$b=trim(substr(str_replace('"', "", $b),4,100000));
	$b=str_replace("\n","<br>",$b);
	$b=mysql_escape_string($b);
	$c=trim($c);
	if($id != ""){
	$sql="INSERT INTO mmp (gene, url,caption,image) VALUES ($id,'$a','$b','$c')";
	trysql($sql);
	}
	}
 ?>
