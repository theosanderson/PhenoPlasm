<?
if (isset($_POST['namer'])){
setcookie(
  "name",
  $_POST['namer'],
  time() + (10 * 365 * 24 * 60 * 60)
);}
if (isset($_POST['institution'])){
setcookie(
  "inst",
  $_POST['institution'],
  time() + (10 * 365 * 24 * 60 * 60)
);}
?>
<? include("header.php")
?>
<?
$result = mysqli_query($link, 'SELECT * FROM genes WHERE GeneID="'.$_GET['gene'].'"');
if (!$result) {
    die('Invalid query: ' . mysqli_error());
}

if($gene=mysqli_fetch_assoc($result)){
?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Help us update: <?= $gene['GeneID']?> <small><?= $gene['ProdDesc']?></small></h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				
				<?
				if(isset($_POST['update']))
				{
					if(isset($_POST['namer']))
				{
					$sql="INSERT INTO localisation (stage,gene_id,localisation,supportid,ip,time,notes,credit,inst,type) VALUES ('".$_POST['stage']."',".$_POST['geneid'].",'".$_POST['localisation']."','".$_POST['pubmed']."','".$_SERVER['REMOTE_ADDR']."',".time().",'".mysqli_real_escape_string($_POST['notes'])."','".mysqli_real_escape_string($_POST['namer'])."','".mysqli_real_escape_string($_POST['institution'])."','".mysqli_real_escape_string($_POST['type'])."')";
					echo $sql;
				mysqli_query($link,  $sql); }
					
					mysqli_query($link, "UPDATE genes SET LastChecked=".time()." WHERE id=".$_POST['geneid'])?>
					<script>

    window.location.assign("/singlegene.php?gene=<?= $gene['GeneID'] ?>")

</script><?
				}
				?>
				
				
				                <div class="row">
                   <div class="col-lg-6"> 
                                    <form role="form" action="/updateloc.php?gene=<?= $_GET['gene'] ?>" method="post">
									<input type="hidden" name="geneid" value="<?= $gene['id']?>" /> <input type="hidden" name="update" value="<?= $gene['id']?>" />
									<div class="form-group">
                                            <label>What stage is the localisation described in?</label>
                                            <select class="form-control" name="stage">
											<?
											$result = mysqli_query($link, 'SELECT * FROM phenotypestages'); 
											while($row=mysqli_fetch_assoc($result)){
											
											?>
                                            <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option><? } ?>
                                                
                                            </select>
                                        </div>
										<div class="form-group">
                                            <label>Where is the protein localised?</label>
											<?
											$result = mysqli_query($link, 'SELECT * FROM localisations'); 
											while($row=mysqli_fetch_assoc($result)){
											
											?>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio"  onclick="handleClick(this);" name="localisation" id="optionsRadios<?= $row['id'] ?>" value="<?= $row['id'] ?>"><?= $row['name'] ?></label>
</div><? } ?>
                                            
                                        </div>
										
										
                                  
										<div class="form-group">
                                            <label>What type of experimental approach was used?</label>
                                            <select name="type" class="form-control">
                                                <option value="1">Fluorescent-protein fusion</option>
                                                <option value="2">Epitope tag and IFA</option>
                                                <option value="3">Immunofluoresence of native protein</option>
                                                <option value="4">Proteomics</option>
                                                <option value="5">Other</option>
                                            </select>
                                        </div>
										 <div class="form-group">
                                            <label>Is there anything extra you would like to add?</label>
                                            <input name="notes" class="form-control">
                                            <p class="help-block">E.g. aberrant morphologhy, specific defects, etc.</p>
                                        </div>				
                                        <div class="form-group">
                                            <label>What is the PubMed ID that includes this phenotype?</label>
                                            <input name="pubmed" class="form-control">
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Your name</label>
                                            <input name="namer" class="form-control" value="<?
							if (isset($_COOKIE['name'])){echo $_COOKIE['name'];}				?>">
							<p class="help-block">So we can credit you for your contribution</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Your institution, if any</label>
                                            <input name="institution" class="form-control" value="<?
							if (isset($_COOKIE['inst'])){echo $_COOKIE['inst'];}				?>">
                                        </div>
                                        <button type="submit" class="btn btn-default">Submit Phenotype</button>
                                       
                                    </form>
                                </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
<?
}
else{
?><div id="page-wrapper">
            <div class="container-fluid">
			<div class="row">
 <div class="col-lg-4" style="margin-top:30px">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Error
                        </div>
                        <div class="panel-body">
                            <p>No gene found called <?= $_GET['gene'] ?>.</p>
                        </div>
                        <div class="panel-footer">
                            Sorry..
                        </div>
                    </div>
					</div>
					</div>
					</div>
<?
}
?>
<? include("footer.php") ?>