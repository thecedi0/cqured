<?php
use CoreModel as DB;

class ValuesController
{

  

    function __construct()
    {
    }


    // method called to handle a GET request

    function httpGet(int $id = null): ?array
    {   
        // --- use this if you are connected to the Databases ---
        // $users = DB::table('persons')->get();
        // return $users;
        return ['value1','value2'];
    }


    // method called to handle a POST request
    function httpPost(array $form)
    {
      // code here
        return ['id'=>2];
    }


    // method called to handle a PUT request
    function httpPut(int $id)
    {
      // code here
        return ['id'=>2];
    }


    // method called to handle a DELETE request
    function httpDelete(int $id)
    {
      // code here
        return ['id'=>2];
    }
}
