<?php

namespace app\controllers;

use app\models\Listas;
use Yii;

use app\models\ListasSearch;
use app\models\UsuariosListas;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * ListasController implements the CRUD actions for Listas model.
 */
class ListasController extends Controller
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
                    'borrar' => ['POST'],
                ],
            ],
            'access' => [
                '__class' => AccessControl::class,
                'only' => ['borrar', 'create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['borrar', 'create', 'update'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->soyAdmin;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Listas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $datos =  $datos = $this->datosListas();
        return $this->render('index', ['datos' => $datos]);
    }

    public function actionBorrar()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('lista_id');
            $this->findModel($id)->delete();
            $datos = $this->datosListas();
            return $this->renderAjax('_listas', ['datos' => $datos]);
        }
    }

    /**
     * Crea una listas
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Listas();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Modifica una listas
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
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
                    'usuario_id' => Yii::$app->user->id
                ])
                ->column()
        ];
        return $datos;
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Listas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página no existe.');
    }
}
