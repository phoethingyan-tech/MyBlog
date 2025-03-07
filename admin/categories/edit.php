<?php

//code for login status check
session_start();
if($_SESSION['user_id']) {

    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";

    //Index page get id to edit page
    $id = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $category = $stmt->fetch();
    // var_dump($post);
    
    // This code for data update
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        //  echo "$name";
        $sql = "UPDATE categories SET name=:name WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);
        $stmt->execute();
        
        header("location: index.php");
    }

?>
    <div class="container my-5">
        <div class="mb-5">
            <h3 class="d-inline">Edit Category</h3>
            <a href="index.php" class="btn btn-danger float-end">Cancel</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                    <div class="mb-4">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" value ="<?= $category['name']?>">
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
    header("location: ../login.php"); //code for login status check
}
?>