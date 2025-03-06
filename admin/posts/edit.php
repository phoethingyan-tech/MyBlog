<?php
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();


    //Index page get id to edit page
    $id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $post = $stmt->fetch();
    // var_dump($post);

    // This code for data Update
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
        } else {
            $image = $_POST['old_image']; //old_img data carry
        }

        //code for update data

        $sql = "UPDATE posts SET title=:title, category_id=:category_id, user_id=:user_id, description=:description, image=:image WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="true">Image</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="new_image-tab" data-bs-toggle="tab" data-bs-target="#new_image-tab-pane" type="button" role="tab" aria-controls="new_image-tab-pane" aria-selected="false">New Image</button>
                            </li>
                        </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                    <img src="../<?= $post['image']?>" alt="images" width="150" height="150" class="my-3">
                                    <input type="hidden" name="old_image" id="" value="<?= $post['image']?>">
                                </div>
                                <div class="tab-pane fade" id="new_image-tab-pane" role="tabpanel" aria-labelledby="new_image-tab" tabindex="0">
                                    <input type="file" accept="image/*" name="image" id="image" class="form-control my-3">
                                </div>                                
                            </div>

                        
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" <?= $post['description']?>></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-warning" type="submit">Update</button>
                    </div>
                </form>                
            </div>
        </div>
    </div>

<?php
    include "../layouts/footer.php";
?>