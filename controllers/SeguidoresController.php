<?php

namespace app\controllers;

use Yii;
use app\models\Seguidores;
use app\models\SeguidoresSearch;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeguidoresController implements the CRUD actions for Seguidores model.
 */
class SeguidoresController extends Controller
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
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' =>  ['mis-amigos', 'seguir', 'borrar'],
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }

  /**
     * El usuario puede registrarse.
     *
     * @return mixed
     */
    public function actionMisAmigos()
    {
        $searchModel = new UsuariosSearch();
        $amigos = $searchModel->searchMisAmigos(Yii::$app->request->queryParams);

        return $this->render('mis-amigos', [
            'amigos' => $amigos,
            'model' => $searchModel
        ]);
    }

    /**
     * Crea una nueva amistad
     *
     * @return mixed
     */
    public function actionSeguir()
    {
        if (Yii::$app->request->isAjax) {
            $usuario_id = Yii::$app->request->post('usuario_id');
            $seguidor = Yii::$app->request->post('seguidor_id');
            $usuario = Usuarios::findOne($usuario_id);
            $model = new Seguidores(['usuario_id' => $usuario_id, 'seguidor_id' => $seguidor]);
            if ($model->save()) {
                return $this->renderAjax('/usuarios/_perfil', ['usuario' => $usuario]);
            }
        }
    }

    /**
    * Elimina la amistad
    *
    * @return mixed
    */
    public function actionBorrar()
    {
        if (Yii::$app->request->isAjax) {
            $usuario_id = Yii::$app->request->post('usuario_id');
            $seguidor = Yii::$app->request->post('seguidor_id');
            $usuario = Usuarios::findOne($usuario_id);
            $this->findModel($usuario_id, $seguidor)->delete();
            return $this->renderAjax('/usuarios/_perfil', ['usuario' => $usuario]);
        }
    }

    /**
     * Finds the Seguidores model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $usuario_id
     * @param integer $seguidor_id
     * @return Seguidores the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($usuario_id, $seguidor_id)
    {
        if (($model = Seguidores::findOne(['usuario_id' => $usuario_id, 'seguidor_id' => $seguidor_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
