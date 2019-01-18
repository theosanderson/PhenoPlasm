<? include("header.php");
include("establishlocalisations.php");
?>
<?
$result = mysqli_query($link, 'SELECT * FROM genes WHERE GeneID="'.$_GET['gene'].'"');
if (!$result) {
    die('Invalid query: ' . mysqli_error($link));
}

if($gene=mysqli_fetch_assoc($result)){
?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12"> 
                        <h2 class="page-header"><?= $gene['GeneID']?> <small><?= $gene['ProdDesc']?><?
						if($gene['Symbol']!="null"){?> (<?= $gene['Symbol']?>) <?
							
						}						
						
						?>
						
						</small></h2>
						<center style="color:gray"><?
						if($gene['LastChecked']>0){?>
						Last updated <?= time_passed($gene['LastChecked']) ?><? }else{?>
						<!--<strong style="color:red">Note: nobody has yet searched the literature for mutant phenotypes for this gene. Please do search, and either <a href="update.php?gene=<?= $gene['GeneID']?>">add a phenotype</a>, or  <form name="form" action="update.php?gene=<?= $gene['GeneID']?>" method="post" style="display:inline"><input type="hidden" name="geneid" value="<?= $gene['id'] ?>"><input type="hidden" name="update" value="<?= $gene['id'] ?>"><a onclick="form.submit();" style="cursor:pointer">click here</a></form> to say that you searched and found nothing. </strong>-->
					<?	} ?>
						</center>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				                <div class="row">
                    <div class="col-lg-12">
					
					<h4><i class="fa fa-bullseye fa-fw"></i> Disruptability <small>[<a href="update.php?gene=<?= $gene['GeneID']?>">+</a>]</small></h4>
						<? 			$result = mysqli_query($link, 'SELECT * FROM phenotypes INNER JOIN genes ON phenotypes.gene_id=genes.id WHERE gene_id="'.$gene['id'].'" AND stage=0 ORDER BY stage');
						?>
						<?
						$tablestarted=0;
						function tablestart($stage){
						global $tablestarted;
						$tablestarted=1;
						?>
					
						
						<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
										<th>Species</th>
                                            <? if($stage==true){?><th>Stage</th><? } ?>
                                            <? if($stage==true){?><th>Phenotype</th><? }else{?><th>Disruptability</th><? } ?> 
                                            <th>Reference</th>
                                            <th>Submitter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								
									<?
									}
						?>
						
						<? 
						$stage=false;
						if(mysqli_num_rows($result)>0){
							
						tablestart(false);
						include("phenotypetable.php");
						}
						
						$result=mysqli_query($link, "SELECT DISTINCT g2.*,phenotypes.* FROM (phenotypes INNER JOIN ((genes as g1 INNER JOIN orthlinks ON g1.id = orthlinks.source) INNER JOIN genes AS g2 ON orthlinks.dest = g2.id) ON g2.id=phenotypes.gene_id )INNER JOIN orthcounts ON g1.id=orthcounts.source AND g2.Organism=orthcounts.Organism  WHERE  count=1 AND  g1.id=".$gene['id']." AND stage=0  ORDER BY stage");
		
		if(mysqli_num_rows($result)>0){
		if($tablestarted==0){tablestart(false);}
		?>
		<tr style="height:3px">
                                            <td colspan="5" style="background-color:white; text-align:center;"></td>
                                            
                                        </tr>
		<?
			include("phenotypetable.php");
			}
			if($tablestarted){
			?>
			 </tbody>
                                </table>
                            </div><? }
							else{
							?>No information reported yet. Please press the '+' button above to add some.
							<?}?></div>
							</div>
					
                        <h4 style="margin-top:20px;"><i class="fa fa-gear fa-fw"></i> Mutant phenotypes <small>[<a href="update.php?gene=<?= $gene['GeneID']?>">+</a>]</small></h4>
						<? 			$result = mysqli_query($link, 'SELECT * FROM phenotypes INNER JOIN genes ON phenotypes.gene_id=genes.id WHERE gene_id="'.$gene['id'].'" AND stage!=0  ORDER BY stage');
						?>
						<?
						$tablestarted=0;
						
						?>
						
						<? 
						$stage=true;
						if(mysqli_num_rows($result)>0){
						tablestart(true);
						
						include("phenotypetable.php");
						}
						
						$result=mysqli_query($link, "SELECT DISTINCT g2.*,phenotypes.* FROM (phenotypes INNER JOIN ((genes as g1 INNER JOIN orthlinks ON g1.id = orthlinks.source) INNER JOIN genes AS g2 ON orthlinks.dest = g2.id) ON g2.id=phenotypes.gene_id) INNER JOIN orthcounts ON g1.id=orthcounts.source AND g2.Organism=orthcounts.Organism  WHERE  count=1 AND g1.id=".$gene['id']." AND stage!=0  ORDER BY stage");
		
		if(mysqli_num_rows($result)>0){
		if($tablestarted==0){tablestart(true);}
		?>
		<tr style="height:3px">
                                            <td colspan="5" style="background-color:white; text-align:center;"></td>
                                            
                                        </tr>
		<?
			include("phenotypetable.php");
			}
			if($tablestarted){
			?>
			 </tbody>
                                </table>
                            </div><? }
							else{
							?>None reported yet. Please press the '+' button above to add one.
							<?}?>
					
					<? if(!isset($_COOKIE['loc'])){ ?> <!-- <? } ?>
					<div class="col-lg-12">
                        <h4  style="margin-top:20px"><i class="fa fa-crosshairs fa-fw"></i> Localisation <small>[<a href="updateloc.php?gene=<?= $gene['GeneID']?>">+</a>]</small></h4>
						<? 			$result = mysqli_query($link, 'SELECT * FROM localisation  INNER JOIN localisations ON localisations.id=localisation.localisation WHERE gene_id="'.$gene['id'].'"');
						
						if(mysqli_num_rows($result)>0){?>
						
						<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Stage</th>
                                            <th>Localised to</th>
                                            <th>Reference</th>
                                            <th>Submitter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									
						<? 
									while($row=mysqli_fetch_assoc($result)){
										
										
									?>
									
                                        <tr>
                                            <td><?= stage($row['stage'])?></td>
                                            <td><?= $row['name']?></td>
                                            <td><? printsupport($row['typeofsupport'],$row['supportid'])?>
											
											</td>
                                            <td><?= $row['credit']?>, <?= $row['inst']?></td>
                                        </tr>
										<? } ?>
                                     
                                    </tbody>
                                </table>
                            </div><? }
							else{
							?>None reported yet.
							<?}?>
						
                    </div>

					<? if(!isset($_COOKIE['loc'])){ ?>--> <? } ?>

					
					<style>
					img.ifaimage{height:18vh; max-width: 100%;}
					p.cap{font-size:70%;margin-top: 10px;}
				</style>
				

					<?
					function imageItem($caption,$url,$image){
						$image=substr($image,56,1000);
						?>
						<div>
							
							<a href="cachedimg.php?file=<?= $image ?>" 
							data-lightbox="image-<?= $image ?>" data-title="<?= $caption ?>"
							><img class="ifaimage" src="cachedimg.php?file=<?= $image ?>" style="display:block"/> </a>
							<p class="cap"><?= $caption ?></p>
							<? 
							$caption= str_replace("\n", "<br>", $caption)
							?>
							<a href="http://mpmp.huji.ac.il/MapDetails/<?= $url ?>" style="padding-bottom:15px;margin-bottom:15px; display:block; border-bottom:1px solid gray;">See original on MMP</a>

						</div>
						<?
					}
					$result=mysqli_query($link, "SELECT DISTINCT g2.*,mmp.* FROM (mmp INNER JOIN ((genes as g1 INNER JOIN orthlinks ON g1.id = orthlinks.source) INNER JOIN genes AS g2 ON orthlinks.dest = g2.id) ON g2.id=mmp.gene )INNER JOIN orthcounts ON g1.id=orthcounts.source AND g2.Organism=orthcounts.Organism  WHERE  count=1 AND  g1.id=".$gene['id']);
					
					$result2=mysqli_query($link, "SELECT * FROM mmp WHERE gene=".$gene['id']);
					if(mysqli_num_rows($result)+mysqli_num_rows($result2)>0){
						?>
						<div class="row">
						<div class="col-lg-12" style="margin-top:20px">
					<h4><i class="fa fa-picture-o fa-fw"></i> Imaging data <small>(from Malaria Metabolic Pathways) </small></h4>
						<?
					}
					while($row=mysqli_fetch_assoc($result)){
						imageItem($row['caption'],$row['url'],$row['image']);
					}
					while($row=mysqli_fetch_assoc($result2)){
						imageItem($row['caption'],$row['url'],$row['image']);
					}
					if(mysqli_num_rows($result)+mysqli_num_rows($result2)>0){
						?>
						</div></div>
						<?
					}
					?>
				
				<div class="row">
						<div class="col-lg-12" style="margin-top:20px">
                        <h4><i class="fa fa-sign-out fa-fw"></i> More information</h4>
						<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>

                                     
                                    <tbody>
								
									<tr>
                                            <td style="width:200px">PlasmoDB</td>
                                            <td><a href="http://plasmodb.org/gene/<?= $gene['GeneID']?>"><i class="fa fa-arrow-right fa-fw"></i><?= $gene['GeneID']?></a></td>
                                            
                                        </tr>
											<tr>
                                            <td>GeneDB</td>
                                            <td><a href="http://genedb.org/gene/<?= $gene['GeneID']?>"><i class="fa fa-arrow-right fa-fw"></i><?= $gene['GeneID']?></a></td>
                                            
                                        </tr>
										
                                        <tr>
                                            <td>Malaria Metabolic Pathways</td>
                                            <td><a href="http://mpmp.huji.ac.il/MapDetails/Pfid?pfid=<?= $gene['GeneID']?>"><i class="fa fa-arrow-right fa-fw"></i>Localisation images</a><Br><a href="http://mpmp.huji.ac.il/Search/PFID?Length=6?Length=6&pfid=<?= $gene['GeneID']?>"><i class="fa fa-arrow-right fa-fw"></i>Pathways mapped to</a></td>
                                            
                                        </tr>
											<tr>
                                            <td>Previous ID(s)</td>
                                            <td><?= $gene['PrevIDs']?></td>
                                            
                                        </tr>
										<tr>
                                            <td>Orthologs</td>
                                            <td><?
										$result = mysqli_query($link, 'SELECT  g2.GeneID AS orthgene FROM ((genes as g1 INNER JOIN orthlinks ON g1.id = orthlinks.source) INNER JOIN genes AS g2 ON orthlinks.dest = g2.id) INNER JOIN orthcounts ON g1.id=orthcounts.source AND g2.Organism=orthcounts.Organism WHERE count>0 AND g1.id ='.$gene['id']);
										while($row=mysqli_fetch_assoc($result)){
										if($comma){
										?>, <?
										}
										$comma=1;
										?><a href="/singlegene.php?gene=<?=$row['orthgene']?>"><?=$row['orthgene']?></a> 
										<?
										}
										?></td>
                                            
                                        </tr>
										<tr>
                                            <td>Google Scholar</td>
                                            <td> <?

										$list=explode(", ",$gene['PrevIDs']);
										
										$list[]=$gene['GeneID'];
										
										?><a href='https://scholar.google.co.uk/scholar?q="<?= implode("\" OR \"",$list) ?>"'><i class="fa fa-arrow-right fa-fw"></i>Search for all mentions of this gene</a>
										</td>
                                            
                                        </tr>
										
										 
										
                                     
                                    </tbody>
                                </table>
                            </div>
							
					
										
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </Br></div>
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
