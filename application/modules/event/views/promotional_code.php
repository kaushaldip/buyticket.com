<div class="row">
    <div class="col-md-12">
        <h3><?php echo $this->lang->line('promotional_codes'); ?></h3>
        <div class="table-responsive">
            <table class="table table-bordered">
            	<tr>
            		<th><?php echo $this->lang->line('name'); ?></th>
            		<th><?php echo $this->lang->line('code'); ?></th>
            		<th><?php echo $this->lang->line('percentage'); ?></th>
            		<th><?php echo $this->lang->line('start_time'); ?></th>
            		<th><?php echo $this->lang->line('end_time'); ?></th>
                    <th><?php echo $this->lang->line('used'); ?></th>
                    <th><?php echo $this->lang->line('actions'); ?></th>
            	</tr>
            	<?php if($promtional_details): 
            		
            		foreach($promtional_details as $p):
            		?>
            	<tr id="promotion_code_row<?= $p->id ?>">
            		<td><?=$p->p_name ?></td>
            		<td><?=$p->p_code ?></td>
            		<td><?=$p->percentage ?></td>
            		<td><?=$p->start_time ?></td>
            		<td><?=$p->end_time ?></td>
                    <td><?= ($p->type =='multiple')? $p->used.' / '.$p->total: (($p->used=='0')? $this->lang->line('not_used') : $this->lang->line('used'))?></td>
                    <td><a class="btn btn-xs btn-danger" href="javascript:void(0);" kds="<?= $p->id ?>" onclick="delete_promotion_code('<?= $p->id ?>');"><?php echo $this->lang->line('delete'); ?></a></td>
            	</tr>
            	<?php endforeach; 
            	endif; ?>
            </table>
        </div>
        <?php if($active_event){?>
        <form class="form-horizontal well"  method="post" id="discount_form">
            <div class="event-form-main">            
                <div class="form-group">
                    <label class="form-label" for="p_name"><?php echo $this->lang->line('name'); ?></label>
                    <div class="col-md-4 col-sm-4 col-xs-10  ">
                        <input name="p_name" id="p_name" class="required form-control" type="text" title="<?=$this->lang->line('this_field_required')?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_upload1"><?php echo $this->lang->line('multiple'); ?>:</label>
                    <div class="col-md-4 col-sm-4 col-xs-10  ">
                        <div class="row">  
                            <div class="col-md-1">                                
                                <input type="radio" name="is_upload" id="is_upload1" class="is_upload" value="2" checked=""/>
                            </div>
                            <div class="col-md-10">
                                <input name="multiple_number" id="multiple_number" value="" class="textbox  form-control required digits" type="text"  placeholder="<?=$this->lang->line('number_of_use')?>" title="<?=$this->lang->line('this_field_required')?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="is_upload"><?php echo $this->lang->line('single'); ?>:</label>
                    <div class="col-md-4 col-sm-4 col-xs-10  ">   
                        <div class="row">
                            <div class="col-md-1">           
                                <input type="radio" name="is_upload" id="is_upload" class="is_upload" value="1"/>
                            </div>
                            <div class="col-md-10">
                                <input name="multiple_number_single"  id="multiple_number_single"value="" class="textbox required number  form-control" type="text"  placeholder="<?=$this->lang->line('number_of_code')?>"/>
                            </div>
                        </div>
                    </div>
                </div>            
                <div class="form-group">
                    <label class="form-label required number" for="percent_off"><?php echo $this->lang->line('discount_percentage'); ?>:</label>
                    <div class="col-md-4 col-sm-4 col-xs-10  ">
                        <div class="row">
                            <div class="col-md-4">
                                <input id="percent_off" name="percent_off" maxlength="2"  value="" class="textbox required number  form-control" type="text" onchange="javascript: resetAmount();" title="<?=$this->lang->line('this_field_required')?>" />
                            </div>
                            <div class="col-md-8">
                                % <?php echo $this->lang->line('off_ticket'); ?>
                            </div>
                        </div>
                    </div>
                </div>            
                <div class="form-group">
                    <label class="form-label" for="start_date"><?php echo $this->lang->line('starts'); ?>:</label>
                    <div class="col-md-3 col-sm-4 col-xs-10  ">
                        <input type="text" id="start_date" name="start_date" value="" class="datepicker  required form-control" readonly="true" title="<?=$this->lang->line('this_field_required')?>" />
                    </div>
                </div>            
                <div class="form-group">
                    <label class="form-label" for="end_date"><?php echo $this->lang->line('ends'); ?>:</label>
                    <div class="col-md-3 col-sm-4 col-xs-10  ">
                        <input type="text" id="end_date" name="end_date" value="" class="datepicker required form-control" readonly="true" title="<?=$this->lang->line('this_field_required')?>" />
                    </div>
                </div>            
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?=$this->lang->line('save')?></button>
                </div>
            </div>            
        </form>
        <?php }?>
    </div>
</div>
<script>
    $("#discount_form").validate({
    rules: {
               multiple_number:{
                  required: function (element) {
                     if($("#is_upload1").is(':checked'))
                     {
                         return true;
                     }
                     else
                     {
                         return false;
                     }  
                  }  
               },
               multiple_number_single:{
                  required: function (element) {
                     if($("#is_upload").is(':checked'))
                     {
                         return true;
                     }
                     else
                     {
                         return false;
                     }  
                  }  
               }
           }
  });
$("#discount_form").validate();
</script>
<script>
function delete_promotion_code(promotion_id){
    
    if(confirm("<?=$this->lang->line('are_you_sure');?>")){
        var id=promotion_id;    
        $.ajax({
            url:'<?php echo site_url('event/delete_promotion_code'); ?>',
            type:'POST',
            data:'id='+id,
            success:function(r){
                //alert(r);
                if(r==0){
                    alert('<?=$this->lang->line('deleted_failure');?>')
                } else {               
                    alert('<?=$this->lang->line('sucessfull_delete');?>');
                    $("#promotion_code_row"+id).empty().hide();
                }
            
            }
        });    
    }
    
}
</script>