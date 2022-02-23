<?php require_once "includes/config.php";?>
<?php include("includes/head.php"); ?>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row">
            
            <?php include("includes/navigering.php"); ?>
            <div class="right">
                <div id="info"> 
                <h2>Alla inlägg!</h2>

                <p></p>
                <?php 
                    $pages = new Posts();
                    $postID = $pages->getPosts();

                    foreach($postID as $item) {
                    ?>
                    
                    <h3><a href="pages.php?id=<?= $item['id'];?>"><?= $item['title']; ?> - Läs mer </a></h3>
                    <?= $item['postdate']; ?> - <?= $item['username']; ?>
                    <?= $item['content']; ?> 
                    <?php
                    }

                ?>
                </div>
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->    
</body>
</html>