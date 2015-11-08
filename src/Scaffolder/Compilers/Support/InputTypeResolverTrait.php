<?php

namespace Scaffolder\Compilers\Support;

trait InputTypeResolverTrait
{
    /**
     * Get the input for the field.
     *
     * @param $fieldData
     *
     * @return string
     */
    public static function getInputFor($fieldData)
    {
        if ($fieldData->type->ui == 'text')
        {
            return '{!! Form::text(\'%s\', (isset($model)) ? $model->' . $fieldData->name . ' : null) !!}';
        }
        elseif ($fieldData->type->ui == 'textarea')
        {
            return '{!! Form::textarea(\'%s\', (isset($model)) ? $model->' . $fieldData->name . ' : null) !!}';
        }
    }
}