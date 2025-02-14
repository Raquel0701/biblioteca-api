<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $params = Yii::$app->request->getBodyParams();

        if (!isset($params['username']) || !isset($params['password'])) {
            return ['error' => 'Faltan parámetros (username o password)'];
        }

        $user = User::findOne(['username' => $params['username']]);

        if (!$user || !$user->validatePassword($params['password'])) {
            return ['error' => 'Usuario o contraseña incorrectos'];
        }

        $token = $user->generateToken();
        return ['access_token' => $token, 'expires_in' => 1800]; // 30 minutos
    }

    public function actionRegister()
    {
        $params = Yii::$app->request->post();
        if (User::findOne(['username' => $params['username']])) {
            return ['error' => 'El usuario ya existe'];
        }

        $user = new User();
        $user->username = $params['username'];
        $user->password_hash = Yii::$app->security->generatePasswordHash($params['password']);

        if ($user->save()) {
            return ['message' => 'Usuario registrado exitosamente'];
        }

        return ['error' => 'No se pudo registrar el usuario'];
    }
}
