<?php 
    include "Layouts/navbar.php";
    include "dbconnect.php";


    // sorting လုပ်ဖို့အတွက် CID မှာ Data ပါခဲ့ရင်နဲ့ မပါခဲ့ရင်ကို ခွဲပြီး ထုတ်ပေးတာပါ

    if(isset($_GET['c_id'])) {
        $c_id = $_GET['c_id'];
        $sql = "SELECT * FROM posts WHERE category_id = :c_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':c_id',$c_id);
        $stmt->execute();
        $posts = $stmt->fetchAll();
    } else {    
        // $sql = "SELECT * FROM posts ORDER BY id DESC";
        $sql = "SELECT * FROM posts WHERE id < (SELECT MAX(id) FROM posts) ORDER BY id DESC";
        // $stmt = $conn->query($sql);
        $stmt = $conn->prepare($sql);  //Query Check
        $stmt->execute();  
        $posts = $stmt->fetchAll();   //DATA Output
        // var_dump($posts);  //Print


        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $feature_post = $stmt->fetch();
    }

?>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                    <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <?php 
                        if(isset($_GET['c_id'])) {

                        }else {                            
                    ?>
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="<?= $feature_post['image']?>" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted"><?= date('F d,Y',strtotime($feature_post['created_at']))?></div>
                            <h2 class="card-title"><?= $feature_post['title']?></h2>
                            <p class="card-text"><?= substr($feature_post['description'],0,150)?>.....</p>
                            <a class="btn btn-primary" href="detail.php?id=<?= $feature_post['id']?>">Read more →</a>
                        </div>
                    </div>
                    <?php 
                        }
                    ?>
                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">
                        <?php 
                            //post is variable
                            foreach($posts as $post) {                                
                        ?>
                        <div class="col-lg-6">
                            <!-- Blog post-->
                            <div class="card mb-4">
                                <a href="#!"><img class="card-img-top" src="<?php echo $post['image']?>" alt="..." /></a>
                                <div class="card-body">
                                    <div class="small text-muted"><?= date('F d,Y', strtotime(
                                     $post['created_at']))?></div>
                                    <h2 class="card-title h4"><?= $post['title']?></h2>
                                    <p class="card-text"><?= substr($post['description'],0,100)?>.....</p>
                                    <a class="btn btn-primary" href="detail.php?id=<?= $post['id'] ?>">Read more →</a>
                                </div>
                            </div>                            
                        </div>
                        <?php
                            }
                        ?>
                    </div>                    
                </div>                
<?php 
    include "Layouts/footer.php";
?>