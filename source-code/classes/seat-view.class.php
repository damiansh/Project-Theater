<?php 

class SeatView extends Seat{
    private $seats; // seats associative array 
 
    public function __construct($play_id){
       $this->seats = $this->getSeats($play_id);
    }

    public function setCart(){
        $this->seats = $this->getCartContent();
        return $this->seats; 
     }

    //Method to generate Graphic Seat Plan 
    public function showSeats($modal){
       //Creaste DOM ELEMENT
       $dom = new DOMDocument('1.0', 'utf-8');

       // <div class="btn-toolbar justify-content-center"> COLOR TOOLBAR
       $colorBar = $dom->createElement('div', ''); 
       $colorBar->setAttribute("class","btn-toolbar justify-content-center py-1");
       $colorBar->setAttribute("id","stageColors");
       $dom->appendChild($colorBar);   

       // AVAILABLE DIV
       $buttonDiv = $dom->createElement('div', ''); 
       $buttonDiv->setAttribute("class","px-2");
       $colorBar->appendChild($buttonDiv);    
       // Available Seats Color
       $color = $dom->createElement('button', 'Available'); 
       $color->setAttribute("class","btn btn-success");
       $buttonDiv->appendChild($color);    

       // Reserved Div
       $buttonDiv = $dom->createElement('div', ''); 
       $buttonDiv->setAttribute("class","px-2");
       $colorBar->appendChild($buttonDiv);    
       // Reserved Seats Color
       $color = $dom->createElement('button', 'Reserved (10 minutes)'); 
       $color->setAttribute("class","btn btn-dark");
       $buttonDiv->appendChild($color);   

       // Sold Div
       $buttonDiv = $dom->createElement('div', ''); 
       $buttonDiv->setAttribute("class","px-2");
       $colorBar->appendChild($buttonDiv);    
       // Sold Seats COlor
       $color = $dom->createElement('button', 'Sold'); 
       $color->setAttribute("class","btn btn-danger");
       $color->setAttribute("style","background-color:#cc0000");
       $buttonDiv->appendChild($color);   

       // Stage Div
       $stage = $dom->createElement('div', ''); 
       $stage->setAttribute("class","d-grid py-1");
       $stage->setAttribute("id","stage");
       $dom->appendChild($stage);   

       // Stage Button
       $stageBTN = $dom->createElement('button', 'Stage'); 
       $stageBTN->setAttribute("class","btn btn-primary");
       $stage->appendChild($stageBTN);  
       
       
          
       $l = "A";
       //loop for rows
       for ($i = 1; $i <= 8; $i++) {
            //"<div class='btn-toolbar justify-content-center'>";
            $seatRow= $dom->createElement('div', ''); 
            $seatRow->setAttribute("class","btn-toolbar justify-content-center");
            $dom->appendChild($seatRow);
            $idArray = new ArrayObject();
            for ($j = 1; $j <= 12; $j++) {
                //Calculate the seat number
                $seatNumber = $j + (($i-1)*12);

                //Cost for current seat
                $cost = number_format($this->seats[$seatNumber-1]["cost"],2);

                //get status
                $status = $this->seats[$seatNumber-1]["status"];

                //<input  type='checkbox' class='btn-check' id='{$l}{$j}' 
                //autocomplete='off' data-seat='$counter' onchange='seatToggle(this)'>";
                $seatChkBox = $dom->createElement('input', ''); 
                $seatChkBox->setAttribute("type","checkbox");
                $seatChkBox->setAttribute("class","btn-check");
                $seatChkBox->setAttribute("id","{$l}{$j}");
                $seatChkBox->setAttribute("autocomplete","off");
                $seatChkBox->setAttribute("data-seat","{$seatNumber}");
                $seatChkBox->setAttribute("onchange","seatToggle(this)");

                //Append to the row
                $seatRow->appendChild($seatChkBox);

                //<label id='{$counter}' class='btn btn-outline-dark seat' for='{$l}{$j}'
                //data-bs-toggle='popover' data-bs-trigger='hover focus' data-bs-placement='top' data-bs-content='\${$cost}'>
                $seatLabel = $dom->createElement('label', ''); 
                $seatLabel->setAttribute("data-bs-toggle","popover");
                $seatLabel->setAttribute("data-bs-trigger","hover focus");
                $seatLabel->setAttribute("data-bs-placement","top");
                $seatLabel->setAttribute("id","{$seatNumber}");
                if($status==1){
                    $status = $this->removeReservation($seatNumber-1);
                }
                if($status==1){
                    $seatLabel->setAttribute("class","btn btn-dark seat countdown");
                    $seatLabel->setAttribute("data-bs-content","Reserved seat");
                }
                elseif($status==2){
                    $seatLabel->setAttribute("class","btn btn-danger seat");
                    $seatLabel->setAttribute("style","background-color:#cc0000");
                    $seatLabel->setAttribute("data-bs-content","This seat has been sold.");
                }
                else{
                    $seatLabel->setAttribute("class","btn btn-success seat");
                    $seatLabel->setAttribute("for","{$l}{$j}");
                    $seatLabel->setAttribute("data-bs-content","\${$cost}");
                    $idArray[$j] = "{$l}{$j}";


                }
     

                //<span class='seatN'>{$l}{$j}</span></label>
                $seatSpan = $dom->createElement("span", "{$l}{$j}"); 
                $seatSpan->setAttribute("class","font-monospace seatN");
                $seatSpan->setAttribute("id","s{$seatNumber}");
                $seatLabel->appendChild($seatSpan);      

                //Append to the row
                $seatRow->appendChild($seatChkBox);      
                $seatRow->appendChild($seatLabel);                
                

            }
            $idJson = json_encode($idArray);
            //<button type='button' id='{$l}' class='btn btn-secondary btn-sm selector' 
            //onclick='selectRow({$idJson})'>Toggle {$l}</button>";
            //Modal = 0 then customer area, modal 1 then managementa area. 
            if($modal==1){
                $rowButton = $dom->createElement("button", "{$l}"); 
                $rowButton->setAttribute("type","button");
                $rowButton->setAttribute("id","{$l}");
                $rowButton->setAttribute("class","btn btn-secondary btn-sm selector font-monospace");
                $rowButton->setAttribute("onclick","selectRow('{$l}',{$idJson})");
                //Append to the row
                $seatRow->appendChild($rowButton);     
            } 
            $l++; //next letter in the abcd
       }

       //print graphic seat plan
       $dom = $dom->saveXML();
       echo $dom;
       echo "<script>graphicPlan()</script>";
       return $this->seats; 
    }

    //Shows the shopping cart
    public function showCart(){
        $i =0;
        foreach ($this->seats as $seat){
            if($this->removeReservation($i)==1){
                echo $seat["ticket_id"] . "<br>";
            }
            $i++;
        }
    }
    //Detects reservation and removes if time limit pases
    public function getCount(){
        $count = 0; 
        $i =0;
        foreach ($this->seats as $seat){
            if($this->removeReservation($i)==1){
                $count++;
            }
            $i++;
        }
        return $count;
    }
    //Detects reservation and removes if time limit pases
    private function removeReservation($i){
        date_default_timezone_set('America/Boise'); // change to MOUNTAIN TIME
        $currentSeat = $this->seats[$i];
        $reservedTime = $currentSeat["reserved"];
        $reservedTime = new DateTime($reservedTime);
        $reservedTime->modify('+10 minutes');
        
        $currentDate = new DateTime('now');
        
        if($currentDate>$reservedTime){
            $this->updateReservation($currentSeat,0,null,0);
            return 0;
        }

        return 1; 
    }

}