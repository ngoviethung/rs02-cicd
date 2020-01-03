<?php

namespace App\Http\Controllers;

use App\Http\Services\MasterdataService;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    
    public function sendResponse($result, $message = 'sucsess')
    {
        
        $res = [
            'code' => 200,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($res);
    }

    public function sendError($error, $code = 404)
    {
        $res = [
            'code' => $code,
            'message' => $error,
        ];

        return response()->json($res, $code);
    }
}
