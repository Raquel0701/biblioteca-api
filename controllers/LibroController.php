<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Libro;
use yii\web\NotFoundHttpException;
use yii\filters\auth\HttpBearerAuth;
use MongoDB\BSON\ObjectId;
use yii\web\BadRequestHttpException;

class LibroController extends ActiveController
{
    public $modelClass = 'app\models\Libro';

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
        return Libro::find()->all();
    }

    public function actionView($id)
    {
        if (!ObjectId::isValid($id)) {
            throw new BadRequestHttpException("ID inválido");
        }

        try {
            $objectId = new ObjectId($id);

            $libro = Libro::findOne(['_id' => $objectId]);

            if (!$libro) {
                throw new NotFoundHttpException("Libro no encontrado");
            }

            return $libro;
        } catch (\Exception $e) {
            throw new BadRequestHttpException("Error al obtener el libro: " . $e->getMessage());
        }
    }


    public function actionCreate()
    {
        $model = new Libro();

        $data = Yii::$app->request->post();

        if (empty($data)) {
            Yii::error('No se recibieron datos para crear el libro.');
            throw new BadRequestHttpException('No se recibieron datos para crear el libro.');
        }

        if (empty($data['titulo'])) {
            $data['titulo'] = 'Título predeterminado';
        }
        if (empty($data['anio_publicacion'])) {
            $data['anio_publicacion'] = 2000; // Año predeterminado
        }

        if (!$model->load($data, '')) {
            Yii::error('Datos no se pudieron cargar en el modelo: ' . json_encode($model->errors));
            return ['error' => 'Datos no se pudieron cargar', 'details' => $model->errors];
        }

        if (!$model->validate()) {
            Yii::error('Datos inválidos al crear el libro: ' . json_encode($model->errors));
            return ['error' => 'Datos inválidos', 'details' => $model->errors];
        }

        if ($model->save()) {
            Yii::info('Libro creado correctamente: ' . json_encode($model->attributes));
            return ['message' => 'Libro creado correctamente', 'data' => $model];
        } else {
            Yii::error('Error al guardar el libro.');
            return ['error' => 'No se pudo guardar el libro'];
        }
    }

    public function actionUpdate($id)
    {
        $objectId = new ObjectId($id);
        $model = Libro::findOne(['_id' => $objectId]);

        if (!$model) {
            throw new NotFoundHttpException("Libro no encontrado");
        }

        $model->load(Yii::$app->request->post(), '');

        if (!$model->validate()) {
            return ['error' => 'Datos inválidos', 'details' => $model->errors];
        }

        return $model->save() ? ['message' => 'Libro actualizado correctamente', 'data' => $model] : ['error' => 'No se pudo actualizar el libro'];
    }

    public function actionDelete($id)
    {
        $objectId = new ObjectId($id); // Convert string to ObjectId
        $deleted = Libro::deleteAll(['_id' => $objectId]);

        return $deleted ? ['message' => 'Libro eliminado'] : ['error' => 'No se pudo eliminar el libro'];
    }
}
