<?php 

class SeatView extends Seat{
    private $seats; // seats associative array 
 
    public function __construct($play_id){
       $this->seats = $this->getSeats($play_id);
    }

    //Method to generate Graphic Seat Plan 
    public function showSeats($modal){
       //Creaste DOM ELEMENT
       $dom = new DOMDocument('1.0', 'utf-8');

       // <div class="btn-toolbar justify-content-center">
       $stage = $dom->createElement('div', ''); 
       $stage->setAttribute("class","d-grid py-1");
       $stage->setAttribute("id","stage");
       $dom->appendChild($stage);   

       // <button class="btn btn-primary stage" type="button">Stage</button>
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
            $idArray = array_fill(1,12,0); //array to store ids per row
            for ($j = 1; $j <= 12; $j++) {
                //Calculate the seat number
                $seatNumber = $j + (($i-1)*12);

                //Cost for current seat
                $cost = number_format($this->seats[$seatNumber-1]["cost"],2);

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
                $seatLabel->setAttribute("id","{$seatNumber}");
                $seatLabel->setAttribute("class","btn btn-outline-dark seat");
                $seatLabel->setAttribute("for","{$l}{$j}");
                $seatLabel->setAttribute("data-bs-toggle","popover");
                $seatLabel->setAttribute("data-bs-trigger","hover focus");
                $seatLabel->setAttribute("data-bs-placement","top");
                $seatLabel->setAttribute("data-bs-content","\${$cost}");
                //<span class='seatN'>{$l}{$j}</span></label>
                $seatSpan = $dom->createElement("span", "{$l}{$j}"); 
                $seatSpan->setAttribute("class","font-monospace seatN");
                $seatLabel->appendChild($seatSpan);      

                //Append to the row
                $seatRow->appendChild($seatChkBox);      
                $seatRow->appendChild($seatLabel);                
                
                $idArray[$j] = "{$l}{$j}";

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
                $rowButton->setAttribute("onclick","selectRow({$idJson})");
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


}