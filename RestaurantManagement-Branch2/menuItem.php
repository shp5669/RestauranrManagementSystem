<header class="c-header">
  <h1>Editing Menu</h1>
  <p></p>
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
  include("connection.php");
  include("functions.php");
  
  session_cache_limiter('private_no_expire');

  session_start();
  
  if (!isset($_POST['id'])) {
    $name = "";
    $category = "";
    $price = 0;
    $pickupOnly = "false";
    $link = "";
    $pID = 24;

    $value = "create";

    $submitValue = "Save Changes";
    $formHeader = "Create New Dish: ";

    echo "<script>
    document.getElementById('myform').addEventListener('submit', function (event) {
        event.preventDefault();
        var name = document.getElementById('name').value;
        var category = document.getElementById('category').value;
        const apiUrl = 'http://localhost:3000/api/menuItems/create';
        const requestData = {
            name: name,
            category: category,
        };
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(requestData)
        })
            .then(response => {
            })
        .catch(error => {
            console.error('Error sending data:', error);
        });
    });
    </script>";

  }
  else {
    $pID = $_POST['id'];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {    
        $name = $_POST['name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $pickupOnly = $_POST['pickupOnly'];
        $link = $_POST["imageLink"]; 

        $value = "edit";

        $submitValue = "Save Changes";
        $formHeader = "Edit Menu: ";
    }
  }

  
?>

<link rel="stylesheet" href="menuManagement.css">

<div class="main-content" style="text-align:center; padding:20px;">
      <div id="box">
        <form id="myform" method="POST" action='searchMenu.php'>
        <a href="searchMenu.php" style="color:gray; top:180px; left: 18px; position:absolute;">Back<br><br></a>
      </div>
      <div class="btn-block">
        <div class=""><h3><?php echo "$formHeader" . $name;?></h3><br><br></div>
        <label id="icon" for="name"><i class="input"> Name:  </i></label><br><br>
        <input type="text" name="name" id="name" value="<?php echo $name;?>" required/>
        <br>
        <br>
        <br>
        <label for="name">Choose a category:</label> <br><br>
          <select name="category" id="category"> 
              <option value="Entrees">Entrees</option> 
              <option value="Pizzas">Pizzas</option> 
              <option value="Pastas">Pastas</option> 
              <option value="Salads">Salads</option> 
              <option value="Desserts">Desserts</option> 
          </select>
          <br>
          <br>
          <br>
        <label id="icon" for="name"><i class="input">Price:  </i></label><br><br>
        <input type="number" name="price" id="price" value="<?php echo $price;?>" required/>
        <br>
        <br>
        <br>
        <label id="icon" for="name"><i class="input">Pickup Only? </i></label><br><br>
        <input type="checkbox" name="pickupOnly" id="pickupOnly"/>
        <br>
        <br>
        <br>
        <label id="icon" for="name"><i class="input">Link to product image:  </i></label><br><br>
        <input type="text" name="imageLink" id="imageLink" value="<?php echo $link;?>" required/>
        <br>
        <br>
        <br>
        <input type='hidden' name='id' id='id' value="<?php echo $pID;?>"/>

        <input type='hidden' name='task' id='task' value="<?php echo $value;?>"/>
        <br><br><br>
      </div>
        <div>
          <input class="c-btn"id="button" type="submit" value="<?php echo "$submitValue"; ?>"><br><br>
        </div>
      </form>
    </div>
    <?php
    if (isset($_POST['id'])) {
      echo "
        <div class='main-block' style='text-align:center; padding:20px;'>
        <div id='box'>
          <form method='post' action='searchMenu.php'>
          <input type='hidden' name='id' id='id' value=" . "$pID" . "/>
          <input type='hidden' name='task' id='task' value= 'delete'/>
          <input class='c-btn'id='button' type='submit' value='delete'>
          <br><br>
          </div>
        </form>
      </div>
      ";
    }
    ?>
    <br><br><br><br><br>
  </body>
