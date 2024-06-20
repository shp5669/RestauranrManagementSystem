<header>
  <h1>Online Menu</h1>
  <?php
    //session_cache_limiter('private_no_expire');
    session_start();
    
    include("connection.php");
    //include("functions.php");
  ?>
  <link rel="stylesheet" href="menuManagement.css">
  <a href="searchMenu.php">Back</a>
</header>

<body>
    <?php
        $_SESSION['doQuery'] = false;
        $query1 = "select * from menuitems where category = 'Entrees'";
        $query2 = "select * from menuitems where category = 'Pizzas'";
        $query3 = "select * from menuitems where category = 'Pastas'";
        $query4 = "select * from menuitems where category = 'Salads'";
        $query5 = "select * from menuitems where category = 'Desserts'";

        $result1 = mysqli_query($con,$query1);
        $result2 = mysqli_query($con,$query2);
        $result3 = mysqli_query($con,$query3);
        $result4 = mysqli_query($con,$query4);
        $result5 = mysqli_query($con,$query5);

             
        echo "<div class='whole-menu-table' style='column-count: 3;'>";
        echo "<div class='results-table'>";
    
        echo "<h1> Entrees: </h1> <br>";
        printCategory($result1);

        echo "<h1> Pizzas: </h1> <br>";
        printCategory($result2);

        echo "<h1> Pastas </h1> <br>";
        printCategory($result3);

        echo "<h1> Salads: </h1> <br>";
        printCategory($result4);

        echo "<h1> Desserts: </h1> <br>";
        printCategory($result5);
            
        echo "</div>";
        echo "</div>";


      function printCategory($result) {
        if($result && mysqli_num_rows($result)> 0)
        {
          while($row = $result->fetch_assoc()) {
             echo "<div class='whole-menu-column'>";
             echo "<div> <h4>" . "<img src=" . ($row["imageLink"]) ." width=350 height=350 style='margin:30px; border: 15px solid #b4aaaa;'> <br> <br> " . 
             " <b style='font-size: 25px;'> " . $row["name"] . "</b> <br> <br>" .
             "  <em> Price $ </em>" . $row["price"] . "<br>" 
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
            echo "</div>";
          }
        } 
      }
    ?>


</body>
