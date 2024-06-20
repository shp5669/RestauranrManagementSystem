
<header>
  <h1>Events Page</h1>
  <?php
    include("connection.php");
    include("functions.php");
    //session_cache_limiter('private_no_expire');
    session_start();
    
    
  ?>
  <link rel="stylesheet" href="menuManagement.css">
  <a href="homepage.html">Home</a>
</header>

<body>
  <?php
    if (isset($_POST["changeUserButton"])) {
      changeUserType($con);
    }

    if (isset($_SESSION["user"]) && $_SESSION["user"] == "customer") {//customer using site
      $query = "select * from events where NOT status = 'rejected'";
      $result = mysqli_query($con,$query);
      echo "<h4>You are logged in as a customer.</h4>";
    }
    else if (isset($_SESSION["user"]) && $_SESSION["user"] == "customer") {//employee using site
      $query = "select * from events where NOT status = 'rejected'";
      $result = mysqli_query($con,$query);
      echo "<h4>You are logged in as an employee.</h4>";
    }
    else {
      $query = "select * from events where NOT status = 'rejected'";
      $result = mysqli_query($con,$query);
      echo "<h4>You are logged in as a customer.</h4>";
    }
    
    if (isset($_POST['task'])) {
      $value = $_POST['task'];
      $eventID = $_POST['eventID'];
  
      if ($value == 'edit' || $value == 'create') {
        if (!isset($_POST["pID"])) {//If customer not employee
          $eventName = $_POST['name'];
          $numAtendees = $_POST['numAtendees'];
          $eventDate = $_POST['date'];
          $eventDescription = $_POST['description'];
          
          //Get specialrequest data
          $veganOptions = $_POST['veganOptions'];
          $specialCake = $_POST['specialCake'];
          $tableSize = $_POST['tableSize'];
          $tablesOutside = isset($_POST['tablesOutside']);
          $kidsMeals = isset($_POST['kidsMeals']);
          $largePizzas = isset($_POST['largePizzas']);
          $playSong = $_POST['song'];
        }
        else {
          $iName = $_POST['name'];
          $iStatus = $_POST['status'];
        }
        
        if ($value == 'edit') {
          if (!isset($_POST["customerID"])) {
            //$specialReqID = $_POST['specialRequestsID'];
            $eventID = $_POST['eventID'];
            $query = "update events set name='$eventName', numAtendees='$numAtendees', date='$eventDate', description='$eventDescription' where eventID = '$eventID';";
            mysqli_query($con,$query);
            $query1 = "select * from events where name = '$eventName'";
            $res = mysqli_query($con,$query1)->fetch_assoc();
            $res1 = $res['eventID'];
            $query2 = "update specialRequests set veganOptions='$veganOptions', specialCake='$specialCake', largeTable='$tableSize', tablesOutside='$tablesOutside', kidsMeals='$kidsMeals', exLargePizzas='$largePizzas', playSong='$playSong' where eventID = '$res1';";          
            mysqli_query($con,$query2); 
            echo "<h3>Event edited.</h3>";
            $value = "None";
            header("Refresh:0");
          }
          else {
            if ($iStatus == "approved") {
              echo "<h3>Event has already been approved.</h3>";
            }
            else {
              $query = "update events set status='$iStatus' where eventID = '$eventID';";
              mysqli_query($con,$query);
              echo "<h3>Event " . $iName . " has been approved. </h3>";
            }
          }
          //$value = "None";
          //header("Refresh:0");
        }
        else if ($value == 'create') {
          $organiserID = $_POST['organiserID'];
          $num = new num();
          $value = $num->getID();
          $query = "insert into events (name,numAtendees,date,description) values ('$eventName','$numAtendees','$eventDate','$eventDescription')";
          //$query2 = "update specialRequests set veganOptions='$veganOptions', specialCake='$specialCake', largeTable='$tableSize', tablesOutside='$tablesOutside', kidsMeals='$kidsMeals', exLargePizzas='$largePizzas', playSong='$song' where eventID = '$res';";          
          mysqli_query($con,$query);
          $query1 = "select * from events where name = '$eventName'";
          $res = mysqli_query($con,$query1)->fetch_assoc();
          $res1 = $res['eventID'];
          $query2 = "insert into specialRequests (veganOptions,specialCake,largeTable,tablesOutside,kidsMeals,exLargePizzas,playSong,eventID) values ('$veganOptions', '$specialCake', '$tableSize', '$tablesOutside', '$kidsMeals', '$largePizzas', '$playSong', '$res1')";
          mysqli_query($con,$query2);
          echo "<h3>New event added.</h3>";
          $value = "None";
          header("Refresh:0");
        }
      }
      else if ($value == 'delete') {
        $query1 = "delete from events where eventID='$eventID';";
        $query2 = "delete from specialRequests where eventID='$eventID';";//Deleting special requests item 
        mysqli_query($con,$query2);
        mysqli_query($con,$query1);

        echo "<h3>Event deleted.</h3>";
        $value = "None";
        header("Refresh:0");
      }
    }

    echo "<br><br><br>";
    echo "<div class='outer-results-table'>";
    echo "<div class='results-table'>";
   
    echo "<h1> ALL EVENTS </h1> <br>";
  
    if($result)
    {
        if($result && mysqli_num_rows($result) > 0)
        {
          while($row = $result->fetch_assoc()) {//Editing an event 
             echo "<div> <h4> <b style='font-size: 25px;'> " 
             . $row["name"] . "</b> <br> <br>" .
             "  <em> Number of atendees: </em>" . $row["numAtendees"] . "<br><br>" . "Date of event: "
             . $row["date"] .  "<br><br>" . "Description of event: " . $row["description"] . "<br><br>" . "Current status of event application: " 
             . $row["status"] . "</h4>" . "<br> </div>";
          
              echo "<form action='eventItem.php' method='POST'>";
              echo "<input type='hidden' name='eventID' id='eventID' value='" . $row['eventID'] . "'/>
              <input type='hidden' name='name' id='name' value='" . $row['name'] . "'/>
              <input type='hidden' name='organiserID' id='organiserID' value='" . $row['organiserID'] . "'/>
              <input type='hidden' name='numAtendees' id='numAtendees' value='" . $row['numAtendees'] . "'/>
              <input type='hidden' name='date' id='date' value='" . $row['date'] . "'/>
              <input type='hidden' name='description' id='description' value='" . $row['description'] . "'/>
              <input type='hidden' name='status' id='status' value='" . $row['status'] . "'/>";

              if (!isset($_SESSION["employeeID"])) {
                echo "<input class='c-btn' type='submit' name='eventBtn' value='Edit Event'/>";
              }
              else if ($row['status'] == "submitted") {
                echo "<input type='hidden' name='employeeID' id='employeeID' value='" . $_POST['employeeID'] . "'/>";
                echo "<input class='c-btn' type='submit' name='eventBtn' value='Check event details'/>";
              }
              
              echo "</form>";   
          }
        } 
        else {
          echo "<h4 class='subHeading'> No events listed. </h4>";
        }
        if (!isset($_SESSION["user"] ) || $_SESSION["user"] == "customer") { 
          $abc = 444;
          echo "<br><br><form action='eventItem.php' method='POST'> 
          <input type='hidden' name='organiserID' id='organiserID' value='" . $abc . "'/>
          <input class='c-btn' type='submit' name='eventBtn' value='Create Event'/>
          </form>";
        }
        
      }
      echo "</div>";
      echo "</div>";
  
  ?>
  <br><br><br><br><br>
  
    <form style='position:absolute; margin-top:-10%;'>
      <input class='c-btn'  type='hidden' name='changeUserButton' id='changeUserButton' value='Change user type'/>
      <input class='c-btn'  type='submit' name='aaa' id='aaa' value='Change user type'/>
    </form>
    




</body>