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
						function trysql($n)
{
echo($n."<br>");
	$result=mysqli_query($n);
	if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
}
function checkandadd($phenotype,$stage)
{
global $rmid,$rodentid, $id;
if($phenotype=="X"){
$finalphen=3;
trysql("INSERT INTO phenotypes (gene_id,typeofsupport,supportid,stage,phenotype) VALUES ($id,1,'$rmid',$stage,$finalphen)");

}
if($phenotype=="nd"){
$finalphen=2;
trysql("INSERT INTO phenotypes (gene_id,typeofsupport,supportid,stage,phenotype) VALUES ($id,1,'$rmid',$stage,$finalphen)");

}
	




}
					$result = mysqli_query('SELECT * FROM genes');
$genes = array();
while($row=mysqli_fetch_assoc($result)){
$genes[$row['GeneID']]=$row['id'];
}
//print_r($genes);



						$filename = 'AllRMGMdb.txt';
$contents = file($filename);
$x=0;
foreach($contents as $line) {
$x++;
if($x>$_GET['start']&&$x<$_GET['end']){
$line=mysqli_real_escape_string(rtrim($line));
    list(,$rmid,$rodentid,,$success,$trydisrupt,,,,$asex,$game,$fert,$oocy,$spor,$live)=explode("\t",rtrim($line));
	if(substr($rodentid,0,4)=="PBAN"){
	$rodentid=substr($rodentid,0,13);
	}
	if($trydisrupt=="x"){
	$id=$genes[$rodentid];
	if($id!=""){
	//echo $rodentid.$id;
	if($success=="no")
	{
	
	trysql("INSERT INTO phenotypes (gene_id,phenotype,typeofsupport,supportid,stage) VALUES ($id,7,1,'$rmid',0)");
	}
	else{
	trysql("INSERT INTO phenotypes (gene_id,phenotype,typeofsupport,supportid,stage) VALUES ($id,8,1,'$rmid',0)");
	checkandadd($asex,1);
	checkandadd($game,2);
	checkandadd($fert,3);
	checkandadd($oocy,4);
	checkandadd($spor,5);
	checkandadd($live,6);
	
	}
	}
	else{
	print "<br><strong>GENE NOT FOUND FOR $rodentid</strong><br><br>";
	}
	
	}
}}
						?>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

<? include("footer.php") ?>