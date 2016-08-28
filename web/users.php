    <?php
//create functions to get data
        $usernameDB="b8913f208f01f3";
        $passwordDB="db409449";
        $database="heroku_6bf37834930fbb5";
        $host="us-cdbr-iron-east-04.cleardb.net";

    function authenticate($username,$password)
    {
        global $usernameDB, $passwordDB, $database, $host;
        $pdo = new PDO("mysql:host=$host;dbname=$database",$usernameDB,$passwordDB); 
        $stmt = $pdo->query("SELECT * from user WHERE username='$username' AND password='$password';");
        $row = $stmt-> fetch(PDO::FETCH_ASSOC);
        
        //returns the id of lecturer
        return $row['id'];
    }

     function users_show($id)
    {
        global $usernameDB, $passwordDB, $database, $host;
        $pdo = new PDO("mysql:host=$host;dbname=$database",$usernameDB,$passwordDB); 
        
        $stmt = $pdo->query("SELECT * from user WHERE id=" . $id . ";");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $user = new User();

        $user->username = $row['username'];
        $user->password = $row['password'];
        
        $pdo->null;
        
        return $user;
    }




  


class User{
    
    public $username;
    public $password;
 
    
}


?>