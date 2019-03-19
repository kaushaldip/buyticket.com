<section id="product-sec">
<h1><?php echo $this->lang->line('all_testimonial');?></h1>
<div class="testimonial-area">

<?php foreach($testimonial_data as $testimonial){?>
<article>
  <img src="<?php echo site_url($testimonial->image);?>"  />
  <div class="t-textbg"><?php echo $testimonial->description;?></div>
<ul>

<li><?php echo $testimonial->winner_name;?></li>
<li><span><?php echo $this->lang->line('footer_item_name');?>:</span> <?php echo $testimonial->product_name;?></li>
</ul> 
</article>
<?php }?>
</div>
<div class="h-shaing"></div>

</section>