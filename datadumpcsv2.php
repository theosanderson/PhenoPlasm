<? 
header('Content-Disposition: attachment; filename="PhenoPlasmData.tsv"');
$csv=true;
include("header.php");
include("establishlocalisations.php");

?><? 			$result = mysqli_query('SELECT * FROM phenotypes INNER JOIN genes ON phenotypes.gene_id=genes.id ORDER BY Organism,GeneID');
						?><?
						$tablestarted=0;
						function tablestart(){
						global $tablestarted;
						$tablestarted=1;
						?>Species	Gene	Stage	phenotypes	Reference	Submitter	Notes
<?
									}
						?><? if(mysqli_num_rows($result)>0){
						tablestart();
						$gene=array();
						$gene['GeneID']="abc";
					
									
						
									while($row=mysqli_fetch_assoc($result)){
									?><?= $row['Organism'] ?>	<?= $row['GeneID'] ?>	<?= stage($row['stage'])?>	<?= pheref($row['phenotype'])?>	<?= $row['supportid'];?>	<? if($row['typeofsupport']==1){?>Imported from RMGMdb<? } else{ ?><?= $row['credit']?> <?= $row['inst']?><? } ?>	<?= $row['notes']?>

<? }
                                     
                                   
						}
						
						?>