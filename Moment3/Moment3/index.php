<?php require_once "includes/config.php";?>
<?php include("includes/head.php"); ?>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row">
        <?php include("includes/navigering.php"); ?>
            <div class="right">
                <div id="info">        
                    <h2>Startsida - här visas de senaste 2 nyheter</h2>
                    <?php 
                    $pages = new Posts();
                    $postID = $pages->getLimitedPostsByID();

                    foreach($postID as $item) {
                    ?>
                    
                    <h3><a href="pages.php?id=<?= $item['id'];?>"><?= $item['title']; ?> - Läs mer </a></h3>
                    <p><?= $item['postdate']; ?> - <?= $item['username']; ?></p> 
                    <p><?= $item['content']; ?></p> 
                    <?php
                    }
                ?>
                </div><!-- /#info -->
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->    
</body>
</html>