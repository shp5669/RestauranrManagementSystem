
<?php

function testCheckMenuNotEmpty()
{
    include("connection.php");

    $query = "select * from menuitems";
    $result = mysqli_query($con,$query);
    
    try {
      assert($result);
      assert(($result && mysqli_num_rows($result)> 0));
               
      while($row = $result->fetch_assoc()) {
        assert($row["name"] != "");
        assert($row["category"] != "");
        assert($row["price"] != "");
        assert($row["pickupOnly"] != "");
        assert($row["imageLink"] != "");
      }    
    }
    catch (Exception $e) {
      echo $e;
    }
    
    
}

testCheckMenuNotEmpty();

?>
