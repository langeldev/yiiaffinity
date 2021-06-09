<?php

namespace app\controllers;

use app\models\Roles;
use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\bootstrap4\Html;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

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
                    'index', 'create', 'update', 'delete', 'view', 'registro', 'editar-perfil', 'eliminar-cuenta'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['index', 'create', 'update', 'delete', 'view'],
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
                        'actions' => ['editar-perfil', 'eliminar-cuenta'],
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
            'roles' => Roles::lista(),
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
            'roles' => Roles::lista(),
        ]);
    }

    /**
     * Envia un correo electrónico para recueprar la contraseña
     */
    public function actionPassRecovery()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_UPDATE]);

        if (Yii::$app->request->isPost) {
            $email = Yii::$app->request->post('Usuarios')['email'];
            $usuario = $model->userPorEmail($email);
            if ($usuario !== null) {
                $subject = 'Restablecimiento de contraseña';
                $usuario->recover = Yii::$app->security->generateRandomString();
                $usuario->save();
                $url = Html::a(
                    'Recuperar contraseña',
                    Url::to(
                        [
                            'usuarios/pass-reset',
                            'id' => $usuario->id,
                            't' => $usuario->recover
                        ],
                        true
                    )
                );
                $body = "<h3>Hola $usuario->login,</h3>
                <p>Si desea restablecer su contaseña, haga click en el siguiente enlace, si no has solicitado el restablecimiento, ignora este mensaje.</p>
                <p>$url</p>";

                $this->enviarEmail($email, $subject, $body);
                Yii::$app->session->setFlash('info', 'Email enviado');
            } else {
                Yii::$app->session->setFlash('error', 'Ha ocurrido un error');
            }
        }

        return $this->render('pass-recovery', [
            'model' => $model,
        ]);
    }

    /**
     * Cambia las contraseñas
     * @param integer $id
     * @param string $t
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPassReset($id, $t)
    {
        $model = $this->findModel($id);
        if ($model->id == $id && $model->recover === $t) {
            $model->scenario = Usuarios::SCENARIO_UPDATE;
            $model->password = '';
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['site/login']);
            }
            return $this->render('pass-reset', [
                'model' => $model,
            ]);
        } else {
            throw new NotFoundHttpException('Credenciales no válidas.');
        }
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
     * Permite que el usuario borre su cuenta a traves de un formulario de validacion de contraseña
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionEliminarCuenta($id)
    {

        $model = $this->findModel($id);
        $model->scenario = Usuarios::SCENARIO_ELIMINAR;

        if ($model->load($form = Yii::$app->request->post())) {
            $model->password_repeat = $form['Usuarios']['password_repeat'];
            if ($model->delete()) {
                Yii::$app->session->setFlash('info', 'Su cuenta ha sido eliminada correctamente');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Ha ocurrido un error');
                return $this->redirect(['valoraciones/usuarios', 'id' => $id]);
            }
        }

        return $this->renderAjax('_eliminar-cuenta', [
            'model' => $model,

        ]);
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

        throw new NotFoundHttpException('La página no existe.');
    }

    /**
     * Envia un email a la direccion escrtita por el usuario
     *
     * @param string $email
     * @param string $subject
     * @param string $body
     */
    public function enviarEmail($email, $subject, $body)
    {
        return Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['smtpUsername'])
            ->setTo($email)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
    }
}
