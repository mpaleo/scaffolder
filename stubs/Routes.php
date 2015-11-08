/*
|--------------------------------------------------------------------------
| Scaffolder routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => '{{route_prefix}}'], function ()
{

    Route::get('dashboard', function ()
    {
        return view('dashboard');
    });
{{routes}}
});