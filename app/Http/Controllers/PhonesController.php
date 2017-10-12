<?php

namespace App\Http\Controllers;

use App\Phone;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class PhonesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('Dhcp update');
        $file = $request->file('file');
        foreach (file($file) as $line) {
            echo 'adding :'.$line;
            $fields = explode(' ', $line);
            $phone = Phone::firstOrCreate([
                'mac'  => $fields[1],
                'ip'   => $fields[2],
                'name' => $fields[3],
            ]);
        }

        //new \App\Phone::create(['mac'  => 1, 'ip'   => 2, 'name' => 3]);
    }
}
