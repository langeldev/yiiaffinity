<?php

namespace app\controllers;

use app\models\Productos;
use Yii;
use app\models\Valoraciones;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ValoracionesController implements the CRUD actions for Valoraciones model.
 */
class ValoracionesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'no-vista' => ['POST'],
                    'agregar' => ['POST'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['agregar', 'no-vista'],
                        'roles' => ['@'],
                    ]
                ]
            ]

        ];
    }



    /**
     * Valorara un producto si este ya tiene valortacion por el mismo usuario la modificará
     *
     */
    public function actionAgregar()
    {
        if (Yii::$app->request->isAjax) {
            $producto_id = Yii::$app->request->post('producto_id');
            $valoracion = $this->findModel($producto_id, Yii::$app->user->id);
            $valoracion->valoracion = Yii::$app->request->post('valoracion');
            Yii::debug($valoracion);
            $valoracion->save();
            $producto = $this->findProducto($producto_id);
            return $this->asJson([
                'media' => $producto->media,
                'total' => $producto->votosTotales(),
                ]);
        }
    }

    /**
     * Si el usuario no ha visto el producto eliminará su voto
     */
    public function actionNoVista()
    {
        if (Yii::$app->request->isAjax) {
            $producto_id = Yii::$app->request->post('producto_id');
            $valoracion = $this->findModel($producto_id, Yii::$app->user->id);
            Yii::debug($valoracion);
            $valoracion->delete();
            $producto = $this->findProducto($producto_id);
            return $this->asJson([
                'media' => $producto->media,
                'total' => $producto->votosTotales(),
                ]);
        }
    }

    /**
     * Finds the Valoraciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $producto_id
     * @param integer $usuario_id
     * @return Valoraciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($producto_id, $usuario_id)
    {
        $model = Valoraciones::findOne(['producto_id' => $producto_id, 'usuario_id' => $usuario_id]);
        if ($model !== null) {
            return $model;
        } else {
            $model = new Valoraciones(['producto_id' => $producto_id, 'usuario_id' => $usuario_id]);
            return $model;
        }
    }

    /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProducto($id)
    {
        if (($model = Productos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
