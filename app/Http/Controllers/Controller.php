<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static function makeValidatorResponse($errors){
        
        $data = [
            'status'=>'ERROR',
            'result' => null,
            'error' => array(
                'code' => 'VALIDATION_ERROR',
                'messages' => [],
            )
        ];
        
        foreach ($errors->getMessages() as $value) {
            array_push($data['error']['messages'], $value);
        }

        return $data;
    }

    /**
     * @param $obj
     * @return array
     */
    static function makeSuccessResponse($obj){

        $data = [
            'status'=>'SUCCESS',
            'result' => null,
            'error' => null
        ];
        
        if($obj instanceof LengthAwarePaginator){

            $arrayConverted = $obj->toArray();
            $data['result'] = $arrayConverted['data'];
            unset($arrayConverted['data']);

            $data['paginate'] = $arrayConverted;
            $data['paginate']['total'] = $obj->count();

        }else{
            $data['result'] = $obj;
        }

        return $data;
    }

    /**
     * @param $code
     * @param $msg
     * @return array
     */
    static function makeErrorResponse($code,$msg){

        $data = [
            'status'=>'ERROR',
            'result' => null,
            'error' => array(
                'code' => $code,
                'message' => $msg,
            )
        ];

        return $data;

    }
}
