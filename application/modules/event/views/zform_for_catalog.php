<div class="span6">
<h3><?=$this->lang->line('choose_your_place')?></h3>
<form action="<?=site_url('event/set_cookie_country')?>" method="post" id="send_cookie_form">
    <?=$this->lang->line('country')?>
    <select name="country_cookie" id="country_cookie_id">
        <?php if($countries){ ?>
        <?php foreach($countries as $c): ?>
            
                <option <?=($c->country == $country)? "selected='selected'" :"";?> value="<?=$c->country?>"><?=$c->country?></option>    
            
        <?php endforeach; ?>
        <?php } ?>
    </select>
    <br />
    <div style="display: <?=($cities)? "block": "none"; ?>;" id="city_cookie_block">
    <?=$this->lang->line('city')?>
    <select name="city_cookie" id="city_cookie">
        <?php if($cities){?>
            <?php foreach($cities as $ci): ?>
                <option value="<?=$ci->city?>"><?=$ci->city?></option>
            <?php endforeach; ?>
        <?php } ?>
    </select>
    </div>
    <input type="submit" value="OK" name="change_cookie" class="button btn-info" />
</form>
</div>

<script>
$("#country_cookie_id").change(function(){
       countryName = $(this).val();
       
       $.ajax({
        type: "POST",
        url: "<?=site_url('event/city_list'); ?>",  
        data: 'countryName='+countryName,
        dataType: "html",       
        success: function(msg){ 
            //alert(msg);
            if(msg==''){
                $("#city_cookie_block").hide();
            }else{
                $("#city_cookie_block").show();
                $("#city_cookie").html(msg);
            }
                                                            
        }     
    });  
});
</script>

<script>
$("#send_cookie_form").ajaxForm({
    success:function(r){
        if(r=='success'){
            location.reload();   
        }else{
            return false;
        }             
    }
});
</script>