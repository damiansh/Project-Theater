<!DOCTYPE html>
<html>
<head>
  <title>Management Area</title>
  <?php include 'dependencies.php';?>
</head>
<?php 
include '../classes/db.class.php';
include '../classes/seat.class.php';
include '../classes/seat-view.class.php';
include '../classes/play.class.php';
include '../classes/play-view.class.php';
$playCard = new PlayView();
if(!isset($_GET["playID"])){
    header("location: index.php?noSeatData");
}   
//Get play data 
$playID = $_GET["playID"];
$playCard->requestPlay($playID);
$playData = $playCard->getPlayInfo();

//Get the play Seats by its ID 
$seat = new SeatContr($playID);

?>

<body>

<?php include 'navbar.php';?>
<div class="topImg" style="background-image:url('../images/modify-play.jpg')">
    <div class="txt-overlay d-flex justify-content-center align-items-center">
      <h1 class="eTitle">Modify Seats</h1>
    </div>
</div>
<div class="container">

  <div class="row">
    <?php $playCard->printPlays("col-lg-5 col-xl-6 py-1",1);?>

    <div class="col-lg-7 col-xl-6 py-1">
      <?php $seats = $seat->showSeats(1);?>
        <div class="d-grid py-1">
          <button type="button" onclick="toggleAll(this)" class="btn btn-secondary">Toggle All Seats</button>
        </div>
        <form action="includes/included-seats.php"  method="post">
            <div class="row">
                <div class="col-6">
                    <input type="number"  placeholder="New price here" step="0.1" class="form-control"  name="cost" id="cost" required>
                    <input type="hidden"  name="seatsJSON" id="seatsJSON" required>
                </div>
                <div class="col-6"><button type="submit" onclick="updatePrices()" class="btn btn-success">Update Price</button></div>
            </div>

            <div id="costLabel" class="d-flex flex-wrap" ></div>

        </form>
        <div class="d-grid py-3">
          
        <form action="includes/included-play.php"  method="post">
          
            <div class="d-grid gap-2" >
              <a href="index.php?playID=<?php echo "{$playID}#play{$playID}";?>"   role="button" class="btn btn-primary" >Go back</a>
            </div> 
        </form>          
      </div>
    </div>
  </div>
</div>
<?php include "../notification.php"?>
</body>

</html>
<script>
    //Initialize popovert
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
    })
    
    //Getting seats information from the server side 
    var seats = <?php echo json_encode($seats); ?>; //encoding seats object to json 
    var cost = document.getElementById("cost"); //Cost input field (to modify prices)
    var costSel = document.getElementById("costLabel"); //Area where the selected seats are displayed 
    var seatsSelected = []; // array of seats object that contains the selected seats 
  /**
  * Function that handles the selection of seats and adds the seat to the selected list 
  * @param seat - HTML element of the input checkbox being selected (the seat in this case)
  */  
    function seatToggle(seat){
      seatNumber = seat.dataset.seat; //getting the seat number fromt he object 
      seatButton = document.getElementById(seatNumber); //get the Toggled button

      //What to do when seat is being checked 
      if(seat.checked){
        //Set seat button to checkeed color 
        seatButton.style.backgroundColor = "#006400";
        //Create selected seat button of the selected seat that go @costSel
        seatDiv = document.createElement("div"); 
        seatDiv.classList.add("p-1");
        seatTag = document.createElement("button");
        seatTag.setAttribute("type", "button");
        seatTag.classList.add("btn");
        seatTag.classList.add("btn-secondary");
        seatTag.classList.add("btn-sm");
        seatTag.style.backgroundColor = "#006400";
        seatDiv.id = "seat" + seat.id;
        seatTag.innerHTML = seat.id; 
        seatDiv.appendChild(seatTag); 
        costSel.appendChild(seatDiv); //append the button to costSel

        //add selected seats to the selected list
        seatsSelected.push(seats[seatNumber-1]); 
        //console.log(seatsSelected); for debugging purposes

      }
      else{
        //get seat tag and remove the tag
        seatTag = document.getElementById("seat" + seat.id)
        costSel.removeChild(seatTag);
        //set seat button to not checked color 
        seatButton.style.backgroundColor = "";

        //remove from the list the seat unchecked 
        removee = seatsSelected.indexOf(seats[seatNumber-1]);
        seatsSelected.splice(removee,1);
        //console.log(seatsSelected); for debugging purposes 
      } 
    }

  /**
  * Function that toggles the row of the respective row button being clicked 
  * @param idArray[] - array of the ids of the row being selected
  */  
    function selectRow(idArray){
      rowLetter = idArray[1].charAt(0);
      currentButton = document.getElementById(rowLetter);

      
      if(currentButton.classList.contains("btn-secondary")){
        currentButton.classList.remove("btn-secondary");
        currentButton.classList.add("btn-danger");
      }
      else{
        currentButton.classList.remove("btn-danger");
        currentButton.classList.add("btn-secondary");
      }
     
      for(let i = 1;i<=12;i++){
        currentSeat = document.getElementById(idArray[i]);
        ///currentSeat.checked = checkStatus; 
        if(currentSeat.checked){
          currentSeat.checked = false;
        }
        else{
          currentSeat.checked = true; 
        }
        seatToggle(currentSeat);
      }
    



    }
  /**
  * Function that toggles all the seats in the graphic plan 
  * @param currentButton - the html element of the button being clicked on 
  */  
    function toggleAll(currentButton){
      checkStatus = false; 
      if(currentButton.classList.contains("btn-secondary")){
        currentButton.classList.remove("btn-secondary");
        currentButton.classList.add("btn-danger");
        checkStatus = true; 
      }
      else{
        currentButton.classList.remove("btn-danger");
        currentButton.classList.add("btn-secondary");
        checkStatus = false; 
      }
      letter = "A"
      for(let i = 1;i<=8;i++){
        rowButton = document.getElementById(letter);
        rowButton.click();
        letter = nextChar(letter);
      }

    }

 /**
 * Function that receives a character and returns the next one 
 * @param {String} c - the character sended in the call 
 */
    function nextChar(c) {
        var res = c == 'z' ? 'a' : c == 'Z' ? 'A' : String.fromCharCode(c.charCodeAt(0) + 1);
        return res; 
    }
    
/**
 * Function that updates the new prices in the selectedList created on 
 */
    function updatePrices(){
        for(let i=0;i<seatsSelected.length;i++){
        seatsSelected[i]["cost"] = cost.value; 
        }
        seatJ = JSON.stringify(seatsSelected);
        document.getElementById("seatsJSON").value = seatJ; 

    }


 /**
 * Function that sends the JSON of the current play to the include-play 
 *  @param {Integer} p - the published status, 0 is unpublished and 1 is published 
 */
function publishPlay(p) {
      document.getElementById("playID").value = seats[0]["play_id"]; 
      document.getElementById("published").value = p; 
    }
    

  </script>