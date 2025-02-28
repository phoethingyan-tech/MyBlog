<?php
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT posts.*, categories.name as c_name, users.name as u_name FROM posts INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll();


?>
    <div class="container my-5">
        <div class="mb-3">
            <h3 class="d-inline">Posts Lists</h3>
            <a href="" class="btn btn-primary float-end">Create Post</a>
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
                                <a href="" class="btn btn-sm btn-warning">Edit</a>
                                <button class="btn btn-sm btn-danger">Delete</button>
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

<?php
    include "../layouts/footer.php";
?>