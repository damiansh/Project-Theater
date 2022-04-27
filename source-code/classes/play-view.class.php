<?php 

class PlayView extends Play{
    private $plays;

    //Get Upcoming and Published Plays
    public function getAllPlays(){
        $this->plays = $this->getUpcomingPlays(); 
    }
    
    //gets a specific play by ID
    public function getPlayData($playID){
        $this->plays = $this->getPlay($playID); 
    }

    public function printPlays($column){
        $plays = $this->plays;
        if($plays==null){
            echo "There is not upcoming plays at this moment.";
        }
        else{
            //Loop through all the upcoming plays 
            foreach ($plays as $play){
                echo $this->playCard($play["play_id"],$play["play_title"],$play["short_desc"],$play["stime"],$play["etime"],$column)->saveXML();
            }
            //print plays
           // echo $dom;
        }
    }

    //returns the play information 
    public function getPlayInfo(){
        return $this->plays; 

    }

    public function playCard($playID, $playTitle, $shortDesc,$sTimeR, $eTimeR, $column){
        //Creaste DOM ELEMENT
        $dom = new DOMDocument('1.0', 'utf-8');
        //Set Date and Time  Format
        $date = date('m/d/Y',strtotime($sTimeR));
        $sTime = date('h:i a',strtotime($sTimeR));
        $eTime = date('h:i a',strtotime($eTimeR));

        //image url 
        $hostname = getenv('HTTP_HOST');
        $link ="http://{$hostname}/images/plays/";
        $link ="http://{$hostname}/losportales/images/plays/"; //comment this when testing live

        //<div class="col-md-6 col-lg-4">
        $colmd = $dom->createElement('div', ''); 
        $colmd->setAttribute("class",$column);
        $dom->appendChild($colmd);

        //<div class="card mb-3 text-white black text-center">
        $cardmb3 = $dom->createElement('div', ''); 
        $cardmb3->setAttribute("class","card mb-3 text-white black text-center");
        $colmd->appendChild($cardmb3); //is inside colmd

        //<div class="row">
        $row = $dom->createElement('div', ''); 
        $row->setAttribute("class","row");
        $cardmb3->appendChild($row); // is inside cardmb3

        // <div class="thumbnail text-center"> 
        $thumbnail = $dom->createElement('div', ''); 
        $thumbnail->setAttribute("class","thumbnail text-center");
        $row->appendChild($thumbnail); //is inside row
    
        // <img class="card-img-top darker" src="images/plays/placeholder.png" alt="Play Name">
        $img = $dom->createElement('img', ''); 
        $img->setAttribute("class","card-img-top darker");
        $img->setAttribute("src",$link . $playID . ".png");
        $img->setAttribute("alt","PlayName");
        $thumbnail->appendChild($img); //is inside thumbnail

        //<div class="caption">
        $caption = $dom->createElement('div', ''); 
        $caption->setAttribute("class","caption");
        $thumbnail->appendChild($caption); //goes after img inside thumbnail
    
        //Play Title <h1 class="card-title league">Here the name of the play</h1>
        $title = $dom->createElement("h1", $playTitle); 
        $title->setAttribute("class","card-title league");
        $caption->appendChild($title); //is inside caption

        //<div class="card-body">
        $cardBody = $dom->createElement('div', ''); 
        $cardBody->setAttribute("class","card-body");
        $cardmb3->appendChild($cardBody); // is inside cardmb3

        //<div class="btn-group" role="group">
        $btnGroup = $dom->createElement('div', ''); 
        $btnGroup->setAttribute("class","btn-group");
        $btnGroup->setAttribute("role","group");
        $cardBody->appendChild($btnGroup); // is inside card body

        //DATE OF THE PLAY <button type="button" class="btn btn-dark fw-bold">Start Date</button>
        $date = $dom->createElement('button', $date); 
        $date->setAttribute("type","button");
        $date->setAttribute("class","btn btn-dark fw-bold");
        $btnGroup->appendChild($date); // is inside button group

        //Start and End Time <button type="button" class="btn btn-dark fw-bold">8:00 P.M. - 10:00 P.M.</button>
        $time = $dom->createElement("button", "{$sTime} - {$eTime}"); 
        $time->setAttribute("type","button");
        $time->setAttribute("class","btn btn-dark fw-bold");
        $btnGroup->appendChild($time); // is inside button group      
        
        //Short Description <p class="card-text">Short just this line so it doesn't deform the element</p>
        $shortDesc = $dom->createElement("p", $shortDesc); 
        $shortDesc->setAttribute("class","card-text");
        $cardBody->appendChild($shortDesc); // is inside cardbody

        //Purchase <button type="button" class="btn btn-secondary">Purchase or Log In </button> 
        if(strcmp($column,"col-md-6 col-lg-6 col-xl-4 py-1") ==0){ //only purchase if in homepage
            $purchase = $dom->createElement('button', 'Purchase'); 
            $purchase->setAttribute("type","button");
            $purchase->setAttribute("class","btn btn-secondary");
            $cardBody->appendChild($purchase); // after shortDesc in cardBody  
        }

        return $dom;
    }


}