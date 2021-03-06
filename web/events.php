<?php
//create functions to get data
        $username="b8913f208f01f3";
        $password="db409449";
        $database="heroku_6bf37834930fbb5";
        $host="us-cdbr-iron-east-04.cleardb.net";

    function photos_index()
    {
        global $username, $password, $database, $host;

        
        $pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);  
        $stmt= $pdo->query("SELECT * FROM photoupload;");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $photos = array();
        
        foreach($rows as $row)
        {
            $photo = new Photo();
            $photo->user_id= $row['user_id'];
            $photo->image= $row['image'];
            $photo->latitude= $row['latitude'];
            $photo->longitude= $row['longitude'];
            $photo->event= $row['event'];
            
            array_push($photos,$photo);
        }
        
        $pdo->null;
        return $photos; 
        
    }

        function photos_show($id)
           {
                 global $username, $password, $database, $host;
                $pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password); 
               $stmt= $pdo->query("SELECT * FROM photoupload WHERE id = ".$id.";");
               $row = $stmt->fetch(PDO::FETCH_ASSOC);

               $photo = new Photo();

                $photo->user_id= $row['user_id'];
                $photo->image= $row['image'];
                $photo->latitude= $row['latitude'];
                $photo->longitude= $row['longitude'];
                $photo->event= $row['event'];
                $pdo->null;

               return $photo;

           }

    function photos_add($photo)
    {
         global $username, $password, $database, $host;
         $pdo = new PDO("mysql:host=$host;dbname=$database",$username,$password);
         $stmt= $pdo->prepare("INSERT INTO photoupload (user_id,image,latitude,longitude,event) VALUES (:user_id,:image,:latitude,:longitude,:event);");
        
   
        $stmt->bindParam(':user_id',$photo->user_id,PDO::PARAM_INT);
        $stmt->bindParam(':image',$photo->image,PDO::PARAM_STR);
        $stmt->bindParam(':latitude',$photo->latitude,PDO::PARAM_STR);
        $stmt->bindParam(':longitude',$photo->longitude,PDO::PARAM_STR);
        $stmt->bindParam(':event',$photo->event,PDO::PARAM_STR);
        
        $stmt->execute();
        $id = $pdo->lastInsertID();
        
        $pdo->null;
        
        return photos_show($id);
        
    }

  


class Photo{
    
    public $user_id;
    public $image;
    public $latitude;
    public $longitude;
    public $event;
    
}


?>