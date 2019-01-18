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
	$result=mysqli_query($n);
	if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
}
function checkandadd($id,$phenotype,$stage,$gene,$rgr,$low,$high)
{


if($low=="NA"){$low=-1;}
if($high=="NA"){$high=-1;}
trysql("INSERT INTO phenotypes (type,gene_id,typeofsupport,supportid,stage,phenotype,	phenotypevalue,	phenotypevaluelow,	phenotypevaluehigh) VALUES (3,$id,2,'$gene',$stage,$phenotype,$rgr,$low,$high)");

}

	


$result = mysqli_query('SELECT * FROM genes');
$genes = array();
while($row=mysqli_fetch_assoc($result)){
$genes[$row['GeneID']]=$row['id'];
}
//print_r($genes);



						$filename = 'plasmogemimport.csv';
$contents = file($filename);
$x=0;
foreach($contents as $line) {
$x++;
if($x>$_GET['start']&&$x<$_GET['end']){
$line=mysqli_real_escape_string(rtrim($line));
    list($rodentid,$rgr,$pheno,$low,$high)=explode(",",rtrim($line));
	
	
	$id=$genes[$rodentid];
	if($id!=""){
	if($pheno=="Essential"){
		checkandadd($id,7,0,$rodentid,$rgr,$low,$high);
		
		
	}
	elseif($pheno=="Slow"){
		
		checkandadd($id,4,1,$rodentid,$rgr,$low,$high);
		if($rgr>0.5){checkandadd($id,8,0,$rodentid,$rgr,$low,$high);}
		
		
	}
	elseif($pheno=="Dispensable"){
		checkandadd($id,8,0,$rodentid,$rgr,$low,$high);
		if($low>0.8){checkandadd($id,2,1,$rodentid,$rgr,$low,$high);}
		
	}
	elseif($pheno=="Fast"){
		checkandadd($id,8,0,$rodentid,$rgr,$low,$high);
		
		
	}
	
	
	}
	else{
	print "<br><strong>GENE NOT FOUND FOR $rodentid</strong><br><br>";
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