<?php

include "./validate.php";

//sign up form
$username_error = false;
$password_error = false;
$name_error = false;
$street_error = false;
$ssn_error = false;
$success = false;

//was it submitted
if(isset($_POST['username']) && isset($_POST['password'])){

    $un = trim($_POST['username']);
    $pw = password_hash($_POST['password'], PASSWORD_ARGON2ID); //hash the password as soon as possible
    $rn = trim($_POST['real_name']);
    $st = $_POST['address'];
    $ssn = $_POST['ssn'];

    //validate
    if(!is_username($un)){
        $username_error = true;
    }
    if(!is_realname($rn)){
        $name_error = true;
    }
    if(!is_streetname($st)){
        $street_error = true;
    }
    if(!is_ssn($ssn)){
        $ssn_error = true;
    }

    if(!$username_error && !$password_error && !$name_error && !$street_error && !$ssn_error){
        $success = true;
    }

    if(!$username_error && !$name_error && !$street_error && !$ssn_error && $success){
        //store in db
        include_once("sql.php"); //path matters

        $sql = new Database();

        if($sql->user_exists($un)){
            echo "user exists";
        }else if($sql->create_user($un, $pw, $rn, $st, $ssn)){
            //success
            $success = true;

            //Handle SSN
            
        }else{
            echo "failed to create user";
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h1>Sign Up/Create Account</h1>

    <form action="signup.php" method="POST">
        username: <br>
        <input type="text" name="username" id="username" value="<?php echo $_POST['username']; ?>">
        <?php if($username_error): ?>
            <p style="color: red;">ERROR</p>
        <?php endif; ?>
        <br>
        password: <br>
        <input type="password" name="password">
        <br>
        real name: <br>
        <input type="text" name="real_name" value="<?php echo $_POST['real_name']; ?>">
        <?php if($name_error): ?>
            <p style="color: red;">ERROR</p>
        <?php endif; ?>
        <br>
        address: <br>
        <input type="text" name="address"  value="<?php echo $_POST['address']; ?>">
        <?php if($street_error): ?>
            <p style="color: red;">ERROR</p>
        <?php endif; ?>
        <br>
        ssn: <br>
        <input type="text" name="ssn" placeholder="123-45-6789" value="<?php echo $_POST['ssn']; ?>">
        <?php if($ssn_error): ?>
            <p style="color: red;">ERROR</p>
        <?php endif; ?>
        <br>

        <input type="submit" value="submit">
    </form>

</body>
</html>