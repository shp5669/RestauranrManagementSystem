
<header>
  <h1>Online Menu</h1>

  <?php
    //session_cache_limiter('private_no_expire');
    session_start();
    
    include("connection.php");
  ?>
  <link rel="stylesheet" href="menuManagement.css">
  <a href="homepage.html">Home</a>
</header>

<body>
<section>
<form action="searchMenu.php" method="POST" class="search-container">
    <h2 for="html">Search our menu:</h2>
	  <input class="search-input"  type="text" name="search_data" id="search_data"/>
    <input class="search-button" type="submit" value="Search"/>
    <br><br>
    <h2 style="position:relative; left: 40%">OR</h2>
</form>
</section>

<?php  
  $_SESSION['doQuery'] = false;
  if (isset($_POST['task'])) {
    $value = $_POST['task'];
    $pID = $_POST['id'];

    if ($value == 'edit' || $value == 'create') {
      $iName = $_POST['name'];
      $iCategory = $_POST['category'];
      $iPrice = $_POST['price'];

      if (isset($_POST['pickupOnly'])) {
        $iPickupOnly = true;
      }
      else {
        $iPickupOnly = false;
      }
      $iLink = $_POST["imageLink"]; 

      if ($value == 'edit') {
        $query = "update menuitems set name='$iName', category='$iCategory', price='$iPrice', pickupOnly='$iPickupOnly', imageLink='$iLink' where id = $pID;";
        mysqli_query($con,$query);

        echo "<h3>Product edited.</h3>";
      }
      else if ($value == 'create') {

        $query = "insert into menuitems (name,category,price,pickupOnly,imageLink) values ('$iName','$iCategory','$iPrice', '$iPickupOnly','$iLink')";
        mysqli_query($con,$query);

        echo "<h3>New product added.</h3>";

      }
    }
    else if ($value == 'delete') {
      $query = "delete from menuitems where id='$pID';";
      mysqli_query($con,$query);
      echo "<h3>Product deleted.</h3>";

    }

    echo "<div class='outer-results-table'>";
    echo "<div class='results-table'>";
    echo "<br><br><br><br><br>";
    echo "<h3> Delicious Italian Pizzas, Pastas, Salads and Desserts with special dietary options. </h3>";
    echo "<br><br><form action='menuItem.php' method='POST'> 
      <input class='c-btn' type='submit' name='productBtn' value='Create Menu Item'/></form>";
    echo "<br>";
    echo "</div>";
    echo "</div>";
  }
  else if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_GET['link']))
  {
    if (isset($_POST['search_data']) && $_POST['search_data'] != null) {
      $search_data = $_POST['search_data'];

      $query = "select * from menuitems where name = '$search_data'";
      $result = mysqli_query($con,$query);
    }
    else if (isset($_GET['link']) && $_GET['link'] != null) {
      $l = $_GET['link'];
      if ($l == '1'){
        $query = "select * from menuitems where category = 'Entrees'";
        $search_data = "Entrees";
      }else if ($l == '2'){
        $query = "select * from menuitems where category = 'Pizzas'";
        $search_data = "Pizzas";
      }else if ($l == '3') {
        $query = "select * from menuitems where category = 'Pastas'";
        $search_data = "Pastas";
      }else if ($l == '4') {
        $query = "select * from menuitems where category = 'Salads'";
        $search_data = "Salads";
      }else if ($l == '5') {
        $query = "select * from menuitems where category = 'Desserts'";
        $search_data = "Desserts";
      }else {
        $query = "select * from menuitems where category = 'hhh'";
        $search_data = "hhh";
      }
      $result = mysqli_query($con,$query);
    }
    else if (!isset($_POST['search_data']) || $_POST['search_data'] == null) {
      $search_data = "";
      $query = "select * from menuitems where name = ''";
      $result = mysqli_query($con,$query);
      
    }
    
    echo "<div class='outer-results-table'>";
    echo "<div class='results-table'>";
   
    echo "<h1> RESULTS </h1> <br>";

    echo "<h2>You searched for: " . $search_data . "</h2>";
  
    if($result)
    {
        if($result && mysqli_num_rows($result)> 0)
        {
          while($row = $result->fetch_assoc()) {
            if ($row["pickupOnly"] == true) {
              $pOnly = "yes";
            }
            else {
              $pOnly = "no"; 
            }
            echo "<div> <h4>" . "<img src=" . ($row["imageLink"]) ." width=98% height=40% > <br> <br> " . 
             " <b style='font-size: 25px;'> " . $row["name"] . "</b> <br> <br>" .
             "  <em> Price $ </em>" . $row["price"] . "<br><br>" . "<b>Pickup only: </b>" . $pOnly . "<br>" 
             .  "</h4>" . "<br> </div>";
            if (false) {//If user is not an employee, show produt profile page
              echo "<form action='menu.php' method='POST'> 
              <input class='c-btn' type='submit' name='productBtn' value='Order'/>";
              echo "<input type='hidden' name='searchID' value='" . $row['id'] . "'/>";          
              echo "</form>";
            }
            else {//If user is an employee, show create product page + link to page to edit product
              echo "<form action='menuItem.php' method='POST'> " ;
              echo "<input type='hidden' name='id' id='id' value='" . $row['id'] . "'/>
              <input type='hidden' name='name' id='name' value='" . $row['name'] . "'/>
              <input type='hidden' name='category' id='category' value='" . $row['category'] . "'/>
              <input type='hidden' name='price' id='price' value='" . $row['price'] . "'/>
              <input type='hidden' name='pickupOnly' id='pickupOnly' value='" . $row['pickupOnly'] . "'/>
              <input type='hidden' name='imageLink' id='imageLink' value='" . $row['imageLink'] . "'/>
              <input class='c-btn' type='submit' name='productBtn' value='Edit Menu Item'/>";
              echo "</form>";
              $_SESSION['name'] = $row['name'];
              $_SESSION['category'] = $row['category'];
              $_SESSION['price'] = $row['price'];
              $_SESSION['imageLink'] = $row['imageLink'];
            }
          }
        } 
        else {
          echo "<h4 class='subHeading'> No results found. </h4>";
        }
        echo "<br><br><form action='menuItem.php' method='POST'> 
        <input class='c-btn' type='submit' name='productBtn' value='Create Menu Item'/></form>";
      }
      echo "</div>";
      echo "</div>";
    }
    else {
      echo "<div class='outer-results-table'>";
      echo "<div class='results-table'>";
      echo "<br><br><br><br><br>";
      echo "<h3> Delicious Italian Pizzas, Pastas, Salads and Desserts with special dietary options. </h3>";
      echo "<br><br><form action='menuItem.php' method='POST'> 
        <input class='c-btn' type='submit' name='productBtn' value='Create Menu Item'/></form>";
      echo "<br>";
      echo "</div>";
      echo "</div>";
    }
  ?>

    <div class="menu-categories"> 
      <h2>Select By Category:</h2>
      <div class="menu-categories-inner">
        <ul class="menu-categories-list">
          <li><a href="searchMenu.php?link=1">Entrees</a></li>
          <li><a href="searchMenu.php?link=2">Pizzas</a></li>
          <li><a href="searchMenu.php?link=3">Pastas</a></li>
          <li><a href="searchMenu.php?link=4">Salads</a></li>
          <li><a href="searchMenu.php?link=5">Desserts</a></li>
        </ul>
        <?php echo "<br><br><a href=wholeMenu.php class='c-btn' style='margin-left:20px; margin-bottom:10px;'>View Whole Menu</a>"; ?>
      </div>
    </div>
</body>






<script>//page only updates after a reload so fore a reload once upon navigating to page
  /* 
  window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted || 
                        (typeof window.performance == "undefined" ||
                              window.performance.navigation.type == 2);
  if ( historyTraversal) {
    // Handle page restore.
     window.location.reload();
  }
  });
  if ( document.referrer != 'http://localhost/dashboard/advancedsoftwaredevelopment/searchMenu.php'
    && document.referrer != 'http://localhost/dashboard/advancedsoftwaredevelopment/searchMenu.php?link=1'
    && document.referrer != 'http://localhost/dashboard/advancedsoftwaredevelopment/searchMenu.php?link=2'
    && document.referrer != 'http://localhost/dashboard/advancedsoftwaredevelopment/searchMenu.php?link=3'
    && document.referrer != 'http://localhost/dashboard/advancedsoftwaredevelopment/searchMenu.php?link=4'
    && document.referrer != 'http://localhost/dashboard/advancedsoftwaredevelopment/searchMenu.php?link=5'
    ) {
     window.location.reload();
  }
  */
</script>
