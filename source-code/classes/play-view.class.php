<?php 

class PlayView extends Play{
    private $plays;


 
    public function __construct(){
        $this->plays = $this->getPlays(); //gets plays from the database by date in descending order
        //print_r($this->plays); 
    }
    
    public function printPlays(){
        $plays = $this->plays;
        if($plays==null){
            echo "There is not upcoming plays at this moment.";
        }
        else{
            //Creaste DOM ELEMENT
            $dom = new DOMDocument('1.0', 'utf-8');
            //Loop through all the upcoming plays 
            foreach ($plays as $play){
                //Set Date and Time  Format
                $date = date('m/d/Y',strtotime($play["stime"]));
                $sTime = date('h:i a',strtotime($play["stime"]));
                $eTime = date('h:i a',strtotime($play["etime"]));

                //<div class="col-md-6 col-lg-4">
                $colmd = $dom->createElement('div', ''); 
                $colmd->setAttribute("class","col-md-6 col-lg-4");
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
                $img->setAttribute("src","images/plays/" . $play["play_id"] . ".png");
                $img->setAttribute("alt","PlayName");
                $thumbnail->appendChild($img); //is inside thumbnail

                //<div class="caption">
                $caption = $dom->createElement('div', ''); 
                $caption->setAttribute("class","caption");
                $thumbnail->appendChild($caption); //goes after img inside thumbnail
            
                //Play Title <h1 class="card-title league">Here the name of the play</h1>
                $title = $dom->createElement("h1", $play["play_title"]); 
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
                $shortDesc = $dom->createElement("p", $play["short_desc"]); 
                $shortDesc->setAttribute("class","card-text");
                $cardBody->appendChild($shortDesc); // is inside cardbody
                
                //Purchase <button type="button" class="btn btn-secondary">Purchase or Log In </button>
                $purchase = $dom->createElement('button', 'Purchase'); 
                $purchase->setAttribute("type","button");
                $purchase->setAttribute("class","btn btn-secondary");
                $cardBody->appendChild($purchase); // after shortDesc in cardBody  
            }
            //print plays
            echo $dom->saveXML();
        }
    }


}