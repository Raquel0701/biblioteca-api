<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Autor extends ActiveRecord
{
    public static function collectionName()
    {
        return 'autores';
    }

    public function attributes()
    {
        return ['_id', 'nombre_completo', 'fecha_nacimiento', 'libros'];
    }

    public function rules()
    {
        return [
            [['nombre_completo', 'fecha_nacimiento'], 'required'],
            [['libros'], 'each', 'rule' => ['string']],
        ];
    }
}
