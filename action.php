<?php
session_start();
ini_set('display_errors', 1);

Class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    // Other functions...

    function get_pages(){
        // Query to select all pages with status
        $get_pages_query = "SELECT *, CASE WHEN status = 1 THEN 'Active' ELSE 'Inactive' END as status_description FROM pages ORDER BY pagename ASC";
        
        // Execute the query
        $result = $this->db->query($get_pages_query);
        
        // Check if there are any rows returned
        if($result->num_rows > 0){
            $pages = array();
            // Fetch associative array of each row
            while($row = $result->fetch_assoc()){
                $pages[] = $row;
            }
            return $pages;
        } else {
            return false; // Return false if no pages found
        }
    }
}
?>
