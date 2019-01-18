<?

$result = mysqli_query($link, 'SELECT * FROM localisations');
$locs = array();
while($row=mysqli_fetch_assoc($result)){
$locs[$row['id']]=$row['name'];

}

function localise($n)
{
global $locs;
   return $locs[$n];
}

//////////////////

$result = mysqli_query($link, 'SELECT * FROM phenotyperefs');
$pherefs = array();
$pherefs2 = array();
$pherefs3 = array();
while($row=mysqli_fetch_assoc($result)){
$pherefs[$row['id']]=$row['name'];
$pherefs2[$row['id']]=$row['short'];
$pherefs3[$row['id']]=$row['shorttext'];
}
//$numphenotypes=count($pherefs);

function pheref($n)
{
global $pherefs;
   return $pherefs[$n];
}
function pheref2($n)
{
global $pherefs2;
   return $pherefs2[$n];
} 

function pheref3($n)
{
global $pherefs3;
   return $pherefs3[$n];
} 

///////////
$result = mysqli_query($link, 'SELECT * FROM phenotypestages');
$stages = array();
while($row=mysqli_fetch_assoc($result)){
$stages[$row['id']]=$row['name'];

}
$numstages=count($stages);

function stage($n)
{
global $stages;
   return $stages[$n];
}

function printsupport($type,$id)
{
if ($type==0 &substr($id,0,4)!="http"){?> <a style="color:gray" href="http://www.ncbi.nlm.nih.gov/pubmed/<?=$id?>"><i class="fa fa-files-o fa-fw"></i> <?=$id?></a><?
?>
<?
}
elseif($type==0 &substr($id,0,4)=="http"){?> <a style="color:gray" href="<?=$id?>"><i class="fa fa-files-o fa-fw"></i> <?=$id?></a>
<?
	
}
elseif($type==1){
	?><a style="color:gray" href="http://www.pberghei.eu/index.php?rmgm=<?= substr($id,5,5)?>"><i class="fa fa-database fa-fw"></i> <?= $id ?></a>
	<?
}
elseif($type==2){
	?><a style="color:gray" href="http://plasmogem.sanger.ac.uk/phenotypes?search=<?= $id ?>"><i class="fa fa-database fa-fw"></i>PlasmoGEM</a>
	<?
}
elseif($type==3){
	?><a style="color:gray" href="http://science.sciencemag.org/content/360/6388/eaap7847"><i class="fa fa-database fa-fw"></i>USF piggyBac screen</a>
	<?
}
else{?>
<?=$id?><?
}
}


?>