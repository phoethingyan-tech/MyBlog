<?php
//code for login status check
session_start();
if($_SESSION['user_id'] && $_SESSION['user_role'] =='admin') {
    
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT * FROM roles";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $roles = $stmt->fetchAll();

    // This code for data input
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = sha1($_POST['password']); //password encrypt with sha1
        $role_id = $_POST['role_id'];

        // code for image upload database
        $img_array = $_FILES['profile'];
        // var_dump($_FILES['profile']);
        // die();  //stop code line

        if(isset($img_array) && $img_array['size'] > 0) {
            $img_path = "../profiles/".$img_array['name']; // ../profile/eg.png // ပုံတကယ်သိမ်းမည့်လမ်းကြောင်း
            $tmp_name = $img_array['tmp_name'];
            move_uploaded_file($tmp_name, $img_path);
            $profile = 'profiles/'.$img_array['name']; // profile/eg.png //database လဲထည့်မည်
        }

        //  echo "$name, $email, $password";
        $sql = "INSERT INTO users (name,profile,email, password, role_id) VALUES(:name, :profile, :email, :password, :role_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':profile',$profile);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$password);
        $stmt->bindParam(':role_id',$role_id);
        $stmt->execute();

        header("location: index.php");
    }

?>
    <div class="container my-5">
        <div class="mb-5">
            <h3 class="d-inline">Create Account</h3>
            <a href="index.php" class="btn btn-danger float-end">Cancel</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="profile" class="form-label">Profile</label>
                        <input type="file" accept="image/*" name="profile" id="profile" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label">Role</label>
                        <select name="role_id" id="role" class="form-select">
                            <option value="">Choose Role</option>
                            <?php
                                foreach($roles as $role) {
                            ?>  
                                <option value="<?=$role['id']?>"><?=$role['name']?></option>

                            <?php 
                             }
                            ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>

<?php
    include "../layouts/footer.php";
} else {
    header("location: ../posts/index.php"); //code for login status check
}
?>