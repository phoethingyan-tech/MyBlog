<?php
    session_start();
    include "../dbconnect.php";
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // echo "$email and $password";

        $sql = "SELECT * FROM users WHERE email=:email AND password=:password";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->execute();
        $user = $stmt->fetch();
        // var_dump($user);

        if($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_profile'] = $user['profile'];

            if($_SESSION['user_id']) {
                header('location: posts/index.php');
            }

        }else {
            echo '<p class="text-danger text-center mt-5">Incorrect email and password</p>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container my-5">
        <div class="row py-5">
            <div class="offset-md-4 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center py-3">Login</h3>
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                            <a href="../index.php" class="my-3 d-block">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>