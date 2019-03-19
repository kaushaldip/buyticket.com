<ul class="nav nav-tabs">
    <?php $all_cms =  $this->general->get_cms_lists();if($all_cms){for($i=0;$i<4;$i++){?>
    <li>
        <a href="<?php echo site_url("/page/".$all_cms[$i]->cms_slug);?> ">
        <?php echo $all_cms[$i]->heading;?>
        
        </a>
    </li>
    <?php }}?>
    <li class="active"><a href="<?php echo site_url('help/index');?>"><?php echo $this->lang->line('help'); ?></a></li>
    <li><a href="<?php echo site_url('home/contact');?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
</ul>

<div id="help">
    
    <article id="helpsec">
        <!--
		<h1 class="title"><span><?php echo $template['title']; ?> <?php echo $this->lang->line('help'); ?></span></h1>
		-->
        
		<ul class="help" style="list-style: none;">
            <?php 
            if($helps){
                foreach($helps as $help)
                {?>            
                    <li>
                        <a href="#"><?php echo $help->title;?></a>
                        <div style="display: none;" class="help_answer">
                            <p><?php echo $help->description;?></p>
                        </div>
                    </li>            
            <?php
                }
            }            
            ?>
        </ul>

    </article>
</div>
                
             
<script type="text/javascript">
    function showmydesc(id)
    {
        $('#'+id).show();
        $(this).next().slideToggle('fast');            
    }
    
    var lh = $('#helpsec').height(); var rh = $('#faqRight').height();
    if (lh > rh) 
    {
        $('h2.last').prev().css('marginBottom', "+="+(lh-rh));
    }
    
    $('#help li > a').click(function(){
        if ($(this).next().is(":hidden")) {
            $(this).parent().addClass("minus");
            $(this).next().slideToggle('fast');            
        }else{
            $(this).next().slideToggle('fast', function(){
                $(this).parent().toggleClass('minus');
            });
        }
        return false;
    });
</script>