<aside class="acc_pro">
                            		<h1><?php echo $this->lang->line('dummy');?></h1>	
                                   	<div class="infos">
                                    	                    
                    		<section class="tblcnt">
                            	<ul class="hd">
                                <li style="width:254px;"><?php echo $this->lang->line('dummy');?></li>
                                <li><?php echo $this->lang->line('dummy');?></li>
                                <li><?php echo $this->lang->line('dummy');?></li>
                                <li style="width:150px;"><?php echo $this->lang->line('dummy');?></li>                                
                                </ul>
                                
                                <ul class="hd bdy">
								<?php
								if($wonmp3)
								{
									foreach($wonmp3 as $mp3)
									{
								?>
                                 <li style="width:254px;"><?php echo $mp3->album_name;?></li>
                                 <li><?php echo $mp3->name;?></li>
                                 <li><?php echo $mp3->total_positive_vote;?></li>
                                 <li style="width:150px;"><?php echo $this->general->date_formate($mp3->end_date);?></li>
                                 <?php
								 	}
								 }
								 else
								 {
								 ?>
								 <div class="error"> :: Zero record found ::</div>
								 <?php
								 }?>
                                </ul>
                               
                            </section>
                    
                                    </div>
                            </aside>