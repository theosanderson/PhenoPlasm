<?
if($_GET['type']=="csv"|$_POST['type']=="csv"){
$csv=true;
}
else{
$csv=false;}
if(!isset($includeorths)){
	$includeorths=true;	
}
$query="SELECT DISTINCT genes.*, bla2.*";
 if($includeorths){
	 $query.=",orthologpheno.*";
 }
	$query.=" FROM 

genes 


 LEFT JOIN 
 (SELECT COUNT(time) AS phecount, GROUP_CONCAT(phenotype SEPARATOR ',') AS phenotype, GROUP_CONCAT(stage SEPARATOR ',') AS phenotypestage, gene_id AS phegid FROM phenotypes ";
 
  if(isset($approachbit)){
	  $query.=" WHERE $approachbit";
  }
  
  $query.=" GROUP BY gene_id ) bla2 
 
 ON genes.id=bla2.phegid ";
 
 if($includeorths){
	 
 $query.="LEFT JOIN ( SELECT COUNT(time) AS orthophecount, GROUP_CONCAT(orthgene.GeneID SEPARATOR ',') AS orthogeneid,GROUP_CONCAT(phenotype SEPARATOR ',') AS orthophenotype, GROUP_CONCAT(stage SEPARATOR ',') AS orthophenotypestage, genes.id AS geneid FROM phenotypes INNER JOIN genes AS orthgene ON orthgene.id=phenotypes.gene_id  INNER JOIN orthlinks ON orthlinks.dest=phenotypes.gene_id INNER JOIN genes on genes.id=orthlinks.source INNER JOIN orthcounts ON orthcounts.count=1 AND orthcounts.source=genes.id AND orthcounts.Organism=orthgene.Organism ";
  if(isset($approachbit)){
	  $query.=" WHERE $approachbit";
  }
  $query.=" GROUP BY genes.id) orthologpheno ON genes.id=orthologpheno.geneid ";
 }
 
$query.="
 
 
 
 ".$where. " ORDER BY genes.GeneID";
//print $query;
//$query=$query="SELECT * FROM genes LEFT JOIN (SELECT COUNT(time) AS loccount, gene_id AS locgid FROM localisation GROUP BY gene_id) bla ON genes.id=bla.locgid LEFT JOIN (SELECT COUNT(time) AS phecount, gene_id AS phegid FROM phenotypes GROUP BY gene_id) bla2 ON genes.id=bla2.phegid";


include("establishlocalisations.php");
$result = mysqli_query($link, $query);
$numrows=mysqli_num_rows($result);
if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
if (!$csv){
?>
<style>
span.faded {
    opacity: 0.4;
    filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<!-- <?= $query ?>-->

				                <div class="row">
                    <div class="col-lg-12">
                        
						<? 			
						}
						else{?>Gene	Description	GeneLocalisation	OrthologLocalisation	GeneViability	OrthologViability	GeneAsexual	OrthologAsexual	GeneGametocyte	OrthologGametocyte	GeneOokinete	OrthologOokinete	GeneOocyte	OrthologOocyte	GeneSprozoite	OrthologSporozoite	GeneLiver	OrthologLiver
<?}
						if(mysqli_num_rows($result)>0){
						if(!$csv){?>
						<style>

						</style>
						<div class="table-responsive">
                                <table class="table table-striped  table-header-rotated table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="tallhead">Gene</th>
                                            <th>Product</th>
                                            <? if(isset($_GET['check'])){?><th>Last checked</th><? } ?>
                                            <!--<th>Localisations</th>--><?
											$stagesback=$stages;
											for($i=0;$i<$numstages;$i++){
											?><th style="text-align:center"><div><span><?
										if($stages[$i]=="Disruption"){?>Disruptable<?}else{	echo substr($stages[$i],0,3);}
											?></span></div></th>
											<?
											}?>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?
									}
						$sequence=array(); //temp
									while($row=mysqli_fetch_assoc($result)){
									if(!$csv){
									?>
									
                                        <tr>
                                            <td><a href="singlegene.php?gene=<?= $row['GeneID']?>"><?= $row['GeneID']?></a></td>
                                            <td><?= $row['ProdDesc']?><?
						if($row['Symbol']!="null"){?> (<?= $row['Symbol']?>) <?
							
						}						
						
						?></td>
                                            <? if(isset($_GET['check'])){?> <td><?if( $row['LastChecked']>10){?><?= time_passed($row['LastChecked'])?> <? }?></td><? }}
else{?>
<?= $row['GeneID']?>	<?= $row['ProdDesc']?>	<?}					if(!$csv){						?>
                                            <!--<td><? }
											$mainloco=explode(",",$row['localisation']);
											echo implode(", ",array_map("localise", $mainloco));
											if($csv){?>	<? }
											$ortholoco=explode(",",$row['ortholoco']);
											$filteredFoo = array_diff($ortholoco, $mainloco);
											if(count($filteredFoo)>0){
											if(count($mainloco)>1){if(!$csv){?>	<? }} if(!$csv){?>
											<span class="faded"><? } ?><?=
											
											implode(", ",array_map("localise", $filteredFoo));


											?><? if(!$csv){?></span><? } ?><?
											}
											if(!$csv){?></td>--><? } 
											$stuff=array();
											$stuff2=array();
											$stages=explode(",",$row['phenotypestage']);
											$phenotypes=explode(",",$row['phenotype']);
											$orthostages=explode(",",$row['orthophenotypestage']);
											$orthophenotypes=explode(",",$row['orthophenotype']);
											$orthogenes=explode(",",$row['orthogeneid']);
											foreach( $stages as $index => $stage ) {
   $stuff[$stage][]=$phenotypes[$index];
}
foreach( $orthostages as $index => $stage ) {
   if($orthogenes[$index]!=$row['GeneID']){
  // echo $orthogenes[$index];
   $stuff2[$stage][]=$orthophenotypes[$index];}
}
											?><?
											for($i=0;$i<$numstages;$i++){
											if(!$csv){?><td style="text-align:center"><? } else { ?>	<? }
											if(!$csv){
											if(isset($stuff[$i])){echo str_replace('title="','title="'.$stagesback[$i].": ",implode(" ",array_map("pheref2",array_unique($stuff[$i]) )));}} 
											else{
											if(isset($stuff[$i])){echo implode(" ",array_map("pheref3",array_unique($stuff[$i]) ));} }
											
											if($csv){?>	<?}
											if(!$csv){
											if(isset($stuff2[$i])){echo "<span class='faded'>".str_replace('title="','title="'.$stagesback[$i].": ",implode(" ",array_map("pheref2",array_unique($stuff2[$i]) )))."</span>";}}
else{
if(isset($stuff2[$i])){echo "".implode(" ",array_map("pheref3",array_unique($stuff2[$i]) ))."";}}
											
											if(!$csv){?></td>
											<?}
											}if(!$csv){
											?>
											
                                        </tr>
										<? 
										}
										else{
										echo "\n";
										}
										if(isset($stuff[0])){$sequence[]=implode(" ",array_map("pheref2",array_unique($stuff[0]) ));}else{if(isset($stuff2[0])){$sequence[]=implode(" ",array_map("pheref2",array_unique($stuff2[0]) ));}}
										} 
										if (!$csv){?>
                                     
                                    </tbody>
                                </table>
										</div><?}  }
							else{
							?>No results for this search.
							<?}
							
							if (!$csv){?>
							<!-- <? implode("\n",$sequence); ?>-->
                    </div>
					
							</div><? } ?>