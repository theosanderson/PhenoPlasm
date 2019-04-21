<?

include("db_details.php");
 $link = mysqli_connect($db_location,$db_user,$db_pass);
$db_selected = mysqli_select_db($link,'plasmogmdb');
 print'<?xml version="1.0" encoding="utf-8"?>'; ?>
    <rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
      <channel>
        <title>PhenoPlasm</title>
        <description>The latest phenotypes from the malaria research community</description>
        <link>http://phenoplasm.org</link>
        <language>en</language>
   
        <ttl>30</ttl>
        <atom:link href="http://phenoplasm.org/rss.php" rel="self" type="application/rss+xml" />
       

<?


$sql="(SELECT gene_id,GeneID,ProdDesc,time,'localisation' AS type FROM localisation INNER JOIN genes ON genes.id=localisation.gene_id) UNION (SELECT gene_id,GeneID,ProdDesc,time,'phenotype' AS type FROM phenotypes INNER JOIN genes ON genes.id=phenotypes.gene_id) ORDER BY time DESC LIMIT 10";
								$result=mysqli_query($link,$sql);
								while($row=mysqli_fetch_assoc($result)){
									$pubDate =date('r', $row['time']);
								?>
								<item>
          <title>New <?= $row['type'] ?> for <?= $row['ProdDesc'] ?></title>
          <description></description>
          <link>http://phenoplasm.org/singlegene.php?gene=<?=$row['GeneID']?></link>
          <guid isPermaLink="true">http://phenoplasm.org/singlegene.php?gene=<?=$row['GeneID']?></guid>
       <pubDate><?= $pubDate ?> GMT</pubDate>
        </item>
								
                                </a>
								<? } ?>


 </channel>
    </rss>