<?php

namespace app\controllers;

use app\models\Roles;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
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
                'only' => [
                             'index'
                           , 'create'
                           , 'update'
                           , 'delete'
                           , 'view'
                           , 'registro'
                           , 'editar-perfil'
                        ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['index','create', 'update', 'delete', 'view'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->soyAdmin;
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['registro'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['editar-perfil'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuarios model.
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
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => Roles::lista(),
            'generos' => Usuarios::listaGeneros(),
        ]);
    }


      /**
     * El usuario puede registrarse.
     *
     * @return mixed
     */
    public function actionRegistro()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREATE]);
     
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['site/login']);
        }

        return $this->render('registro', [
            'model' => $model,
            'generos' => Usuarios::listaGeneros(),
        ]);
    }

    /**
     * El usuario puede registrarse.
     *
     * @return mixed
     */
    public function actionBuscarAmigos()
    {
        $searchModel = new UsuariosSearch();
        $amigos = $searchModel->searchAmigos(Yii::$app->request->queryParams);

        return $this->render('buscar-amigos', [
            'amigos' => $amigos,
            'model' => $searchModel
        ]);
    }


    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Usuarios::SCENARIO_UPDATE;
        $model->password = '';
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => Roles::lista(),
            'generos' => Usuarios::listaGeneros(),
        ]);
    }

    /**
     * El usuario puede editar su propio perfil.
     * @return mixed
     */
    public function actionEditarPerfil()
    {
        $model = $this->findModel(
            Yii::$app->user->id
        );

        $model->scenario = Usuarios::SCENARIO_UPDATE;
        $model->password = '';
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->goHome();
        }

        return $this->render('editar-perfil', [
            'model' => $model,
            'generos' => Usuarios::listaGeneros(),
        ]);
    }


    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
