<?php

namespace App\Utils;

class PaginateUtil
{
    /**
     * Get message from YAML file based on error code.
     *
     * @param Model $model
     * @param int $perItem = 10
     * @return mixed
     */
    public static function paginateModel($model, $perItem = 10)
    {
        return $model->paginate($perItem);
    }
}
