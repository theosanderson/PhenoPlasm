<? 
include("header.php");
include("establishlocalisations.php");
?>
<?


?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12"> 
                       <h2>All phenotype data</h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				                <div class="row">
                    <div class="col-lg-12">
                        <h4><i class="fa fa-flask fa-fw"></i> Mutant phenotypes <small>[<a href="update.php?gene=<?= $gene['GeneID']?>">+</a>]</h4>
						<? 			$result = mysql_query('SELECT * FROM phenotypes INNER JOIN genes ON phenotypes.gene_id=genes.id ORDER BY Organism,GeneID');
						?>
						<?
						$tablestarted=0;
						function tablestart(){
						global $tablestarted;
						$tablestarted=1;
						?>
					
						
						<div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
										<th>Species</th>
											<th>Gene</th>
                                            <th>Stage</th>
                                            <th>Phenotype</th>
                                            <th>Reference</th>
                                            <th>Submitter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
								
									<?
									}
						?>
						<? if(mysql_num_rows($result)>0){
						tablestart();
						$gene=array();
						$gene['GeneID']="abc";
					
									
						
									while($row=mysql_fetch_assoc($result)){
									?>
									
                                        <tr>
										<td><?= $row['Organism'] ?></td>
										<td><a href="/singlegene.php?gene=<?= $row['GeneID'] ?>"><?= $row['GeneID'] ?></a></td>
                                            <td><?= stage($row['stage'])?></td>
                                            <td><div style="width:20px; text-align:center; float:left"><?= pheref2($row['phenotype'])?></div>
											 <?= pheref($row['phenotype'])?></td>
                                            <td><? printsupport($row['typeofsupport'],$row['supportid']);?></td>
                                            <td><? if($row['typeofsupport']==1){?><span style="color:gray">Imported from RMGMdb</span><? }<? elseif($row['typeofsupport']==2){?><span style="color:gray">Imported from PlasmoGEM</span><? } else{ ?>
											<?= $row['credit']?>, <?= $row['inst']?><? } ?></td>
                                        </tr>
										<? }
                                     
                                   
						}
						
						?>
					
										
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
<?

?>
<? include("footer.php") ?>