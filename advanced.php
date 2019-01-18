<?
if($_GET['type']=="csv"|$_POST['type']=="csv"){
	header("Content-Type: application/force-download");
	$filename="phenotype.txt";
header("Content-Disposition: attachment; filename=\"{$filename}\";");
$csv=true;
}
else{
$csv=false;}
 include("header.php")
?>
<?

if(isset($_GET['text'])){
	$_POST=$_GET;
}
if(isset($_POST['text'])){
	
$search=$_POST['genes'];
$search = str_replace("\t", " ", $search); // windows -> unix
$search = str_replace("\r\n", "\n", $search); // windows -> unix
$search = str_replace("\r", "\n", $search);   // remaining -> unix
preg_replace("/ /", '\n', $string);
preg_replace("/[^A-Za-z0-9\.\-\_]/", '\n', $string);
$genes=explode("\n",$search);
$genes=array_filter($genes);
if(count($genes)==0){
	$genesbit="1=1";
}
else{
$genesbit='  (alias = "'.implode('" OR alias="',$genes).'")';}
$text=strtoupper(trim($_POST['text']));
if($text==""){
	$textbit="1=1";
}
else{

	$textbit= '((genes.GeneID="'.$text.'") OR  UPPER(ProdDesc) LIKE "%'.$text.'%" OR UPPER(Symbol) LIKE "%'.$text.'%")';
}

$i=1;
$thearray=array();
while(isset($_POST['approach'.$i])){
	
	$id=$_POST['approach'.$i];
	$include=$_POST['includeapproach'.$i];
	if($include=="on"){$thearray[]="type = $id";
	
	if($id==1){
		$thearray[]="type = 0";
	}}
	
	$i++;
}
$approachbit=implode(" OR ",$thearray);

$i=1;
$thearray=array();
while(isset($_POST['species'.$i])){
	$id=$_POST['species'.$i];
	$include=$_POST['includespecies'.$i];
	if($include=="on"){$thearray[]="Organism = '$id'";}
	
	$i++;
}
$orthspeciesbit=implode(" OR ",$thearray);
$primespecbit= "Organism = '".$_POST['primespecies']."'";
$where='  INNER JOIN aliases ON aliases.geneid = genes.id '."WHERE $genesbit AND $textbit AND $primespecbit";
//echo $approachbit;

if($_POST['includeorths']=="on"){
	$includeorths=true;
	
	
}
else{
	
	$includeorths=false;
}

if($_POST['display']=="all"){
	
	
}
else{
	
	if($includeorths){$where.=" HAVING (phecount>0 OR  orthophecount>0)";}else{$where.=" HAVING phecount>0 ";}
}

if (!$csv){
?>
<div id="page-wrapper">
            <div class="container-fluid">
			<div class="row" style="margin-top:10px;">
			   <div class="col-lg-12">
			
                        <? include("key.php"); ?>
                        
                    
					</div>
					</div>
				
			<h3>Advanced search: <span id="numresults"></span></h3>
                <?}
				include("multisearchinc.php");
				if ($csv){ die(); }?>
                <!-- /.row -->
            </div>
			<script>
				 document.getElementById("numresults").innerHTML="<small><?= $numrows ?> gene<? if($numrows>1){?>s<? }?> found</small>";
				 </script>
            <!-- /.container-fluid -->
        </div>
<?

}
else{
?><div id="page-wrapper">
            <div class="container-fluid">
			<div class="row">
<div class="col-lg-12">
                        <h2 class="page-header">Advanced search</h2>
						
                    </div>
					<div>
					<form action="advanced.php" method="post">
					<div class="form-group">
					<style>label{margin-top:10px;}</style>
					<label>Text to search (leave blank for any): </label>
                                            
                                            <input name="text" />
                                        </div>
					<div class="form-group">
					<label>Gene IDs to search (leave blank for all):</label>
                                            
                                            <textarea class="form-control" rows="3" name="genes"></textarea>
                                        </div>
										
											<div class="form-group">
					<label>Primary species</label>
				<? 	$sql="SELECT Organism FROM genes GROUP BY Organism";
										$result=mysql_query($sql); ?>
										<select name="primespecies">
									<?	  while ($row=mysql_fetch_assoc($result)){?>
									<option 
									
									<? if($row['Organism']=="P. falciparum 3D7" ) {?> selected <? } ?>
									
									value="<?= $row['Organism'] ?>"><?= $row['Organism'] ?></option>
									<? } ?>
										</select>
                                            
                                          
                                        </div>
					<div class="form-group">
					<label>Approaches to include:</label><br />
                                            <?
											$sql="SELECT phenotypeapproaches.id AS id, phenotypeapproaches.longdesc,phenotypeapproaches.short, COUNT(phenotypes.id) AS count FROM phenotypes RIGHT JOIN phenotypeapproaches ON phenotypes.type  = phenotypeapproaches.id GROUP BY phenotypeapproaches.longdesc";
											$result=mysql_query($sql);
											$i=1;
											while ($row=mysql_fetch_assoc($result)){
											?>
											 <input  name="approach<?= $i ?>" type="hidden" value="<?= $row['id'] ?>">
                                            <input checked name="includeapproach<?= $i ?>" type="checkbox"<?
											if($row['count']==0){?> style="color:gray"<?}
											?>> <?= $row['longdesc'] ?></input><br />
<? 
$i++;} ?>
                                        </div>
											<!--<div class="form-group">
										<?
										$sql="SELECT Organism FROM genes GROUP BY Organism";
										$result=mysql_query($sql);
										?>
				<label>Organisms to include:</label><br />
                                           
                                           <?
										    $i=1;
										   while ($row=mysql_fetch_assoc($result)){
											?>
                                            <input name="species<?= $i ?>" type="hidden" value="<?= $row['Organism'] ?>"> <input name="includespecies<?= $i ?>"  type="checkbox" checked><?= $row['Organism'] ?></input><br />
<? 
$i++;} ?>
                                        </div>-->
											<div class="form-group">
					<label>Orthologs</label><br />
                                            
                                            <input type="checkbox" name="includeorths" checked>Include orthologs</input>
                                        </div>
										<label>Display</label><br />
                                            
                                            <input type="radio" name="display" value="phenos" checked> Just display genes with phenotypes<br>
  <input type="radio" name="display" value="all"> Display all genes<br>

                                        </div>
					
					<div class="form-group">
                                            <label>Ouput type</label>
                                            <select class="form-control" name="type">       
                                                <option value="web" selected>Web</option>
                                        <option value="csv">CSV</option>
                                            </select>
                                        </div>
					<button type="submit" class="btn btn-default">Search</button>
					</form>
                    <!-- /.col-lg-12 -->
                </div>
				</div>
<?
}
?>
<? include("footer.php") ?>