<div class="span12"><h1 class="title"><span><?php echo $this->lang->line('features'); ?></span></h1></div>
<div class="row-fluid">
     <?php $all_how_cms = $this->general->get_how_lists_event();
if ($all_how_cms) {
    for ($i = 0; $i < 3; $i++) {

        $text = strip_tags($all_how_cms[$i]->content);
        if ($text) {
            $length = 310;
            if (strlen($text) < $length + 10) {
                $cont = strip_tags($text);

            } //don't cut if too short
            else {
                $break_pos = strpos($text, ' ', $length); //find next space after desired length
                $visible = substr($text, 0, $break_pos);

                $cont = $visible;
            }
        }

        if ($i == 0) { ?>
    <div class="span4 how_each">
    	<img src="<?= MAIN_IMG_DIR_FULL_PATH ?>home_1.png" />
        
        <h2><?= $all_how_cms[$i]->heading; ?></h2>
       
        <p><?= $cont ?></p>
        <!--
		<a class="read_more" href="<?php echo site_url("/page/" . $all_how_cms[$i]->
cms_slug); ?>"><?php echo
$this->lang->line('read_more'); ?>...</a>
		-->
    </div>
    <?php } elseif ($i == 1) { ?>
    
    <div class="span4 how_each">
    	<img src="<?= MAIN_IMG_DIR_FULL_PATH ?>home_2.png" />
        <h2><?= $all_how_cms[$i]->heading; ?></h2>
        <p><?= $cont ?></p>
		<!--
        <a class="read_more" href="<?php echo site_url("/page/" . $all_how_cms[$i]->
cms_slug); ?>"><?php echo
$this->lang->line('read_more'); ?>...</a>
		-->
    </div>
    <?php } else {

?>
 
    <div class="span4 how_each last_right">
    	<img src="<?= MAIN_IMG_DIR_FULL_PATH ?>home_3.png" />
        <h2><?= $all_how_cms[$i]->heading; ?></h2>

        <p><?= $cont ?></p>
		<!--
        <a class="read_more" href="<?php echo site_url("/page/" . $all_how_cms[$i]->
cms_slug); ?>"><?php echo
$this->lang->line('read_more'); ?>...</a>
		-->
    </div>
    <?php }
    }
} ?>
</div>