<? include("header.php")
?>
<?
if(!isset($_GET['species'])){$_GET['species']="P. falciparum 3D7";}
if(isset($_GET['gene'])){
$search=strtoupper(trim($_GET['gene']));

$result = mysqli_query($link, 'SELECT * FROM genes WHERE GeneID="'.$search.'"');
if (!$result) {
    die('Invalid query: ' . mysqli_error());
}

if($gene=mysqli_fetch_assoc($result)){
$success=1;
}
else{
$result = mysqli_query($link, 'SELECT * FROM aliases INNER JOIN genes ON aliases.geneid = genes.id WHERE UPPER(aliases.alias) = "'.$search.'"');


if(mysqli_num_rows($result)==1&&$gene=mysqli_fetch_assoc($result)){
$success=1;
}
}
}
if(isset($success)){
?>
<div id="page-wrapper">
            <div class="container-fluid">
                Go to <?= $gene['GeneID'] ?>.
				<script>

    window.location.assign("/singlegene.php?gene=<?= $gene['GeneID'] ?>")

</script>
            </div>
            <!-- /.container-fluid -->
        </div>
<?
}
else{
$where = ' WHERE Organism=\''.$_GET['species'].'\' AND ( UPPER(ProdDesc) LIKE "%'.$search.'%" OR UPPER(Symbol) LIKE "%'.$search.'%")';
?><div id="page-wrapper">
            <div class="container-fluid">
			
			<div class="row" style="margin-top:10px">
 <div class="col-lg-4" >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Species selector
                        </div>
                        <div class="panel-body">
                            <form action="singlesearch.php" name="form" method="get">
							<? $species=array();
							$species[]="P. falciparum 3D7";
							$species[]="P. berghei ANKA";
							$species[]="P. knowlesi strain H";
							?>
							<input type="hidden" name="gene" value="<?= $_GET['gene'] ?>" />
							<select onchange="form.submit()" name="species">
							<? foreach($species as $spec){ ?>
							<option value="<?= $spec ?>" <? if($spec==$_GET['species']){echo "selected";} ?>><?= $spec ?></option>
								<?
							} ?>
							<select>
							</form>
							</p>
							
                        </div>
                        
                    </div>
					</div>
					
                    <div class="col-lg-8">
			
                        <? include("key.php"); ?>
                        
                    
					</div>
				
					</div>
				<h3>Search results for <i><?= $_GET['gene'] ?></i>: <span id="numresults"></span></h3>
				 <? include("multisearchinc.php") ?>
				 <script>
				 document.getElementById("numresults").innerHTML="<small><?= $numrows ?> gene<? if($numrows>1){?>s<? }?> found</small>";
				 </script>
					</div>
					
<?
}
?>
<? include("footer.php") ?>