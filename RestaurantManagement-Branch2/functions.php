    <?php
    class num {
        public static $a = 0;
        function getID()
        {
            self::$a++;
            return self::$a;

        }
    }
        function get_user_data($con)
        {
            if(isset($_SESSION['user_id']))
            {
                $id = $_SESSION['user_id'];
                $quary = "select * from users where id = '$id' limit 1";

                $result = mysqli_query($con,$quary);
                if($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);
                    return $user_data;
                }
            }
        }

        function changeUserType($con) {
            if (!isset($_SESSION["user"]) || $_SESSION["user"] == "customer") {
                $_SESSION["user"] = "employee";
            }
            else if ($_SESSION["user"] == "employee") {
                $_SESSION["user"] = "customer";
            }
        }

        
    ?>

    