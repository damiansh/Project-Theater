
<div class="container">
<h1 class="eTitle display-3 text-center my-4">Add Plays</h1>
<p>Please fill this form to add a new play to the system.</p>
      <?php
        if(isset($_SESSION["message"])){
          echo "<p class='nMessage'>{$_SESSION["message"]}</p>";
          $_SESSION["message"] = "";
        }
      ?>
      <hr>
            <form   action="includes/included-play.php"  method="post">
                <div class="form-floating mb-3">
                    <input type="text" placeholder="Play Title"  class="form-control"  name="playTitle" id="playTitle" >
                    <label for="playTitle">Play Title:</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" placeholder="Short synopsis for the play"  class="form-control"  name="shortDesc" id="shortDesc" >
                    <label for="shortDesc" class="form-label">Short Synopsis:</label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="longDesc" name="longDesc" placeholder="Longer description of the play" style="height: 100px">
                    </textarea>
                    <label for="longDesc">Long Description:</label>
                </div>
                <div class="row g-2">
                <div class="col-md"><div class="form-floating mb-3">
                    <input type="datetime-local"  class="form-control"  name="sDate" id="sDate" >
                    <label for="sDate" class="form-label">Start Date: </label>            
                </div> </div>
                <div class="col-md"><div class="form-floating mb-3">
                    <input type="datetime-local"  class="form-control"  name="eDate" id="eDate" >
                    <label for="eDate" class="form-label">End Date: </label>
                </div></div>  
                </div>   
                <div class="form-floating mb-3">
                    <input type="number" value="20" placeholder="Default Price for Seats"  step="0.1" class="form-control"  name="cost" id="cost" >
                    <label for="cost" class="form-label">Default Price:</label>
                </div> 
                <div class="mb-3">
                    <input type="file" class="image">
                    <input type="hidden" id="imageData" name="image">
                </div>
                <center>
                <button type="submit" name ="addP" class="btn btn-secondary btn-lg">Add Play</button>
                <button type="reset" value="Reset" class="btn btn-secondary btn-lg">Clear</button>
                </center>


            </form>
</div>
<?php include 'crop.php';?>

      