<?php

namespace app\controllers;

use app\models\ListasSearch;

use Yii;
use app\models\UsuariosListas;
use app\models\UsuariosListasSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuariosListasController implements the CRUD actions for UsuariosListas model.
 */
class UsuariosListasController extends Controller
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
                    'agregar' => ['POST'],
                    'quitar' => ['POST'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'only' => ['mis-listas'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['mis-listas'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
    * El usuario puede ver las listas que tiene
    * @return mixed
    */
    public function actionMisListas()
    {
        $searchModel = new UsuariosListasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 
        return $this->render('mis-listas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
/**
     * El usuario puede agregar una lista a sus lista
     * @return mixed
     */
    public function actionAgregar()
    {
        if (Yii::$app->request->isAjax) {
            $lista_id = Yii::$app->request->post('lista_id');
            $model = new UsuariosListas([
                'usuario_id' => Yii::$app->user->id,
                'lista_id' => $lista_id
            ]);

            if ($model->save()) {
                $datos = $this->datosListas();
                return $this->renderAjax('/listas/_listas', ['datos' => $datos]);
            }
        }
    }

    /**
     * El usuario puede quitar una lista de sus lista
     * @return mixed
     */
    public function actionQuitar()
    {
        if (Yii::$app->request->isAjax) {
            $lista_id = Yii::$app->request->post('lista_id');
            $lista = UsuariosListas::findOne([
                'usuario_id' => Yii::$app->user->id,
                'lista_id' => $lista_id
            ]);
            $lista->delete();
            $datos = $this->datosListas();
            return $this->renderAjax('/listas/_listas', ['datos' => $datos]);
        }
    }
    /**
     * Displays a single UsuariosListas model.
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
     * Updates an existing UsuariosListas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UsuariosListas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $usuario_id = $model->usuario_id;
        $model->delete();
        return $this->redirect(['mis-listas', 'id' => $usuario_id]);
    }

    /**
     * Finds the UsuariosListas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsuariosListas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuariosListas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function datosListas()
    {
        $searchModel = new ListasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $datos = [
                'searhModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'listas' => UsuariosListas::find()
                ->select('lista_id')
                ->where([
                    'usuario_id' => Yii::$app->user->id])
                    ->column()
                ];
        return $datos;
    }
}
