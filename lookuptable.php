<? include("header.php")
?>
<?
?>
<div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">Lookup table</h2>
						
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
				                <div class="row">
                    <div class="col-lg-12">
                        
						<?
						
						mysqli_query("DROP TABLE orthologlookup");
	$sql="CREATE TABLE orthologlookup SELECT Organism, ortholog, COUNT(DISTINCT GeneID) AS catcount, GROUP_CONCAT(GeneID) AS catid FROM genes  GROUP BY Organism, ortholog ORDER BY `genes`.`ortholog` ASC";
echo($sql."<br>");
	$result=mysqli_query($sql);
	if (!$result) {
    die('Invalid query: ' . mysqli_error());
}
//DROP  TABLE ogroups; CREATE TABLE `plasmogmdb`.`ogroups` ( `id` INT NOT NULL AUTO_INCREMENT  , PRIMARY KEY (`id`) ) ENGINE = MyISAM SELECT DISTINCT ortholog FROM genes;
//UPDATE genes INNER JOIN ogroups ON ogroups.ortholog=genes.ortholog SET orthid=ogroups.id
//UPDATE orthologlookup INNER JOIN ogroups ON orthologlookup.ortholog=ogroups.ortholog SET orthid=ogroups.id /						?>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

<? include("footer.php") ?>