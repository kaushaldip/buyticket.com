<?php
//header("Content-Type: application/rss+xml;charset=UTF-8,true");  
header("Content-Type: text/xml;charset=UTF-8,true");

echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
    $rssfeed = '<rss version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>'.SITE_NAME.' feed</title>';
    $rssfeed .= '<link>'.site_url().'</link>';
    $rssfeed .= '<description>This is '.SITE_NAME.' RSS feed</description>';
    $rssfeed .= '<language>'.$this->config->item('language_abbr').'</language>';
    $rssfeed .= '<copyright>Copyright (C) 2013 '.site_url().'</copyright>';
        
    if($events){
        foreach($events as $event):
            $rssfeed .= '<item>';
            $rssfeed .= '<title>' . $event->title . '</title>';
            $rssfeed .= '<description>' . ucwords($event->physical_name) .' ('.ucwords($event->address) . ') </description>';
            $rssfeed .= '<link>' . site_url('event/view/'.$event->id.'/'.$this->general->get_url_name($event->title)) . '</link>';
            $rssfeed .= '<language>'.$this->config->item('language_abbr').'</language>';
			$rssfeed .= "<category>".ucwords($event->sub_type) ."</category>";
            //$rssfeed .= '<pubDate>' . date("D, d M Y H:i:s O", strtotime($cf->updated_date)) . '</pubDate>';
            $rssfeed .= '</item>';
        endforeach;
    } 
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed.'afkjaskldfasdf';
/* End of file feed.php */
/* Location: ./system/application/controllers/feed.php */ 
