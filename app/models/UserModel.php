<?php
// require_once('Database.php');

// class UserModel {
//     private $db;

//     public function __construct() {
//         $this->db = new Database();
//     }

//     public function getUserByEmail($email) {
//         $connection = $this->db->getConnection();
//         $query = "SELECT * FROM utilisateurs WHERE email = ?";
//         $stmt = $connection->prepare($query);
//         $stmt->bind_param('s', $email);
//         $stmt->execute();
        
//         $result = $stmt->get_result();
//         $user = $result->fetch_assoc();
        
//         $stmt->close();
//         return $user;
//     }
// }
?>
