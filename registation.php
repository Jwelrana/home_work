<?php
    $vkey = $error = "";
    $n = $e = $p1 = $p2 = "";
    $n_e = $e_e = $p1_e = $p2_e = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (empty($_POST['n'])){
            $n_e = "Please Enter user Name";
        }else{
            $n = $_POST['n'];
        }
        if (empty($_POST['e'])){
            $e_e = "Please enter mail address";
        }else{
            $e = $_POST['e'];
        }
        if (empty($_POST['p1'])){
            $p1_e = "Please Enter your Password";
        }else if (strlen($_POST['p1']) < 6){
            $p1_e = "Password must be at least 6 character";
        }else{
            $p1 = $_POST['p1'];
        }
        if (empty($_POST['p2'])){
            $p2_e = "Please Enter Conform Password";
        }else if ($p1 != $_POST['p2']){
            $p2_e = "Password not matched";
        }else{
            $p2 = $_POST['p2'];
        }
        if (empty($n_e) && empty($e_e) && empty($p1_e) && empty($p2_e)){
            $vkey = md5(time().$n);
            $p1 = md5($p1);
            $conn = mysqli_connect("localhost", "root", "", "varify");
            $sql  = mysqli_query($conn,"SELECT * FROM users WHERE email = '$e'");
            if (mysqli_num_rows($sql) > 0){
                $error = "Already have an account";
            }else{
                $sql = "INSERT INTO users (name, email, password, vkey) VALUE ('$n', '$e', '$p1', '$vkey')";
                if (mysqli_query($conn, $sql) == true){
                    $to = $e;
                    $subject = "Email Verification";
                    $message = "<a href='http://localhost/Registation&login/verify.php?vkey=$vkey'>Registration Account</a>";
                    $headers = "From: jwelranajf@gmail.com \r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                    mail($to, $subject, $message, $headers);

                    //header('location: welcome.php');
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        span{
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <form action="registation.php" method="post">
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" class="form-control" id="name" name="n">
                    <span><?php echo $n_e?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email" name="e">
                    <span><?php echo $e_e?></span>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" name="p1">
                    <span><?php echo $p1_e?></span>
                </div>
                <div class="form-group">
                    <label for="pwd">Conform Password:</label>
                    <input type="password" class="form-control" id="pwd" name="p2">
                    <span><?php echo $p2_e?></span>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button><span><?php echo $error ;?></span>
            </form>
        </div>
    </div>
</div>
</body>
</html>