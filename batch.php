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
if(isset($_POST['genes'])){
$_GET['genes']=$_POST['genes'];
}
if($_GET['genes']){
$search=$_GET['genes'];
$search=stripcslashes($search);
$search = str_replace("\t", " ", $search); // windows -> unix
$search = str_replace("\r\n", "\n", $search); // windows -> unix
$search = str_replace("\r", "\n", $search);   // remaining -> unix
preg_replace("/ /", '\n', $string);
preg_replace("/[^A-Za-z0-9\.\-\_]/", '\n', $string);
$genes=explode("\n",$search);
$genes=array_filter($genes);
//print_r($genes);
//$query='SELECT * FROM genes WHERE CONCAT(", ",PrevIDs,", ",GeneID,", ") LIKE "%, '.implode(', %" OR CONCAT(", ",PrevIDs,", ",", ",GeneID) LIKE "%, ',$genes).', %"';
$where='  INNER JOIN aliases ON aliases.geneid = genes.id '.'WHERE alias = "'.implode('" OR alias="',$genes).'"';
if (!$csv){
?>
<div id="page-wrapper">
            <div class="container-fluid">
			<h3>Batch search: <span id="numresults"></span></h3>
			<div class="row">
                    <div class="col-lg-10">
			
                        <? include("key.php"); ?>
                        
                    
					</div>
					</div>
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
                        <h2 class="page-header">Batch search</h2>
						
                    </div>
					<div>
					<form action="batch.php" method="post">
					<div class="form-group">
					
                                            <label>Gene IDs, one per line:</label>
                                            <textarea class="form-control" rows="3" name="genes"></textarea>
                                        </div>
					
					<div class="form-group">
                                            <label>Output type</label>
                                            <select class="form-control" name="type">       
                                                <option value="web" selected>Web</option>
                                        <option value="csv">Tab-separated text file</option>
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