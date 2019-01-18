<? include("header.php") ?>
<div id="page-wrapper">
            <div class="container-fluid">
			<div class="row">
<div class="col-lg-12">
 <h2><i class="fa fa-signal fa-fw"></i>Statistics</h2>
   <h3>Species break-down</h3>
<table class="table table-striped  table-header-rotated table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="tallhead">Organism</th> <th class="tallhead">Number of genes</th></tr></thead>
<?
$result=mysqli_query($link, "Select genes.Organism AS Organism, Count(Distinct gene_id) As numgenes FROM phenotypes INNER JOIN genes on phenotypes.gene_id = genes.id GROUP BY genes.Organism");
$jsarray=array();
while($row=mysqli_fetch_assoc($result)){
	$jsarray[]="['".$row['Organism']."',".$row['numgenes']."]";
?>
<tr><td><a href="http://phenoplasm.org/advanced.php?text=&genes=&primespecies=<?= $row['Organism'] ?>&approach1=3&includeapproach1=on&approach2=2&includeapproach2=on&approach3=1&includeapproach3=on&approach4=4&includeapproach4=on&approach5=6&includeapproach5=on&approach6=5&includeapproach6=on&approach7=7&includeapproach7=on&display=phenos&type=web"><?= $row['Organism'] ?></a></td><td><?= $row['numgenes'] ?></td></tr>
<?
}

?>
</table>

  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <div id="chart_div"></div>
      <script>
	  google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = google.visualization.arrayToDataTable([
        ['City', 'Phenotyped genes',],
     <?= implode(",",$jsarray)
        
       ?>
      ]);

      var options = {
       
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Phenotyped genes',
          minValue: 0,
		  scaleType: 'log'
        },
        vAxis: {
          title: 'Species'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
	  </script>
	  
	  <?
	  $result=mysqli_query($link, "Select phenotypeapproaches.longdesc AS Organism, Count(Distinct gene_id) As numgenes FROM phenotypes INNER JOIN genes on phenotypes.gene_id = genes.id INNER JOIN phenotypeapproaches ON phenotypeapproaches.id = phenotypes.type OR (phenotypeapproaches.id=1 AND phenotypes.type=0) GROUP BY phenotypeapproaches.longdesc");
	  $jsarray=array();
	  while($row=mysqli_fetch_assoc($result)){
	$jsarray[]="['".$row['Organism']."',".$row['numgenes']."]";
	  }
	  ?>
	  <h3>Experimental approaches</h3>
	   <div id="chart_div2"></div>
      <script>
	  google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = google.visualization.arrayToDataTable([
        ['City', 'Phenotyped genes',],
     <?= implode(",",$jsarray)
        
       ?>
      ]);

      var options = {
        colors: ['#62A85E', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'],
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Phenotyped genes',
          minValue: 0,
		  scaleType: 'log'
        },
        vAxis: {
          title: 'Experimental approach'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div2'));

      chart.draw(data, options);
    }
	  </script>
</div>
</div>
</div> 
</div>

<? include("footer.php") ?>