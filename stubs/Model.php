<?php

namespace {{namespace}};

use {{namespace_model_extend}} as Model;

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