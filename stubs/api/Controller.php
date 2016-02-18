<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{{class_name}};

class {{class_name}}Controller extends Controller
{
    public function all()
    {
        return response()->json({{class_name}}::all());
    }

    public function find($id)
    {
        return response()->json({{class_name}}::find($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            {{validations}}
        ]);

        {{class_name}}::create($request->all());
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [

            {{validations}}
        ]);

        {{class_name}}::find($id)->fill($request->all())->save();
    }

    public function destroy($id)
    {
        {{class_name}}::destroy($id);
    }
}
