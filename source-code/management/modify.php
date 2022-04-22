<!DOCTYPE html>
<html>
<head>
  <title>Management Area</title>
  <?php include 'dependencies.php';?>
</head>
<body>

<?php include 'navbar.php';?>
<div class="topImg" style="background-image:url('../images/modify-play.jpg')">
    <div class="txt-overlay d-flex justify-content-center align-items-center">
      <h1 class="eTitle">Modify Plays</h1>
    </div>
</div>
<div class="container">

<?php include '../classes/db.class.php';?>
<?php include '../classes/seat.class.php';?>
<?php include '../classes/seat-contr.class.php';?>

  <div class="row">
  <div class="col-sm py-1">
      <form action=""  method="post">
        <div class="form-floating mb-3">
          <textarea class="form-control" id="longDesc" name="longDesc" placeholder="Longer description of the play"  disabled style="height: 100px">
          </textarea>
          <label for="longDesc">Long Description:</label>
        </div>
        <div class="row g-2">
          <div class="col-md"><div class="form-floating mb-3">
            <input type="datetime-local"  class="form-control"  name="sDate" id="sDate" disabled>
            <label for="sDate" class="form-label">Start Date: </label>            
          </div></div>
        <div class="col-md"><div class="form-floating mb-3">
            <input type="datetime-local"  class="form-control"  disabled>
            <label for="eDate" class="form-label">End Date: </label>
          </div></div>  
        </div>   
        <div class="form-floating mb-3">
          <input type="number"  step="0.1" class="form-control"  name="cost" id="cost" required>
          <label for="cost" class="form-label">Price For:</label>
        </div>
        <div id="costLabel" class="d-flex flex-wrap" ></div>
 

      </form>
 
      </div>
    <div class="col-sm py-1">
      <div class="btn-toolbar justify-content-center">
        <button class="btn btn-primary stage" type="button">Stage</button>
      </div>
      <?php 
        $seat = new SeatContr(19);
        $seats = $seat->showSeats();
        $l = "A";
        $counter = 1;
        for ($i = 1; $i <= 8; $i++) {
          $idArray = array_fill(1,12,0);
          echo "<div class='btn-toolbar justify-content-center'  role='toolbar'>";
          for ($j = 1; $j <= 12; $j++) {
            $cost = number_format($seats[$counter-1]["cost"],2);
            echo "<input  type='checkbox' class='btn-check' id='{$l}{$j}' autocomplete='off' data-seat='$counter' onchange='seatToggle(this)''>";
            echo "<label id='{$counter}' class='btn btn-outline-dark seat' for='{$l}{$j}'>
            <span class='seatN'>{$l}{$j}</span></label>";
            $idArray[$j] = "{$l}{$j}";
            $counter++;
          }
          $idJson = json_encode($idArray);
          echo "<button type='button' id='{$l}' class='btn btn-secondary btn-sm selector' onclick='selectRow({$idJson})'>Toggle {$l}</button>";
          $l++;
          echo "</div>";
        }
      ?>
        <div class="d-grid py-1">
          <button type="button" class="btn btn-secondary">Toggle All Seats</button>
        </div>
      </div>


  </div>
  <div class="d-grid">
          <button type="submit" name="publish"  class="btn btn-success">Publish Play</button>
        </div>
</div>

</body>

</html>
<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
      return new bootstrap.Popover(popoverTriggerEl)
    })  
    var js_seats = '<?php echo json_encode($seats); ?>';
    var seats = JSON.parse(js_seats);
    var cost = document.getElementById("cost");
    var costSel = document.getElementById("costLabel");

    function seatToggle(seat){
      seatNumber = seat.dataset.seat;
      seatButton = document.getElementById(seatNumber); //get the Toggled button
      if(seat.checked){
        //Set seat button to checkeed color 
        seatButton.style.backgroundColor = "#006400";
        //Create seat tags 
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
        costSel.appendChild(seatDiv); 

      }
      else{
        //get seat tag and remove the tag
        seatTag = document.getElementById("seat" + seat.id)
        costSel.removeChild(seatTag);
        //set seat button to not checked color 
        seatButton.style.backgroundColor = "";
      } 
    }

    function selectRow(idArray){
      rowLetter = idArray[1].charAt(0);
      currentButton = document.getElementById(rowLetter);
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
     
      for(let i = 1;i<=12;i++){
        currentSeat = document.getElementById(idArray[i]);
        currentSeat.checked = checkStatus; 
        seatToggle(currentSeat);
      }
    



    }

  </script>