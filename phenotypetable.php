
									<?
						
									while($row=mysqli_fetch_assoc($result)){
									?>
									
                                        <tr>
										<td><? if($row['GeneID']!=$gene['GeneID']){?><a href="/singlegene.php?gene=<?= $row['GeneID'] ?>" style="color:#333"><? } ?><?= $row['Organism'] ?><? if($row['GeneID']!=$gene['GeneID']){?></a><? } ?></td>
									<? if($stage){ ?><td><?= stage($row['stage'])?></td><? } ?>
                                            <td><div style="width:20px; text-align:center; float:left"><?= pheref2($row['phenotype'])?></div>
											 <?= pheref($row['phenotype'])?></td>
                                            <td><? printsupport($row['typeofsupport'],$row['supportid']);?><?
											
											if(($row['type'])>1){
												
											if($row['type']==2){
																				?> (Conditional)
									<?					}
									if($row['type']==3){
																				?> (Barseq)
									<?					}
									if($row['type']==4){
																				?> (Insert. mut.)
									<?					}
									
									if($row['type']==6){
																				?> (Knock down)
									<?					}
																		if($row['type']==7){
																				?> (Spontaneous loss, not experimental genetics)
									<?					}
									
									
									
									}
										if($row['notes']!=""){?><div style="width:200px;font-size:70%;margin-top:3px;line-height:auto"><?= $row['notes'] ?></div><?}	
									?></td>
                                            <td><? if($row['typeofsupport']==1){?><span style="color:gray">Imported from RMgmDB</span><? } elseif($row['typeofsupport']==2){?><span style="color:gray">PlasmoGEM</span><? }elseif($row['typeofsupport']==3){?><span style="color:gray">USF PiggyBac Screen</span><? }else{ ?>
											<?= $row['credit']?>, <?= $row['inst']?><? } ?></td>
                                        </tr>
										<? } ?>
                                     
                                   