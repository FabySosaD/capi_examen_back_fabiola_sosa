<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDomicilio;

class UserController extends Controller
{
    private static $response = array(
        'success' => false,
        'data'    => null,
        'message' => "",
        'error'   => ""            
    );  

    public function obtenerUsers(Request $request) 
    {
        try 
        {    
            $response = self::$response;
            $httpCode = 200;

            $result = User::obtenerUsers();

            if(!empty($result['error']) || $result['success'] === false) {
                $httpCode = 301;
            }
            return response()->json($result, $httpCode);
        } 
        catch (Exception $e) 
        {
            return response()->json($e, 301);
        }
    }

    public function show($id)
    {
        $httpCode = 200;

        $result   = User::obtenerUsers($id);
        
        if(!empty($result['error']) || $result['success'] === false) {
            $httpCode = 301;
        }

        return response()->json($result, $httpCode);
    }
}
