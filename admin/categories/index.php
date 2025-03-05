<?php
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();

    // Delete category
    if($_SERVER['REQUEST_METHOD'] =='POST') {
        $id = $_POST['category_id'];
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        header('location: index.php');
    }

?>
    <div class="container my-5">
        <div class="mb-3">
            <h3 class="d-inline">Category List</h3>
            <a href="create.php" class="btn btn-primary float-end">New Category</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach($categories as $category) {
                        ?>
                            <tr>
                            <td><?= $i++?></td>
                            <td><?= $category['name']?></td>
                            <td>
                                <a href="edit.php?id=<?= $category['id']?>" class="btn btn-sm btn-warning">Edit</a>
                                <!-- footer ထဲမှာ code ထားဖို့အတွက် delete class and data-id ကို သယ်သွားမယ် -->
                                <button class="btn btn-sm btn-danger delete" data-id="<?= $category['id']?>">Delete</button>
                            </td>    
                        </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>  
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
                <input type="hidden" name="category_id" id="id">
                <button type="submit" class="btn btn-primary btn-danger">Yes</button>
            </form>
        
        </div>
        </div>
    </div>
    </div>

<?php
    include "../layouts/footer.php";
?>