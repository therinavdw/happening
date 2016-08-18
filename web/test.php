 

    // Silex support for accessing the HTTP Request and Response
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\ParameterBag;

    date_default_timezone_set("Africa/Johannesburg");
    $app = new Silex\Application();

   
    //show all lecturers
    $app->get('/lecturers', function()
    {
        return json_encode (lecturers_index());
    });


    //show lectures with id
    $app->get('/lecturers/{id}', function($id)
    {
        return json_encode (lecturers_show($id));
    });

    //post insert in db
    $app->post('/lecturers', function(Request $request)
    {
        $lecturer = new Lecturer();
        
        // Grab data from the request
        $lecturer->name = $request->request->get('name');
        $lecturer->email = $request->request->get('email');

        return json_encode(lecturers_add($lecturer));
    });

    //edit db
    $app->put('/lecturers/{id}', function(Request $request, $id)
    {
         $lecturer = new Lecturer();
        
        // Grab data from the request
       
        $lecturer->name = $request->request->get('name');
        $lecturer->email = $request->request->get('email');
        
        lecturers_edit($id, $lecturer);
        
        return json_encode($lecturer);

    });


    $app->delete('/lecturers/{id}' , function($id)
    {
       lecturers_remove($id);
        
        return '{"success":true}';
                     
                     
    });

    

   