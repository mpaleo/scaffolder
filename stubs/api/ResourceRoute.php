
    $api->get('{{resource_lw}}', 'App\Http\Controllers\{{resource}}Controller@all');
    $api->get('{{resource_lw}}/{id}', 'App\Http\Controllers\{{resource}}Controller@find');
    $api->post('{{resource_lw}}', 'App\Http\Controllers\{{resource}}Controller@store');
    $api->put('{{resource_lw}}/{id}', 'App\Http\Controllers\{{resource}}Controller@update');
    $api->delete('{{resource_lw}}/{id}', 'App\Http\Controllers\{{resource}}Controller@destroy');
