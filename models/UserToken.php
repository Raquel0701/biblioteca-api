<?php

namespace app\models;

use yii\mongodb\ActiveRecord;

class UserToken extends ActiveRecord
{
    public static function collectionName()
    {
        return 'tokens';
    }

    public function attributes()
    {
        return ['_id', 'token', 'expira'];
    }
}
