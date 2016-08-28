<?php
    require_once '../vendor/autoload.php';
    require_once 'events.php';
    header("Access-Control-Allow-Origin: *");

// Silex support for accessing the HTTP Request and Response
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\ParameterBag;


    date_default_timezone_set("Africa/Johannesburg");
    $app = new Silex\Application();

    // After receiving a request, before doing anything else
    $app->before(function (Request $request)
    {
        // If we received JSON
        if (0 === strpos($request->headers->get('Content-Type'), 'application/json'))
        {
            // Decode it
            $data = json_decode($request->getContent(), true);
            // And replace the encoded data with the decoded data
            $request->request->replace(is_array($data) ? $data : array());
        }
    });

//login
    $app->post('/users',function(Request $request)
     {
         $username= $request->request->get('username');
         $password = $request->request->get('password');
         
         $user_id = authenticate($username,$password);
         
         if ($user_id != null)
         {
             
            return json_encode(users_show($user_id));
             
         }else
         {
             return new Response('Unauthorized', 401);
         } 
     });

    //app,verb,url expexted
    $app->get('/', function()
    {
         return json_encode("Welcome to Happening");    
         return json_encode (photos_index());
    });
    
     //show all photos
    $app->get('/photos', function()
    {
        return json_encode (photos_index());
    });

   //show photos with id
    $app->get('/photos/{id}', function($id)
    {
        return json_encode (photos_show($id));
    });


    $app->post('/photos',function(Request $request)
    {
        $photo = new Photo();
        
        $photo->user_id = $request->request->get('user_id');
        $photo->image = $request->request->get('image');
        $photo->latitude = $request->request->get('latitude');
        $photo->longitude = $request->request->get('longitude');
        $photo->event = $request->request->get('event');
        
          return json_encode(photos_add($photo));
        
    });

  
 $app->run();
?>

