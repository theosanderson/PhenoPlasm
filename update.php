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
                        <h2 class="page-header">Add a phenotype: <?= $gene['GeneID']?> <small><?= $gene['ProdDesc']?></small></h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				
				
				<?
				if(isset($_POST['update']))
				{
					if(isset($_POST['namer']))
				{
				
for( $i=0; $i<100; $i++ )
{

    if(isset($_POST['stage'.$i])&&$_POST['stage'.$i]!=0){
	if($_POST['type']==1||$i>0){
	$sql="INSERT INTO phenotypes (stage,gene_id,phenotype,supportid,ip,time,notes,credit,inst,type) VALUES ('".$i."',".$_POST['geneid'].",'".$_POST['stage'.$i]."','".$_POST['pubmed']."','".$_SERVER['REMOTE_ADDR']."',".time().",'".mysqli_real_escape_string($link,$_POST['notes'])."','".mysqli_real_escape_string($link,$_POST['namer'])."','".mysqli_real_escape_string($link,$_POST['institution'])."','".mysqli_real_escape_string($link,$_POST['type'])."')";
mysqli_query($link,  $sql); 
}
	}
}
					
				}
					
					mysqli_query($link, "UPDATE genes SET LastChecked=".time()." WHERE id=".$_POST['geneid'])?>
		    <? if(!(isset($_COOKIE['debug_mode']))){ ?>
					<script>

    window.location.assign("/singlegene.php?gene=<?= $gene['GeneID'] ?>")

</script><?
					}
			  else{
				  print($sql);
			  }
				}
				?>
				
				
				                <div class="row">
                   <div class="col-lg-6"> 
				   <div class="panel panel-default">
                       <!-- <div class="panel-heading">
                           Approach
                        </div>-->
                        <div class="panel-body">
                                    <form role="form" action="/update.php?gene=<?= $_GET['gene'] ?>" method="post">
									<input type="hidden" name="geneid" value="<?= $gene['id']?>" /> <input type="hidden" name="update" value="<?= $gene['id']?>" />
									<div class="form-group">
                                            <label>What type of experimental approach was used?</label>
                                            <select onchange="handleChange(this);" name="type" class="form-control">
                                                <option value="1">Conventional knock-out</option>
                                                <option value="2">Conditional approach</option>
                                                <option value="3">Barseq</option>
                                                <option value="4">Insertional mutagenesis</option>
                                                <option value="5">Promoter-swap</option>
												<option value="6">Knock down</option>
												<option value="7">Spontaneous/natural deletion</option>
						    <option value="8">Knock-sideways</option>
						    <option value="9">DiCre</option>
						    
                                            </select>
                                        </div>
										<script>
									
function handleClick(bla) {


   if(bla.value=="8"){
	   $('#stages').fadeIn();
   };
   if(bla.value=="7"){
	   $('#stages').fadeOut();
	   $('.stagebox').val(0);
   };
}

function handleChange(bla) {


   if(bla.value==1){
	   $('#generated').fadeIn();
	   $('#optionsRadios1').attr('checked', true);
	   
   }else{
	   $('#generated').fadeOut();
	     $('#stages').fadeIn();
	  
   };
}
</script>
										<div class="form-group" id="generated">
                                            <label>Could a mutant be generated?</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio"  onclick="handleClick(this);" name="stage0" id="optionsRadios1" value="8">Yes
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio"  onclick="handleClick(this);"  name="stage0" id="optionsRadios2" value="7" checked="">No
                                                </label>
                                            </div>
                                            
                                        </div>
										</div></div>
<div class="panel panel-default" id="stages" style="display:none">
                        <div class="panel-heading">
                            Phenotypes
                        </div>
                        <div class="panel-body">
                           
                        
<?
											$result = mysqli_query($link, 'SELECT * FROM phenotypestages WHERE id>0'); 
											while($row=mysqli_fetch_assoc($result)){
											
											?>
                                            
											<div class="form-group">
                                            <label><?= $row['name'] ?></label>
                                            <select class="form-control stagebox" name="stage<?= $row['id'] ?>">
											<option value="0" selected>Not tested/reported</option>
											<?$result2 = mysqli_query($link, 'SELECT * FROM phenotyperefs'); 
											while($row2=mysqli_fetch_assoc($result2)){
											
											?>
                                           <option value="<?=$row2['id']?>"><?=$row2['name']?></option><? } ?>
                                                
                                            </select>
                                        </div>
											
											
											<? } ?>
											    </div>
											
                    </div>
											
										<div class="form-group" id="attenuated" style="display:none">
                                            <label>Is the parasite attenuated at this stage?</label>
                                      
											
                                            
                                        </div>
										<div class="panel panel-default">
                        <!--<div class="panel-heading">
                           Approach
                        </div>-->
                        <div class="panel-body">
										 <div class="form-group">
                                            <label>Extra notes:</label>
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
                                       </div></div>
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
