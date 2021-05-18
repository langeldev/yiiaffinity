<?php

namespace app\controllers;

use Yii;
use app\models\Criticas;
use app\models\CriticasSearch;
use app\models\Productos;
use app\models\Usuarios;
use app\models\Valoraciones;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CriticasController implements the CRUD actions for Criticas model.
 */
class CriticasController extends Controller
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
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'only' => ['create', 'delete', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['create', 'delete', 'update'],
                        'roles' => ['@'],
                        
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Criticas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CriticasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Criticas model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
    * Devuelve todas las criticas de un  al producto
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException si no encuentra el producto
    */
    public function actionVerCriticas($id)
    {
        $producto = $this->findProducto($id);
        $criticas = Criticas::find()
            ->where(['producto_id' => $id])
            ->orderBy(['created_at' => \SORT_DESC]);
        $pagination = new Pagination([
            'pageSize' => 3,
            'totalCount' =>  $criticas->count()
        ]);
        
        $criticas->limit($pagination->limit)->offset($pagination->offset);
        return $this->render('ver-criticas', [
            'producto' => $producto,
            'criticas' => $criticas->all(),
            'pagination' => $pagination,
        ]);
    }


    /**
     * Modifica las criticas a un producto
     *
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $producto = $this->findProducto($id);
        $model = new Criticas();
        $model->producto_id = $producto->id;
        $model->usuario_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'producto' => $producto,
            'puntosValoracion' => Valoraciones::listaPuntos(),
        ]);
    }

      /**
     * Updates an existing Criticas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $producto = $this->findProducto($id);
        $model = Criticas::findOne([
                'producto_id' => $id,
                'usuario_id' => Yii::$app->user->id
            ]);

        if ($model === null) {
            Yii::$app->session->setFlash('warning', 'No has incluido ninguna critica sobre este título');
            return $this->redirect(['/productos/ficha', 'id' => $id]);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'producto' => $producto,
            'puntosValoracion' => Valoraciones::listaPuntos(),
        ]);
    }

    public function actionUsuarios($id)
    {
        $usuario = $this->findUsuario($id);
        $criticas = Criticas::find()
        ->where(['usuario_id' => $usuario->id])
        ->orderBy(['created_at' => \SORT_DESC]);
        $pagination = new Pagination([
            'pageSize' => 6,
            'totalCount' =>  $criticas->count()
        ]);
        
        $criticas->limit($pagination->limit)->offset($pagination->offset);
       
        return $this->render('usuarios', [
                    'usuario' => $usuario,
                    'criticas' => $criticas->all(),
                    'pagination' => $pagination,
        ]);
    }


    /**
     * Deletes an existing Criticas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $critica = $this->findModel($id);
        $producto = $critica->producto_id;
        $critica->delete();
        return $this->redirect(['productos/ficha', 'id' => $producto]);
    }

    /**
     * Finds the Criticas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Criticas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Criticas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUsuario($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página no existe.');
    }
}
