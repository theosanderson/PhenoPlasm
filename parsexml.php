
<? 
file_put_contents("xml/dump.xml",file_get_contents("http://www.pberghei.eu/csv/rmgm_phenotype_list.php"));
include("header.php");

$result=mysqli_query($link, "SELECT CONVERT(MID(supportid,6,20), UNSIGNED INTEGER) AS rmid FROM `phenotypes` WHERE typeofsupport=1 ORDER BY rmid DESC LIMIT 1");
$num=mysqli_result ($result,0);

function trysql($n){
echo($n."<br>");
echo $sql;
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

$xml=file_get_contents("xml/dump.xml");
$xml = preg_replace('/[[:^print:]]/', '', $xml); 
$data = new SimpleXMLElement($xml);


function checkandadd($phenotype,$stage)
{
global $rmid,$rodentid, $id;
$rmid2="RMgm-".$rmid;
$safepheno=mysqli_real_escape_string($phenotype);
if(strlen($phenotype)>0&$phenotype!="Not tested"){

if($phenotype=="Not different from wild type"){
$finalphen=2;
trysql("INSERT INTO phenotypes (gene_id,typeofsupport,supportid,stage,phenotype,time) VALUES ($id,1,'$rmid2',$stage,$finalphen,".time().")");

}

else{
	$finalphen=3;
trysql("INSERT INTO phenotypes (gene_id,typeofsupport,supportid,stage,phenotype,notes,time) VALUES ($id,1,'$rmid2',$stage,$finalphen,'$safepheno',".time().")");
}
}

	




}

foreach ($data->rmgm as $entry) {
 
   
   $count=$entry->modifications->modification->count();
   
 //  echo $count;
   if($count==1){
	   
	    $type=$entry->modifications->modification->mod_type;
 if ($type=="disrupted"){
   $rmid=$entry->rmgmid;
   $rmid2="RMgm-".$rmid;
   if($rmid>$num & ($rmid<1601 | $rmid>4055 )& $rmid != 4134 & ($rmid<4195 | $rmid>4311)){
    $gene= (string) $entry->modifications->modification->gene_model_pberghei;
	
	$id=$genes[strtoupper($gene)];
	
	$pheasexual=$entry->phenotype->phenotype_asexual;
	$phegam=$entry->phenotype->phenotype_gametocyte;
	$pheook=$entry->phenotype->phenotype_ookinete;
	$pheoocyst=$entry->phenotype->phenotype_oocyst;
	$phesporo=$entry->phenotype->phenotype_sporozoite;
	$pheliver=$entry->phenotype->phenotype_liverstage;
	$success=$entry->success_of_genetic_modification;
	if($success=="no")
	{
	
	trysql("INSERT INTO phenotypes (gene_id,phenotype,typeofsupport,supportid,stage,time) VALUES ($id,7,1,'$rmid2',0,".time().")");
	}
	else{
		trysql("INSERT INTO phenotypes (gene_id,phenotype,typeofsupport,supportid,stage,time) VALUES ($id,8,1,'$rmid2',0,".time().")");
	checkandadd($pheasexual,1);
	checkandadd($phegam,2);
	checkandadd($pheook,3);
	checkandadd($pheoocyst,4);
	checkandadd($phesporo,5);
	checkandadd($pheliver,6);
	}
	
   }
  }
   }
}


 ?>