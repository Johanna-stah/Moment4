<?php include_once("includes/config.php");?>
<?php
if(isset($_GET['id'])) {
    $id = ($_GET['id']);
} else {
    header("location: index.php");
}
$posts = new Posts();
$post = $posts->getPostsID($id);
?>
<?php include("includes/head.php"); ?>
<body>
    <?php include("includes/header.php"); ?>
    <div class="container">
        <div class="row">
        <?php include("includes/navigering.php"); ?>
            <div class="right">
                <div id="info">        
                    <h3><?= $post['title']; ?></h3>
                    <?= $post['postdate']; ?> - <?= $post['username']; ?>
                    <?= $post['content']; ?>
                </div><!-- /#info -->
            </div><!-- /.right -->
            <?php include("includes/footer.php"); ?>
        </div><!-- /.row -->        
    </div><!-- /.container -->    
</body>
</html>