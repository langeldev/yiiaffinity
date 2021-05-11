<?php

namespace app\controllers;

use Yii;
use app\models\ListasProductos;
use app\models\UsuariosListas;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ListasProductosController implements the CRUD actions for ListasProductos model.
 */
class ListasProductosController extends Controller
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
                    'delete' => ['POST'],
                    'agergar' => ['POST'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'only' => ['agregar'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['agregar'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
    * Agrega un producto a una lista del usuario
    * @return mixed
    */
    public function actionAgregar()
    {
        if (Yii::$app->request->isAjax) {
            $lista = Yii::$app->request->post('lista_id');
            $producto = Yii::$app->request->post('producto_id');
            $listaProducto = new ListasProductos([
                'lista_id' => $lista,
                'producto_id' => $producto
            ]);
            if ($listaProducto->save()) {
                $misListas = UsuariosListas::misListas($producto);
                return $this->asJson(['misListas' => $misListas]);
            }
        }
    }

    /**
    * Elimina los productos de una lista
    *
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionDelete($id)
    {
        $producto = $this->findModel($id);
        $lista = $producto->lista_id;
        $producto->delete();

        return $this->redirect(['/usuarios-listas/view', 'id' => $lista]);
    }
    
    /**
     * Finds the ListasProductos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ListasProductos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ListasProductos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
