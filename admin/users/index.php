<?php
 //code for login status check
 session_start();
 if($_SESSION['user_id'] && $_SESSION['user_role'] =='admin') {
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT users.*, roles.name as u_role FROM users INNER JOIN roles ON users.role_id = roles.id ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();

    // Delete user
    if($_SERVER['REQUEST_METHOD'] =='POST') {
        $id = $_POST['user_id'];
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();

        header('location: index.php');
    }

?>
    <div class="container my-5">
        <div class="mb-3">
            <h3 class="d-inline">Users List</h3>
            <a href="create.php" class="btn btn-primary float-end">New user</a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 1;
                            foreach($users as $user) {
                        ?>
                            <tr>
                            <td><?= $i++?></td>
                            <td><?= $user['name']?></td>                            
                            <td><?= $user['email']?></td>
                            <td><?= str_repeat("*",6)?></td>
                            <td><?= $user['u_role']?></td>
                            <td>
                                <a href="edit.php?id=<?= $user['id']?>" class="btn btn-sm btn-warning">Edit</a>
                                <!-- footer ထဲမှာ code ထားဖို့အတွက် delete class and data-id ကို သယ်သွားမယ် -->
                                <button class="btn btn-sm btn-danger delete" data-id="<?= $user['id']?>">Delete</button>
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
                <input type="hidden" name="user_id" id="id">
                <button type="submit" class="btn btn-primary btn-danger">Yes</button>
            </form>
        
        </div>
        </div>
    </div>
    </div>

<?php
    include "../layouts/footer.php";
} else {
    header("location: ../posts/index.php"); //code for login status check
}
?>