<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class Libro extends ActiveRecord
{
    public static function collectionName()
    {
        return 'libros';
    }

    public function attributes()
    {
        return ['_id', 'titulo', 'autores', 'anio_publicacion', 'descripcion'];
    }

    public function rules()
    {
        return [
            [['titulo', 'anio_publicacion'], 'required'],
            ['anio_publicacion', 'integer'],
            ['titulo', 'string', 'max' => 255],
            ['descripcion', 'string'],

        ];
    }
}
