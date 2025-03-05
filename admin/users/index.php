<?php
    include "../layouts/nav_sidebar.php";

    include "../../dbconnect.php";
    $sql = "SELECT users.*, roles.name as u_role FROM users INNER JOIN roles ON users.role_id = roles.id ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll();

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
                            <th>Name</th>  
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