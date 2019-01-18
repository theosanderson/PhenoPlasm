<? include("header.php")
?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Community database of phenotypes <!-- and localisations -->for malaria parasite genes</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
			<div class="col-lg-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <strong>Welcome to PhenoPlasm</strong>
                        </div>
                        <div class="panel-body">
                            <p>This site collates phenotypes<!-- and localisations --> for disruptions of <i>Plasmodium</i> genes. Like Wikipedia, it's powered by you, so please get involved by adding data for your favourite gene.</p>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-gears fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?
									 $sql="Select Count(Distinct gene_id) As numgenes FROM phenotypes INNER JOIN genes on phenotypes.gene_id = genes.id";
									 $result=mysql_query($sql);
									 $res=mysql_fetch_assoc($result);
									 echo $res['numgenes'];
									?></div>
                                    <div>phenotyped genes</div>
                                </div>
                            </div>
                        </div>
                        <a href="/batch.php" style="color:#a94442">
                            <div class="panel-footer">
                                <span class="pull-left">Batch search</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				
               <!-- <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-crosshairs fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?
									 $sql="Select Count(Distinct gene_id) As numgenes FROM localisation  INNER JOIN genes on localisation.gene_id = genes.id";
									 $result=mysql_query($sql);
									 $res=mysql_fetch_assoc($result);
									 echo $res['numgenes'];
									?></div>
                                    <div>proteins localised.</div> 
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                              <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div> -->
				 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-crosshairs fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?
									 $sql="Select Count(Distinct orthid) As numgenes FROM phenotypes INNER JOIN genes on phenotypes.gene_id = genes.id";
									 $result=mysql_query($sql);
									 $res=mysql_fetch_assoc($result);
									 echo $res['numgenes'];
									?></div>
                                    <div>ortholog groups.</div> 
                                </div>
                            </div>
                        </div>
                        <a href="/stats.php">
                           <div class="panel-footer">
                               <span class="pull-left">Current statistics</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"> </div>
                            </div>
                        </a>
                    </div>
                </div> 
                <!--<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">124</div>
                                    <div>New Orders!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">13</div>
                                    <div>Support Tickets!</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>-->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <!--<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bolt fa-fw"></i> Explore
                        </div>
						 <div class="panel-body">
                            <p>Rhoptry<br>Microneme</p>
                        </div>
						</div>-->
				</div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bolt fa-fw"></i> Latest additions
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <?
							
								$sql="(SELECT gene_id,GeneID,ProdDesc,time,'localisation' AS type FROM localisation INNER JOIN genes ON genes.id=localisation.gene_id) UNION (SELECT gene_id,GeneID,ProdDesc,time,'phenotype' AS type FROM phenotypes INNER JOIN genes ON genes.id=phenotypes.gene_id) ORDER BY time DESC LIMIT 10";
								$result=mysql_query($sql);
								while($row=mysql_fetch_assoc($result)){
								?>
								<a href="/singlegene.php?gene=<?=$row['GeneID']?>" class="list-group-item">
                                    <i class="fa <? if($row['type']=="phenotype"){?>fa-gear<?}else{?>fa-crosshairs<?}?> fa-fw"></i> New <?= $row['type'] ?> for <?= $row['ProdDesc'] ?>
                                    <span class="pull-right text-muted small"><em><?= time_passed($row['time']) ?></em>
                                    </span>
                                </a>
								<? } ?>
                              
                            </div>
                            <!-- /.list-group -->
                            <!--<a href="#" class="btn btn-default btn-block">View All Alerts</a>-->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                   
                    <!-- /.panel .chat-panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<? include("footer.php") ?>