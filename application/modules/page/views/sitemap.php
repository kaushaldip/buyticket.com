<?php header('Content-type: text/xml'); ?>
<?php    
    /* create a dom document with encoding utf8 */
    $domtree = new DOMDocument('1.0', 'UTF-8');

    /* create the root element of the xml tree */
    $xmlRoot = $domtree->createElement("xml");
    /* append it to the document created */
    $xmlRoot = $domtree->appendChild($xmlRoot);

    $currentTrack = $domtree->createElement("urlset");
    $currentTrack = $xmlRoot->appendChild($currentTrack);
    /**
     * home page
     */
    $currentTrack1 = $domtree->createElement("url");
    $currentTrack1 = $currentTrack->appendChild($currentTrack1);
    $currentTrack1->appendChild($domtree->createElement('loc',site_url()));
    $currentTrack1->appendChild($domtree->createElement('lastmod','2013-01-01'));
    $currentTrack1->appendChild($domtree->createElement('changefreq','monthly'));
    $currentTrack1->appendChild($domtree->createElement('priority','0.8'));
    
    $currentTrack1 = $domtree->createElement("url");
    $currentTrack1 = $currentTrack->appendChild($currentTrack1);
    $currentTrack1->appendChild($domtree->createElement('loc',site_url_ae('', TRUE)));
    $currentTrack1->appendChild($domtree->createElement('lastmod','2013-01-01'));
    $currentTrack1->appendChild($domtree->createElement('changefreq','monthly'));
    $currentTrack1->appendChild($domtree->createElement('priority','0.8'));
    /*
     * 
     * loop for cms data
     */
     
        
    foreach ($cms as $cm):
        $currentTrack1 = $domtree->createElement("url");
        $currentTrack1 = $currentTrack->appendChild($currentTrack1);
        $currentTrack1->appendChild($domtree->createElement('loc',site_url("/page/".$cm->cms_slug)));
        $currentTrack1->appendChild($domtree->createElement('lastmod',date('Y-m-d',  strtotime($cm->last_update))));
        $currentTrack1->appendChild($domtree->createElement('changefreq','monthly'));
        $currentTrack1->appendChild($domtree->createElement('priority','0.8'));
    
        $currentTrack1 = $domtree->createElement("url");
        $currentTrack1 = $currentTrack->appendChild($currentTrack1);
        $currentTrack1->appendChild($domtree->createElement('loc',site_url_ae("/page/".$cm->cms_slug, TRUE)));
        $currentTrack1->appendChild($domtree->createElement('lastmod',date('Y-m-d',  strtotime($cm->last_update))));
        $currentTrack1->appendChild($domtree->createElement('changefreq','monthly'));
        $currentTrack1->appendChild($domtree->createElement('priority','0.8'));
    endforeach;    
    foreach ($event as $ev):
        $oid = $ev->organizer_id;
        $organizre_status = $this->general->get_value_from_id('es_user',$oid,'organizer');
        if($organizre_status == '1'){            
            $currentTrack1 = $domtree->createElement("url");
            $currentTrack1 = $currentTrack->appendChild($currentTrack1);
            $currentTrack1->appendChild($domtree->createElement('loc',site_url("event/view/".$ev->id."/".$this->general->get_url_name($ev->title))));
            $currentTrack1->appendChild($domtree->createElement('lastmod',date('Y-m-d',  strtotime($ev->updated_date))));
            $currentTrack1->appendChild($domtree->createElement('changefreq','weekly'));
            $currentTrack1->appendChild($domtree->createElement('priority','0.8'));
            
            $currentTrack1 = $domtree->createElement("url");
            $currentTrack1 = $currentTrack->appendChild($currentTrack1);
            $currentTrack1->appendChild($domtree->createElement('loc',site_url_ae("event/view/".$ev->id."/".$this->general->get_url_name($ev->title), TRUE)));
            $currentTrack1->appendChild($domtree->createElement('lastmod',date('Y-m-d',  strtotime($ev->updated_date))));
            $currentTrack1->appendChild($domtree->createElement('changefreq','weekly'));
            $currentTrack1->appendChild($domtree->createElement('priority','0.8'));
        }
        
    endforeach;
/* get the xml printed */
    echo $domtree->saveXML();
?>