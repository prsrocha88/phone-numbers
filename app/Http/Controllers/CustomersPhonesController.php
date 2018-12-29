<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Phones;

class CustomersPhonesController extends Controller
{

    public function index(Request $request)
    {
        $filter = $request::all();

        $start = isset($filter['start']) ? $filter['start'] : 0;

        $phones_obj = new Phones();

        $phones = $phones_obj->getRows(
            isset($filter['country']) ? $filter['country'] : null,
            isset($filter['state']) ? $filter['state'] : null,
            $start
        );

        return view('phone-numbers',compact('phones', 'start'));
    }

}
