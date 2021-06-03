<?php include 'includes/connection.php';?>
<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?>

<?php
if (isset($_POST['signup'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
  'name'        => 'required|alpha_space|max_len,30|min_len,5',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
));

$gump->filter_rules(array(
  'username' => 'trim|sanitize_string',
  'name'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  ));
$validated_data = $gump->run($_POST);

if($validated_data === false) {
  ?>
  <center>
    <font color="red" >
   <?php echo $gump->get_readable_errors(true); ?>
    </font>
  </center>

  <?php
}
else if ($_POST['password'] !== $_POST['repassword']) 
{
  echo  "<center><font color='red'>Passwords do not match! Try Again... </font></center>";
}
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM users WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $countusername = mysqli_num_rows($run_check); 
      if ($countusername > 0 ) {
    echo  "<center><font color='red'>Username is already taken! try a different one</font></center>";
}
$email = $validated_data['email'];
$checkemail = "SELECT * FROM users WHERE email = '$email'";
      $run_check = mysqli_query($conn , $checkemail) or die(mysqli_error($conn));
      $countemail = mysqli_num_rows($run_check); 
      if ($countemail > 0 ) {
    echo  "<center><font color='red'>Email is already taken! try a different one</font></center>";
}

  else {
      $name = $validated_data['name'];
      $email = $validated_data['email'];
      $pass = $validated_data['password'];
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
      $role = $_POST['role'];
      $course = $_POST['course'];
      $gender = $_POST['gender'];
      $joindate = date("F j, Y");

      $query = "INSERT INTO users(username,name,email,password,role,course,gender,joindate,Time) VALUES ('$username' , '$name' , '$email', '$password' , '$role', '$course', '$gender' , '$joindate' ,now())";

      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));

      if (mysqli_affected_rows($conn) > 0) 
      { 

        echo "<script>alert('SUCCESSFULLY REGISTERED');
        window.location.href='login.php';</script>";
}
else {
  echo "<script>alert('Error Occured');</script>";
}
}
}
}
?>

<html>
<body>
<div class="container">

  <div  class="form">

     <form id="contactform" method="POST"> 

          <center>
          <p style="font-size: 25px"><b>SIGN-UP</b></p>
          </center>

          <p class="contact"><label for="name">Name</label></p> 
          <input type="text" id="name" name="name" placeholder="Enter Name.." required="" tabindex="1"  value="<?php if(isset($_POST['signup'])) { echo $_POST['name']; } ?>"> 
           
          <p class="contact"><label for="email">Email</label></p> 
          <input type="email" id="email" name="email" placeholder="Enter Email.." required=""  value="<?php if(isset($_POST['signup'])) { echo $_POST['email']; } ?>"> 
                
          <p class="contact"><label for="username">Create a Username</label></p> 
          <input type="text" id="username" name="username" placeholder="Enter Username.." required="" tabindex="2"  value="<?php if(isset($_POST['signup'])) { echo $_POST['username']; } ?>"> 
           
          <p class="contact"><label for="password">Create a Password</label></p> 
          <input type="password" id="password" placeholder="Enter password.."  name="password" required=""> 
                
          <p class="contact"><label for="repassword">Confirm your Password</label></p> 
          <input type="password" id="repassword" placeholder="Enter Re-password.."  name="repassword" required=""> 
        
          <p class="contact"><label for="gender">Gender </label></p> 
          <select class="select-style gender" name="gender">
             <option>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <br><br>
            
          <p class="contact"><label for="role">Role</label></p> 
            <select class="select-style gender" name="role">
               <option>Select Role</option>
            <option value="Student">Student</option>
            <option value="Teaching fellow">Teaching Fellow</option>
            <option value="Professor">Professor</option>
            <option value="A_Professor">A.Professor</option>
          </select>
          <br><br>
            
          <p class="contact"><label for="course">Course / Department</label></p>
            <select class="select-style gender" name="course">
            <option>Select Course / Department</option>
            <option value="MSC_CS/IT">MSC [CS/IT]</option>
            <option value="CS">CS</option>
            <option value="IT">IT</option>
            <option value="EEE">EEE</option>
            <option value="ECE">ECE</option>
            <option value="Mechanical">Mechanical</option>
            <option value="Civil">Civil</option>
          </select>
          <br><br><br>

           <center>
          <input type="submit" class="buttom" name="signup" id="submit" tabindex="5" value="Sign Up!!" > </center>    

   </form> 

   <br><br><br><br>

</div>      
</div>
<br><br>
</body>
</html>