<?php

namespace app\controllers;

use app\models\Libro;
use MongoDB\BSON\ObjectId;
use Yii;
use yii\rest\Controller;
use app\models\Autor;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\mongodb\ActiveRecord;


class AutorController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['index', 'view', 'create'],
        ];

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'view' => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return Autor::find()->all();
    }

    public function actionView($id)
    {
        if (strlen($id) !== 24 || !ctype_xdigit($id)) {
            throw new BadRequestHttpException("ID inválido");
        }

        try {
            $objectId = new ObjectId($id);

            $autor = Autor::findOne(['_id' => $objectId]);

            if (!$autor) {
                throw new NotFoundHttpException("Autor no encontrado");
            }

            return $autor;
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Error al obtener el autor: " . $e->getMessage());
        }
    }



    public function actionCreate()
    {
        $autor = new Autor();
        $autor->load(Yii::$app->request->post(), '');

        if ($autor->save()) {
            Yii::$app->response->statusCode = 201;
            return $autor;
        }

        Yii::$app->response->statusCode = 400;
        return ['error' => 'No se pudo crear el autor', 'details' => $autor->errors];
    }

    public function actionUpdate($id)
    {
        $autor = Autor::findOne(['_id' => $id]);
        if (!$autor) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Autor no encontrado'];
        }

        $autor->load(Yii::$app->request->bodyParams, '');
        if ($autor->save()) {
            return $autor;
        }

        Yii::$app->response->statusCode = 400;
        return ['error' => 'No se pudo actualizar el autor', 'details' => $autor->errors];
    }

    public function actionDelete($id)
    {
        $autor = Autor::findOne(['_id' => $id]);
        if (!$autor) {
            Yii::$app->response->statusCode = 404;
            return ['error' => 'Autor no encontrado'];
        }

        if ($autor->delete()) {
            Yii::$app->response->statusCode = 204;
            return ['message' => 'Autor eliminado'];
        }

        Yii::$app->response->statusCode = 400;
        return ['error' => 'No se pudo eliminar el autor'];
    }
}
