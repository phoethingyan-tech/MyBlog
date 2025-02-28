<?php 
    include "dbconnect.php";

    $sql = "SELECT * FROM categories";
    $stmt = $conn->prepare($sql);  //Query Check
    $stmt->execute();  
    $categories = $stmt->fetchAll();   //DATA Output
    // var_dump($categories);  //Print
?>
   
<!-- Side widgets-->
<div class="col-lg-4">                    
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <!-- code for looping database  -->
                                        <?php
                                            foreach($categories as $category) {                                                
                                        ?>
                                        <li><a href="index.php?c_id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
                                </div>                                
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>