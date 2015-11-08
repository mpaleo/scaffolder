<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{{class_name}};
use Datatables;

class {{class_name}}Controller extends Controller
{
    public function index()
    {
        return view('{{class_name_lw}}.index');
    }

    public function get{{class_name}}s()
    {
        return Datatables::of({{class_name}}::select('*'))
            ->addColumn('action', function ($model) {
                return '
                    <a href="/{{route_prefix}}/{{class_name_lw}}/'.$model->{{primaryKey}}.'/edit"><i class="material-icons">create</i></a>
                    <a href="#" onclick="deleteModel(\''.$model->{{primaryKey}}.'\')"><i class="material-icons">delete</i></a>';
            })
            ->make(true);
    }

    public function create()
    {
        return view('{{class_name_lw}}.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [

            {{validations}}
        ]);

        {{class_name}}::create($request->all());

        return redirect(route('{{route_prefix}}.{{class_name_lw}}.index'));
    }

    public function show($id)
	{
		return 'Not implemented';
	}

    public function edit($id)
	{
		$model = {{class_name}}::find($id);

        return view('{{class_name_lw}}.edit')->with('model', $model);
	}

    public function update($id, Request $request)
	{
        $this->validate($request, [

            {{validations}}
        ]);

        {{class_name}}::find($id)->fill($request->all())->save();

		return response()->json(['message' => 'ok']);
	}

    public function destroy($id)
	{
        {{class_name}}::destroy($id);

		return response()->json(['message' => 'ok']);
	}
}
