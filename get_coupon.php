 <?php

  session_start();
if (!isset($_SESSION['user_number']))
{
    header('location: login.php');
}

  include 'connection.php';

  $sess_num = $_SESSION['user_number'];
  $amount = $_POST['amountt'];

  $sql= "SELECT * FROM user WHERE user_number='$sess_num'";
  $result=mysqli_query($conn,$sql) or die("Query failed");
  $row= mysqli_fetch_array($result);

  $get_amount = $row['user_amount'];
  
  if($get_amount >= $amount){
     $final_amount = $get_amount - $amount;
     echo "Coupon Buy Success";

     

    // Function to generate a random alphanumeric string
    function generateCouponCode($length = 10) {
    // Define the characters you want to include in the random code
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
    $charactersLength = strlen($characters);
    $CouponCode = '';

    // Generate the random code using a loop
    for ($i = 0; $i < $length; $i++) {
        $CouponCode .= $characters[rand(0, $charactersLength - 1)];
    }

    return $CouponCode;  // Return the generated code
}

// Store the random code in a variable
     $CouponCode = generateCouponCode(12);  // Generates a 12-character random code

     $sql1= "INSERT INTO `all_coupon` (`id`, `user_number`, `code`, `amount`) VALUES (NULL, '$sess_num', '$CouponCode', '$amount')";
     $result1=mysqli_query($conn,$sql1) or die("Query failed");
     $sql = "UPDATE user SET user_amount='$final_amount' WHERE user_number='$sess_num'";
     $result=mysqli_query($conn,$sql) or die("Query failed");

     header('location: home.php');

}else{
      echo "Your balance low";
  }
?>