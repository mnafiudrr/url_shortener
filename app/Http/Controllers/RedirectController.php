<?php

namespace App\Http\Controllers;

use App\Models\Shortener;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    //
    public function redirect($url)
    {
        $data = Shortener::select('actual_url')->where('generated_url', $url)->first();
        if (!$data) return abort(404);
        return redirect($data->actual_url);
    }
}
