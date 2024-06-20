
<?php

function testCheckMenuNotEmpty()
{
    include("connection.php");

    $query = "select * from menuitems";
    $result = mysqli_query($con,$query);
    
    if($result)
    {
        if($result && mysqli_num_rows($result)> 0)
        {
          while($row = $result->fetch_assoc()) {
            $row["name"]->assertNotEmpty($row["name"]);
            $row["category"]->assertNotEmpty($row["category"]);
            $row["price"]->assertNotEmpty($row["price"]);
            $row["pickupOnly"]->assertNotEmpty($row["pickupOnly"]);
            $row["imageLink"]->assertNotEmpty($row["imageLink"]);
          }
        }
        else {

        }
    }
}

testCheckMenuNotEmpty();

?>
