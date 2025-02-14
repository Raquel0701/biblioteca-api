<?php

namespace app\models;

use Yii;
use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends ActiveRecord implements IdentityInterface
{
    public static function collectionName()
    {
        return 'users';
    }

    public function attributes()
    {
        return ['_id', 'username', 'password_hash', 'access_token', 'token_expira'];
    }

    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['username'], 'unique'],
        ];
    }

    public static function findIdentity($id)
    {
        return self::findOne(['_id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::findOne(['access_token' => $token]);

        if ($user) {
            if ($user->token_expira >= time()) {
                return $user;
            } else {
                Yii::info("Token expirado");
            }
        }

        return null;
    }


    public function getId()
    {
        return (string) $this->_id;
    }

    public function getAuthKey()
    {
        return $this->_id;
    }

    public function validateAuthKey($authKey)
    {
        return (string) $this->_id === (string) $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateToken()
    {
        $key = "mySuperSecretKey12345";
        $payload = [
            "iss" => "biblioteca-api",
            "aud" => "biblioteca-usuarios",
            "iat" => time(),
            "exp" => time() + (30 * 60),
            "user_id" => (string) $this->_id
        ];
        $this->access_token = JWT::encode($payload, $key, 'HS256');
        $this->token_expira = $payload['exp'];
        $this->save();
        return $this->access_token;
    }
}
