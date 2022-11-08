<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shortener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ShortenerController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'actual_url' => ['required','url'],
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        $generated = $this->generateRandomString();

        $data = Shortener::create([
            "generated_url" => $generated,
            "actual_url" => $request->actual_url
        ]);

        return response()->json([
            "data" => [
                "generated_url" => $data->generated_url,
                "actual_url" => $data->actual_url
            ],
            "meta" => [
                "message" => "success"
            ] 
        ], 200);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        if ($this->checkNotExist($randomString)){
            return $randomString;
        } else {
            return $this->generateRandomString();
        }

    }

    private function checkNotExist($shorted) {
        $data = Shortener::select('actual_url')->where('generated_url', $shorted)->first();
        if($data) return false;
        return true;
    }

}
