<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT * FROM roles";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $roles = $stmt->fetchAll();

    //index edit button data to update
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $user = $stmt->fetch();
    // var_dump($user);

    // This code for data input
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
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
        }else {
            $profile = $_POST['old_profile'];   //old_profile data carry
        }

        // code for profile image edit or update
        $sql = "UPDATE users SET name=:name, profile=:profile, email=:email, password=:password, role_id=:role_id WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
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
            <h3 class="d-inline">Edit Account</h3>
            <a href="index.php" class="btn btn-danger float-end">Cancel</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $user['name']?>">
                    </div>


                    <!-- code for profile image edit -->
                    <div class="mb-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="new_profile-tab" data-bs-toggle="tab" data-bs-target="#new_profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">New Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                <img src="../<?=$user['profile']?>" alt="images" width="150" height="150" class="my-3">
                                <input type="hidden" name="old_profile" id="" value="<?= $user['profile']?>">
                            </div>
                            <div class="tab-pane fade" id="new_profile-tab-pane" role="tabpanel" aria-labelledby="new_profile-tab" tabindex="0">
                                <input type="file" accept="image/*" name="profile" id="profile" class="form-control my-3">
                            </div>
                        </div>                         
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $user['email']?>">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="<?= $user['password']?>">
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label">Role</label>
                        <select name="role_id" id="role" class="form-select">
                            <option value="">Choose Role</option>
                            <?php
                                foreach($roles as $role) {
                            ?>  
                                <option value="<?=$role['id']?>"<?php if($role['id']==$user['role_id']) {echo 'selected';} ?> ><?=$role['name']?></option>

                            <?php 
                             }
                            ?>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>

<?php
    include "../layouts/footer.php";
?>