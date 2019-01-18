<? 
header('Content-Disposition: attachment; filename="PhenoPlasmData.csv"');
$csv=true;
include("header.php");
include("establishlocalisations.php");

?><? 			$result = mysqli_query('SELECT * FROM phenotypes INNER JOIN genes ON phenotypes.gene_id=genes.id ORDER BY Organism,GeneID');
						?><?
						$tablestarted=0;
						function tablestart(){
						global $tablestarted;
						$tablestarted=1;
						?>Species,Gene,Stage,Phenotype,Reference,Submitter
<?
									}
						?><? if(mysqli_num_rows($result)>0){
						tablestart();
						$gene=array();
						$gene['GeneID']="abc";
					
									
						
									while($row=mysqli_fetch_assoc($result)){
									?><?= $row['Organism'] ?>,<?= $row['GeneID'] ?>,<?= stage($row['stage'])?>,<?= pheref($row['phenotype'])?>,<?= $row['supportid'];?>,<? if($row['typeofsupport']==1){ ?>RMgmDB<? } elseif($row['typeofsupport']==2){?>PlasmoGEM<? }elseif($row['typeofsupport']==3){ ?>USF PiggyBac Screen<? }else{ ?><?= $row['credit']?>- <?= $row['inst']?><? } ?>

<? }
                                     
                                   
						}
						
						?>