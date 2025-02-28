<?php 
    include "Layouts/navbar.php";
    include "dbconnect.php";
    $id = $_GET['id'];
    // echo $id;
    // $sql = "SELECT * FROM posts WHERE id = :post_id";
    $sql = "SELECT posts.*, categories.name as c_name, users.name as u_name FROM posts INNER JOIN categories ON posts.category_id = categories.id INNER JOIN users ON posts.user_id = users.id WHERE posts.id = :post_id";
    $stmt = $conn->prepare($sql);        //sql dataprotect
    $stmt->bindParam(':post_id',$id);    //sql dataprotect
    $stmt->execute();
    $post = $stmt->fetch();
    // var_dump($post);
?>
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1"><?= $post['title']?></h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2"><?= date('F d,Y', strtotime($post['created_at'])) ?> by <?= $post['u_name']?></div>
                            <!-- Post categories-->
                            <a class="badge bg-secondary text-decoration-none link-light" href="#!"><?= $post['c_name']?></a>
                            
                        </header>
                        <!-- Preview image figure-->
                        <figure class="mb-4"><img class="img-fluid rounded" src="<?= $post['image']?>" alt="..." /></figure>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4"><?= $post['description']?></p>                            
                        </section>
                    </article>                    
                </div>                
<?php 
    include "Layouts/footer.php";
?>
