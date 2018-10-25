<?php

namespace AmtTmg\CRUD\Commands;


class Helper
{
    public static function replaceKeyWords($template, $model, $fields = '', $namespace = '', $replaces = [])
    {
        $template = str_replace([
            '@modelSingularCapital',
            '@modelSingularSmall',
            '@modelPluralCapital',
            '@modelPluralSmall',
            '@fields',
            '@namespace',
        ], [
            str_singular(ucfirst($model)),
            str_singular(strtolower($model)),
            str_plural(ucfirst($model)),
            str_plural(strtolower($model)),
            $fields,
            $namespace,
        ], $template);

        foreach ($replaces as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        return $template;
    }

    public static function getTableHeaders($fields)
    {
        $temp = '';
        foreach ($fields as $field) {
            $temp .= '<th>'.ucfirst($field['field']).'</th>
';
        }
        $temp .= '<th>Action</th>';

        return $temp;
    }

    public static function getTableBody($model, $fields)
    {
        $temp = '';
        foreach ($fields as $field) {
            $temp .= '<td>{{ $'.str_singular(strtolower($model)).'->'.$field['field'].' }}</td>
';
        }

        return $temp;
    }
}
