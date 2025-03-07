<?php
//code for login status check
session_start();
if($_SESSION['user_id']) {

    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT posts.*, categories.name as c_name, users.name as u_name FROM posts INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll();

    // Delete post
    if($_SERVER['REQUEST_METHOD'] =='POST') {
        $id = $_POST['post_id'];
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        header('location: index.php');
    }


?>
    <div class="container my-5">
        <div class="mb-5">
            <h3 class="d-inline">Posts Lists</h3>
            <a href="create.php" class="btn btn-primary float-end">Create Post</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach($posts as $post) {
                        ?>
                            <tr>
                            <td><?= $i++?></td>
                            <td><?= $post['title']?></td>
                            <td><?= $post['c_name']?></td>
                            <td><?= $post['u_name']?></td>
                            <td>
                                <a href="edit.php?id=<?= $post['id']?>" class="btn btn-sm btn-warning">Edit</a>
                                <!-- footer ထဲမှာ code ထားဖို့အတွက် delete class and data-id ကို သယ်သွားမယ် -->
                                <button class="btn btn-sm btn-danger delete" data-id="<?= $post['id']?>">Delete</button>
                            </td>    
                        </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Action</th>    
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
   
<!--Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-light">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3>Are you sure delete?</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <input type="hidden" name="post_id" id="id">
            <button type="submit" class="btn btn-primary btn-danger">Yes</button>
        </form>
       
      </div>
    </div>
  </div>
</div>

<?php
    include "../layouts/footer.php";
} else {
    header("location: ../login.php"); //code for login status check
}
?>