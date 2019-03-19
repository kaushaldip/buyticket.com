<?php
header("Content-Type: text/xml;charset=UTF-8,true");

echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
    $rssfeed = '<rss version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>'.$country.' feed</title>';
    $rssfeed .= '<link>'.site_url().'</link>';
    $rssfeed .= '<description>This is '.$country.' RSS feed</description>';
    $rssfeed .= '<language>en-us</language>';
    $rssfeed .= '<copyright>Copyright (C) 2013 '.site_url().'</copyright>';
 if($country_feed){
     foreach($country_feed as $cf):
     $description=strip_tags($cf->description);
 $link=site_url("event/view/".$cf->id);
    $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $cf->title . '</title>';
        $rssfeed .= '<description>' . $description . '</description>';
        $rssfeed .= '<link>' . $link . '</link>';
        $rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($cf->updated_date)) . '</pubDate>';
        $rssfeed .= '</item>';
        endforeach;
 } 
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed;
/* End of file feed.php */
/* Location: ./system/application/controllers/feed.php */ 
