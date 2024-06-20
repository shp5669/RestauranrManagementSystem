<header class="c-header">
  <h1>View Product</h1> 
</header>

<?php
  include("connection.php");
  session_cache_limiter('private_no_expire');

  session_start();

  $sID = $_POST['searchID'];
  $query = "select * from menuitems where id = '$sID'";
  $result = mysqli_query($con,$query);
  $content = $result->fetch_assoc();

    echo "<div style='text-align:center; margin-top:-8%; margin-bottom: 310;'>";
    echo "<h2>" . $content['Name'] . "</h2>";
    echo "<h3>" . $content['Category'] . "</h3>";
    echo "<h3>" . $content['Price'] . "</h3>";

    echo '<p><form method="POST" action="order.php"><input type="hidden" name="product_id" value=' . $pID . '><input type="number" name="quantity" value="1" min="1"><button type="submit">Add to Cart</button></form></p>';
  

    echo "</div>";
    echo "<img src=" . ($content["imageLink"]) ." width=300 height=300 style='margin-top:-10%; 
    margin-left:auto; margin-right:auto; display: block; margin-bottom: 100;'> <br>";
    $_SESSION['doQuery'] = false;
?>

 <br>
 </div>
</div>
