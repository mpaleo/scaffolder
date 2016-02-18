<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class {{class_name}} extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '{{table_name}}';

    {{primaryKey}}
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [

        {{fillable}}
    ];
}
