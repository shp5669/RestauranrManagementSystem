<header class="c-header">
  <h1>Event Management Menu</h1>
  <p></p>
  <?php
    include("connection.php");
    //session_cache_limiter('private_no_expire');
    session_start();
    
    
  ?>
</header>
<body>
<div class="background">
<section class="c-posts">
<div class="new1">
  <article class="c-posts__item">
  </article>
</div>   
</section>

<?php
  if (!isset($_POST['eventID'])) {//event ID - create new event 
    $viewName = "";
    $viewNumAtendees = "";
    $viewDate = 0;
    $viewDescription = "";

    $value = "create";

    $submitValue = "Save Changes";
    $formHeader = "Create Event: ";
    $organiserID = $_POST['organiserID'];
  }
  else {
    $viewName = $_POST['name'];
    $viewNumAtendees = $_POST['numAtendees'];
    $viewDate = $_POST['date'];
    $viewDescription = $_POST['description'];
    $organiserID = $_POST['organiserID'];
    //$specialRequestsID = $_POST['specialRequestsID'];
    $value = "edit";
    $eventID = $_POST['eventID'];

    $query = "select * from specialRequests where eventID = '$eventID'";
    $result = mysqli_query($con, $query);  
    $result1 = $result->fetch_array();
    $veganOptions = $result1["veganOptions"];
    $specialCake = $result1["specialCake"];
    $largeTable = $result1["largeTable"];
    $tablesOutside = $result1["tablesOutside"];
    $kidsMeals = $result1["kidsMeals"];
    $largePizzas = $result1["exLargePizzas"];
    $playSong = $result1["playSong"];

    if (isset($_POST["employeeID"])) {
      $submitValue = "Submit Changes";
      $formHeader = "Manage event: ";
    }
    else {
      $submitValue = "Save Changes";
      $formHeader = "Edit event: ";
    }
  }

?>
        <form action="searchEvent.php" method="POST">
        <div class=""><h3><?php echo "$formHeader" . $viewName;?></h3><br><br></div>
        <label id="icon" for="name"><i class="input"> Name:  </i></label><br><br>
        <?php if (!isset($_SESSION['user'])) {?>
        <input type="text" name="name" id="name" value="<?php echo $viewName;?>" required/>
        <?php } else { ?>
          <p><?php echo $viewName; ?></p>
        <?php } ?>
        <br>
        <br>
        <br>
        <label id="icon"><i class="input">Number of atendees:  </i></label><br><br>
        <?php if (!isset($_SESSION['user'])) {?>
        <input type="number" name="numAtendees" id="numAtendees" value="<?php echo $viewNumAtendees;?>" min="1" required/>
        <?php } else { ?>
          <p><?php echo $viewNumAtendees; ?></p>
        <?php } ?>
        <br>
        <br>
        <br>
        <?php if (!isset($_SESSION['user'])) {?>
        <label id="icon" ><i class="input">Event date: </i></label><br><br>
        <input type="date" name="date" id="date" value="<?php echo $viewDate;?>" required/>
        <?php } else { ?>
          <p><?php echo $viewDate; ?></p>
        <?php } ?>
        <br>
        <br>
        <br>
        <label id="icon"><i class="input">Description </i></label><br><br>
        <?php if (!isset($_SESSION['user'])) {?>
        <input type="text" name="description" id="description" value="<?php echo $viewDescription;?>" required/>
        <?php } else { ?>
          <p><?php echo $viewDescription; ?></p>
        <?php } ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <?php if (!isset($_SESSION['user'])) {?>
        <h2>Special Requests:</h2>
        <br>
        <br>
        <br>
        <label for="name">Select vegan catering:</label> <br><br>
          <select name="veganOptions" id="veganOptions"> 
              <option value="AllOrders">All orders</option> 
              <option value="Entrees">Entrees</option> 
              <option value="EntreesMains">Entrees and mains</option> 
              <option value="Mains">Mains</option> 
              <option value="MainsDesserts">Mains and desserts</option> 
              <option value="None" selected>None</option> 
          </select>
          <?php if (isset($_POST['eventID']))  {
            echo "<p>Current preference: " . $veganOptions . "</p>";
          } ?>
          <br>
          <br>
          <br>
          <label for="name">Select a cake:</label> <br><br>
          <select name="specialCake" id="specialCake"> 
              <option value="Chocolate">All orders</option> 
              <option value="BlackForest">Black Forest</option> 
              <option value="IceCreamCake">Ice Cream Cake</option> 
              <option value="Tirimasu">Tirimasu</option> 
              <option value="None" selected>None</option> 
          </select>
          <?php if (isset($_POST['eventID']))  {
            echo "<p>Currently selected: " . $specialCake . "</p>";
          } ?>
          <br>
          <br>
          <br>
          <label>Select table size:</label> <br><br>
          <input type="number" name="tableSize" id="tableSize" value="<?php echo $largeTable ?>" min="1" required/>
          <?php if (isset($_POST['eventID']))  {
            echo "<p>Currently set: " . $largeTable . "</p>";
          } ?>
          <br>
          <br>
          <br>
          <label>Tables outside?</label><br><br>
          <input type="checkbox" id="tablesOutside" name="tablesOutside">
          <br>
          <?php if (isset($_POST['eventID']))  {
             if ($tablesOutside == 0) {
              echo "<p>Current preference: No </p>";
            }
            else {
              echo "<p>Current preference: Yes </p>";
            }    
          } ?>
          <br>
          <br>
          <label>Request kids meals</label><br><br>
          <input type="checkbox" id="kidsMeals" name="kidsMeals">
          <?php if (isset($_POST['eventID']))  {
             if ($kidsMeals == 0) {
              echo "<p>Current preference: No </p>";
            }
            else {
              echo "<p>Current preference: Yes </p>";
            }    
          } ?>
          <br>
          <br>
          <br>
          <label>Order extra large pizzas</label><br><br>
          <input type="checkbox" id="largePizzas" name="largePizzas">
          <?php if (isset($_POST['eventID']))  {
            if ($largePizzas == 0) {
              echo "<p>Current preference: No </p>";
            }
            else {
              echo "<p>Current preference: Yes </p>";
            }           
          } ?>
          <br>
          <br>
          <br>
          <label>Play song during dinner</label><br><br>
          <input type="text" name="song" id="song" value="None"/>
          <?php if (isset($_POST['eventID']))  {
            echo "<p>Current song preference (if any): " . $playSong . "</p>";
          } ?>
          <?php } else { ?>

          <?php } ?>
        <input type='hidden' name='eventID' id='eventID' value="<?php echo $eventID;?>"/>
        
        <?php if (!isset($_POST['eventID'])) {?>
        <input type='hidden' name='organiserID' id='organiserID' value="<?php echo $organiserID;?>"/>
        <?php } ?>
        <input type='hidden' name='task' id='task' value="<?php echo $value;?>"/>
        <br><br><br>

          <?php 
          if (isset($_POST['status']) && $_POST['status'] == "submitted" && isset($_SESSION['user']) && $_SESSION['user'] == "employee") { ?>
          <select name="status" id="status"> 
              <option value="approved">Approve</option> 
              <option value="rejected">Reject</option> 
              <option value="submitted" selected>Do nothing</option> 
          </select>
          <?php } else if (!isset($_POST['status'])) {?>
          <input type='hidden' name='status' id='status' value="<?php echo $submitted;?>"/>
          <?php } ?>

      </div>
        <div>
          <input class="c-btn"id="button" type="submit" value="<?php echo "$submitValue"; ?>"><br><br>
        </div>
      </form>
    </div>

 <?php
    if (isset($_POST['organiserID']) && isset($_POST['eventID'])) {
      echo "
        <div class='main-block' style='text-align:center; padding:20px;'>
        <div id='box'>
          <form method='post' action='searchEvent.php'>
          <input type='hidden' name='eventID' id='eventID' value=" . "$eventID" . "/>
          <input type='hidden' name='task' id='task' value= 'delete'/>
          <input class='c-btn'id='button' type='submit' value='delete'>
          <br><br>
          </div>
        </form>
      </div>
      ";
    }
    ?>







</body>