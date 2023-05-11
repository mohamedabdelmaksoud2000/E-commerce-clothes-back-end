<?php

namespace App\Traits;

trait ResponseApi
{

    public function responseSucess( $message , $data )
    {
        return response()->json([
            'status'=>true,
            'message'=>$message,
            'data'=>$data
        ]);
    }

    public function responseError( $message , $code )
    {
        return response()->json([
            'status'=>false,
            'message'=>$message,
        ],$code);
    }

    public function responseException( $message)
    {
        return response()->json([
            'status'=>false,
            'message'=>$message,
        ],500);
    }
}