<? include("header.php") ?>
<div id="page-wrapper">
            <div class="container-fluid">
			<div class="row">
<div class="col-lg-12">
 <h2>What does this database contain?</h2>
<p>This database aims to assemble a comprehensive collection of 
structured phenotyping data from attempts to knock out <i>Plasmodium</i> genes. It is curated by <a href="http://theo.io">Theo Sanderson</a>.  You can see the number of phenotyped genes per species on our <a href="/stats.php">statistics page</a>. The PhenoPlasm manuscript has now been published <a href="https://wellcomeopenresearch.org/articles/2-45/v1">in Wellcome Open Research</a>.</p>


 <h2>Data sources</h2>
 <p>A major portion of the data on this site comes from the <a href="http://www.pberghei.eu/">Rodent Malaria genetically modified parasites database</a> (RMgmDB), the <a href="http://science.sciencemag.org/content/360/6388/eaap7847">Adams lab saturation screen in <i>P. falciparum</i></a> and from <a href="http://plasmogem.sanger.ac.uk/">PlasmoGEM</a>. Clicking on the <i>Reference</i> link for rodent phenotypes will take you to the RMgmDB or PlasmoGEM page for that disruption attempt, which will often contain more detailed phenotyping information.</p>
 
 <p>Other data is collated from the literature by the curator or other users -  here the reference link will take you to the PubMed page for the publication in question, which will have further details on the experiments involved.
 <p>If citing this database, please remember that RMgmDB (described <a href="https://www.ncbi.nlm.nih.gov/pubmed/20663715">here</a> and <a href="http://www.ncbi.nlm.nih.gov/pubmed/22990775">here</a>), the <a href="http://science.sciencemag.org/content/360/6388/eaap7847"><i>P. falciparum</i> saturation screen</a> and <a href="https://www.ncbi.nlm.nih.gov/pubmed/28708996">PlasmoGEM</a> constitute a large part of the dataset.</p>
 
 <p>Genome data comes from <a href="http://genedb.org">GeneDB</a> via <a href="http://plasmodb.org">PlasmoDB</a>. 

 	<p> We now also display immunofluorescence images from <a href="http://mpmp.huji.ac.il/">Malaria Metabolic Pathways</a>, these are compiled by Hagai Ginsburg and simply replicated here to provide as much experimental data for the particular gene as possible.
 
 <h2>How do I add data?</h2>
 <p>It is easy to contribute data to PhenoPlasm, simply click the [+] button next to the <i>Phenotypes</i> heading. We are not a primary datasource, so please include a PubMed ID or other reference to the description of the experiment generating the phenotype.</p>
 <p>Please prioriotise submitting any data on rodent malaria parasites to RMgmDB, from which it will ultimately be mirrored here.</p>
 
  <h2>How does orthology work?</h2>
  <p> Orthologs are genes in different species which have a common ancestor, e.g. PfAMA1 and PbAMA1. In general these are expected to have the same function in the various species, and so to have the same phenotype when knocked out. Because of this we display information from orthologs in other species when you search for a gene. These are displayed on the search page with semi-transparent icons so you know they represent orthologous results.</p>

   <h2>Where can I see the complete dataset?</h2>
  <p>We have a <a href="/datadumpcsv.php">data dump</a> of all phenotypes in the dataset. You can aso extract data from any search in CSV format. Details of the taxonomy used in CSV format are available <a href="csvsupport.php">here</a>. You can also conduct a search, or advanced search, without entering any gene IDs to see summary data.</p> 
 
  <h2>Who can I contact to amend this data?</h2>
  <p>Please email the <a href="mailto:theo@theo.io">curator</a> if you spot any errors. If subsequent publications contradict previous results please add the data from them, as described above.</p>


<h2>A quick request</h2>
<p>Do you find this database helpful? If so we'd be grateful if you could <a href="mailto:theo@theo.io">send</a> a brief testimonial to cite in future applications for funding.</p>


  
</div>
</div>
</div> 
</div>

<? include("footer.php") ?>
