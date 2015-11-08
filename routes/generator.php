<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

Route::get('scaffolder/generator', function ()
{
    return view('scaffolder::generator');
});

Route::post('scaffolder/add-model', function (Request $request)
{
    return view('scaffolder::partials.model', ['modelId' => $request->input('modelId')]);
});

Route::post('scaffolder/add-field', function (Request $request)
{
    return view('scaffolder::partials.field', [
        'modelId' => $request->input('modelId'),
        'fieldId' => $request->input('fieldId')
    ]);
});

Route::post('scaffolder/generate', function (Request $request)
{
    $models = $request->only('models');

    array_walk_recursive($models, function (&$item)
    {
        if ($item == 'true') $item = true;
        elseif ($item == 'false') $item = false;
    });

    // Generate app.json
    File::put(base_path('scaffolder-config/app.json'),
        json_encode($request->except('models'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    // Generate json for models
    foreach ($models['models'] as $model)
    {
        $modelName = $model['modelName'];
        array_shift($model);
        File::put(base_path('scaffolder-config/models/' . $modelName . '.json'),
            json_encode($model, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
});

Route::post('scaffolder/generate-and-execute', function (Request $request)
{
    $models = $request->only('models');

    array_walk_recursive($models, function (&$item)
    {
        if ($item == 'true') $item = true;
        elseif ($item == 'false') $item = false;
    });

    // Generate app.json
    File::put(base_path('scaffolder-config/app.json'),
        json_encode($request->except('models'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    // Generate json for models
    foreach ($models['models'] as $model)
    {
        $modelName = $model['modelName'];
        array_shift($model);
        File::put(base_path('scaffolder-config/models/' . $modelName . '.json'),
            json_encode($model, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    // Execute artisan command
    $exitCode = Artisan::call('mpaleo.scaffolder:generate');

    return response()->json(['exitCode' => $exitCode]);
});