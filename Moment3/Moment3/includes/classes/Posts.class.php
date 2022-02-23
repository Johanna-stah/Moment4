<?php
    class Posts {
    private $db;
    
    // Constructor
    function __construct() {
        $this->db = new mysqli("mysql25.unoeuro.com", "johannastahlgren_se", "Hbg3xnmD6h2t", "johannastahlgren_se_db_userdb");
        if($this->db->connect_errno > 0) {
            die("Fel vid anslutning: " . $this->db->connect_error);
        }
    }

    // ADD posts
    public function addPosts($title, $content, $username) : bool {
        $sql = "INSERT INTO posts(title, content, username)VALUES('$title', '$content','$username');";
        $result = mysqli_query($this->db, $sql);
        return $result;
    }
    // READ posts
    public function getPosts() : array {
        $sql = "SELECT * FROM posts ORDER BY postdate DESC;";
        $result =  mysqli_query($this->db, $sql);
        
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }  
    // UPDATE post
    public function updatePosts(int $id, string $title, string $content) : bool {
        $sql ="UPDATE posts SET title='$title', content='$content' WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }
    // DELETE post
    public function deletePosts($id) : bool {
        $sql = "DELETE FROM posts WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);

        return $result;
    }
    // GET specific post from id
    public function getPostsByID(int $id) : array {
        $sql = "SELECT * FROM posts WHERE id=$id;";
        $result = mysqli_query($this->db, $sql);
        $row = $result->fetch_assoc();
        
        return $row;
    }
    // GET specific post from ID
    public function getPostsID($id) {
        $id = intval($id);
        $sql = "SELECT * FROM posts WHERE id=$id;";
        $result = $this->db->query($sql);
        $row = mysqli_fetch_array($result);
        
        return $row;
    } 
    // GET post by id limited to 5 and ordered (startpage) 
    public function getLimitedPostsByID() : array {
        $sql = "SELECT id, title, content, postdate, username FROM posts ORDER BY postdate DESC LIMIT 2;";
        $result = $this->db->query($sql);
        
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Destruct
    function __destructor() {
        mysqli_close($this->db);
    }
}