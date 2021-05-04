<?php

namespace app\controllers;

use Yii;

use app\models\ListasSearch;
use app\models\UsuariosListas;
use yii\web\Controller;
use yii\filters\VerbFilter;

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
                    'delete' => ['POST'],
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
        
        $searchModel = new ListasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $datos = [
            'searhModel' => $searchModel,
            'dataProvider' => $dataProvider];
        if (!Yii::$app->user->isGuest) {
            $datos += [
                'listas' => UsuariosListas::find()
                ->select('lista_id')
                ->where([
                    'usuario_id' => Yii::$app->user->id])
                    ->column()
                ];
        }
        return $this->render('index', ['datos' => $datos]);
    }
}
