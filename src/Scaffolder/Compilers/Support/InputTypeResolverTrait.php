<?php

namespace Scaffolder\Compilers\Support;

trait InputTypeResolverTrait
{
    /**
     * Get the input for the field.
     *
     * @param \stdClass $fieldData
     *
     * @return string
     * @throws \Exception
     */
    public static function getInputFor(\stdClass $fieldData)
    {
        $formData = explode(':', $fieldData->type->ui);
        $type = $formData[0];
        $options = isset($formData[1]) ? $formData[1] : '[]';

        if ($type == 'text' ||
            $type == 'number' ||
            $type == 'textarea'
        )
        {
            return '{!! Form::' . $type . '(\'' . $fieldData->name . '\', (isset($model)) ? $model->' . $fieldData->name . ' : null, ' . $options . ') !!}';
        }
        elseif ($type == 'select')
        {
            $list = isset($formData[1]) ? $formData[1] : '[]';
            $options = isset($formData[2]) ? $formData[2] : '[]';

            return '{!! Form::select(\'' . $fieldData->name . '\', ' . $list . ', (isset($model)) ? $model->' . $fieldData->name . ' : null, ' . $options . ') !!}';
        }
        elseif ($type == 'selectRange')
        {
            $begin = isset($formData[1]) ? $formData[1] : '0';
            $end = isset($formData[2]) ? $formData[2] : '0';
            $options = isset($formData[3]) ? $formData[3] : '[]';

            return '{!! Form::selectRange(\'' . $fieldData->name . '\', ' . $begin . ', ' . $end . ', (isset($model)) ? $model->' . $fieldData->name . ' : null, ' . $options . ') !!}';
        }
        elseif ($type == 'checkbox')
        {
            $options = isset($formData[1]) ? $formData[1] : 'false';

            return '{!! Form::checkbox(\'' . $fieldData->name . '\', 1, (isset($model) && $model->' . $fieldData->name . ' == 1) ? true : false, ' . $options . ') !!}';
        }
        elseif ($type == 'radio')
        {
            array_shift($formData);
            $radioGroup = '';
            $radioId = 0;

            foreach ($formData as $value)
            {
                $radioGroup .= '{!! Form::radio(\'' . $fieldData->name . '\', \'' . $value . '\', (isset($model) && $model->' . $fieldData->name . ' == \'' . $value . '\') ? true : false, [\'id\' => ' . $radioId . ']) !!}';
                $radioId++;

                if (end($formData) != $value) $radioGroup .= PHP_EOL . "\t";
            }

            return $radioGroup;
        }
        else
        {
            throw new \Exception('Input type not implemented');
        }
    }
}
