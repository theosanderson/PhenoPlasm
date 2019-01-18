<? include("header.php") ?>
<div id="page-wrapper">
            <div class="container-fluid">
			<div class="row">
<div class="col-lg-12">
 <h2>Extracting data in CSV format</h2>
 <p> Both the <i>Advanced Search</i> and the <i>Batch Search</i> allow summary data to be reported in CSV format, rather than the usual web version. This can be useful if you want to use a script to analyse the data.</p>
 
 Phenotypes are presented using single letters instead of symbols, to facilitate analysis. These are defined below.
   <h3>Phenotype taxonomy</h3>
<table class="table table-striped  table-header-rotated table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                           <th width=20 class="tallhead">CSV symbol</th> <th class="tallhead" width=20>Symbol</th> <th class="tallhead">Description</th></tr></thead>
<?
$result=mysql_query("SELECT * FROM phenotyperefs WHERE ordering >= 0 ORDER BY ORDERING");
$jsarray=array();
while($row=mysql_fetch_assoc($result)){
	if($row['name']=="Possible"){
		$row['name']="Disruption possible (viable mutant)";
	}
	if($row['name']=="Refractory"){
		$row['name']="Refractory to deletion (failed disruption)";
	}
?>
<tr><td><?= $row['shorttext'] ?></td><td><?= $row['short'] ?></td><td><?= $row['name'] ?></td></tr>
<?
}

?>
</table>

</div>
</div>
</div> 
</div>

<? include("footer.php") ?>