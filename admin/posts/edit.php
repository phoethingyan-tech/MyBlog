<?php
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();


    //index edit button data to update
    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $post = $stmt->fetch();
    // var_dump($post);

    // This code for data input
    if($_SERVER['REQUEST_METHOD'] == 'POST') {        
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];
        $user_id = 1;
        $description = $_POST['description'];

        // code for image upload database
        $img_array = $_FILES['image'];
        // var_dump($_FILES['image']);
        // die();  //stop code line

        if(isset($img_array) && $img_array['size'] > 0) {
            $img_path = "../images/".$img_array['name']; // ../image/eg.png // ပုံတကယ်သိမ်းမည့်လမ်းကြောင်း
            $tmp_name = $img_array['tmp_name'];
            move_uploaded_file($tmp_name, $img_path);
            $image = 'images/'.$img_array['name']; // images/eg.png //database လဲထည့်မည်
        }

        // echo "$title, $category_id, $description";
        $sql = "INSERT INTO posts (title,category_id,user_id, description, image) VALUES(:title,:category_id,:user_id,:description,:image)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title',$title);
        $stmt->bindParam(':category_id',$category_id);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->bindParam(':description',$description);
        $stmt->bindParam(':image',$image);
        $stmt->execute();

        header("location: index.php");
    }

?>
    <div class="container my-5">
        <div class="mb-5">
            <h3 class="d-inline">Post Edit</h3>
            <a href="index.php" class="btn btn-danger float-end">Cancel</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?= $post['title'] ?>">
                    </div>

                    <div class="mb-4">
                        <label for="category" class="form-label">Category</label>
                        <select name="category_id" id="category" class="form-select">
                            <option value="">Choose Category</option>
                            <?php
                                foreach($categories as $category) {
                            ?>  
                                <option value="<?=$category['id']?>" <?php if($category['id']==$post['category_id']){echo'selected';} ?> ><?=$category['name']?></option>

                            <?php 
                             }
                            ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" accept="image/*" name="image" id="image" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" <?= $post['description']?>></textarea>
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
?>