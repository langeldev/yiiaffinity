<?php

namespace app\controllers;

use app\models\Criticas;
use app\models\Generos;
use app\models\ListasProductos;
use app\models\Personas;
use app\models\Premios;
use app\models\Productoras;
use Yii;
use app\models\Productos;
use app\models\ProductosDirectores;
use app\models\ProductosFotografia;
use app\models\ProductosGeneros;
use app\models\ProductosGuionistas;
use app\models\ProductosInterpretes;
use app\models\ProductosMusica;
use app\models\ProductosProductoras;
use app\models\ProductosSearch;
use app\models\Tipos;
use app\models\UsuariosListas;
use app\models\Valoraciones;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductosController implements the CRUD actions for Productos model.
 */
class ProductosController extends Controller
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
                    'eliminar-premio' => ['POST'],
                    'agregar-premio' => ['POST'],

                ],
            ],'access' => [
                '__class' => AccessControl::class,
                'only' => [
                             'index'
                           , 'create'
                           , 'update'
                           , 'delete'
                           , 'view'
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
                ],
            ],
        ];
    }

    /**
     * Lists all Productos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSearch($search)
    {
        if (Yii::$app->request->isAjax) {
            $search = Yii::$app->request->get('search');
          
            $productos = Productos::find()->where(['ilike', 'titulo', $search])->all();
            return $this->asJson(['productos' => $productos]);
        }
    }

    /**
     * Displays a single Productos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $direccion =$this->getRelacion($model->getDirectores());
        $guion = $this->getRelacion($model->getGuion());
        $musica = $this->getRelacion($model->getMusica());
        $fotogrtafia = $this->getRelacion($model->getFotografia());
        $reparto = $this->getRelacion($model->getInterpretes());
        $productora = $this->getRelacion($model->getProductoras());
        $generos = $this->getRelacion($model->getGeneros());
        $premio = new Premios(['producto_id' => $id]);
        $premios = new ActiveDataProvider([
            'query' => $model->getPremios(),
        ]);

    
        return $this->render('view', [
            'model' => $model,
            'direccion' => $direccion,
            'guion' => $guion,
            'musica' => $musica,
            'fotografia' => $fotogrtafia,
            'reparto' => $reparto,
            'productora' => $productora,
            'generos' => $generos,
            'premios' => $premios,
            'premio' => $premio
            ]);
    }


    public function actionFicha($id)
    {
        $model = $this->findModel($id);
        $miCritica = Criticas::findOne([
            'usuario_id' => Yii::$app->user->id,
            'producto_id' => $model->id]);
        $criticas = Criticas::find()->where([
            'producto_id' => $model->id
            ])->andFilterWhere([
                'not in', 'usuario_id', Yii::$app->user->id
            ])->orderBy([
                'created_at' => \SORT_DESC
            ])->limit(3)
            ->all();

        $miValoracion = $this->obtenerValoracion($id);
        $misListas = UsuariosListas::misListas($model->id);
        $productoLista = new ListasProductos(['producto_id' => $id]);
        return $this->render('ficha', [
           'model' => $model,
           'miCritica' => $miCritica,
           'criticas' => $criticas,
           'miValoracion' => $miValoracion,
           'lista' => Valoraciones::listaPuntos(),
           'productoLista' => $productoLista,
           'misListas' => $misListas,
        ]);
    }
    /**
     * Elimina los premios
     * @return mixed
     */
    public function actionEliminarPremio()
    {
        if (Yii::$app->request->isAjax) {
            $premio  = Premios::findOne(
                Yii::$app->request->post('id')
            );
            $model = $this->findModel($premio->producto_id);
            $premio->delete();
            $premios =    $premios = new ActiveDataProvider([
              'query' => $model->getPremios(),
            ]);
            return $this->renderAjax('_lista-premios', ['premios' => $premios]);
        }
    }

    /**
    * Agrega los premios
    * @return mixed
    */
    public function actionAgregarPremio()
    {
        if (Yii::$app->request->isAjax) {
            $datos = Yii::$app->request->post('Premios');
            $premio = new Premios([
                'producto_id' => $datos['producto_id'],
                'nombre' => $datos['nombre'],
                'cantidad' => $datos['cantidad']
                ]);
            $premio->save();
            $model = $this->findModel($premio->producto_id);
            $premios = $premios = new ActiveDataProvider([
               'query' => $model->getPremios(),
            ]);
            return $this->renderAjax('_lista-premios', ['premios' => $premios]);
        }
    }

     
    /**
     * Creates a new Productos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Productos();
        
        if ($model->load($producto = Yii::$app->request->post())) {
            $model->cartel = UploadedFile::getInstance($model, 'cartel');
            $model->upload();

            if ($model->save()) {
                if ($producto['directores'] !== '') {
                    $this->relDirectores($model->id, $producto['directores']);
                }
                if ($producto['guionistas'] !== '') {
                    $this->relGuionistas($model->id, $producto['guionistas']);
                }
                if ($producto['musica'] !== '') {
                    $this->relMusica($model->id, $producto['musica']);
                }
                if ($producto['fotografia'] !== '') {
                    $this->relFotografia($model->id, $producto['fotografia']);
                }
                if ($producto['interpretes'] !== '') {
                    $this->relInterpretes($model->id, $producto['interpretes']);
                }
                if ($producto['productoras'] !== '') {
                    $this->relProductoras($model->id, $producto['productoras']);
                }
                if ($producto['generos'] !== '') {
                    $this->relGeneros($model->id, $producto['generos']);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'tipos' => Tipos::lista(),
            'personas' => Personas::lista(),
            'productoras' => Productoras::lista(),
            'generos' => Generos::lista(),
        ]);
    }

    /**
     * Updates an existing Productos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       
        if ($model->load($producto = Yii::$app->request->post())) {
            if ($model->cartel !== null) {
                $model->borrarCartel();
                $model->cartel = UploadedFile::getInstance($model, 'cartel');
                $model->upload();
            }

            if ($model->save()) {
                ProductosDirectores::deleteAll(['producto_id'=> $model->id]);
                ProductosGuionistas::deleteAll(['producto_id'=> $model->id]);
                ProductosMusica::deleteAll(['producto_id'=> $model->id]);
                ProductosFotografia::deleteAll(['producto_id'=> $model->id]);
                ProductosInterpretes::deleteAll(['producto_id'=> $model->id]);
                ProductosProductoras::deleteAll(['producto_id'=> $model->id]);
                ProductosGeneros::deleteAll(['producto_id'=> $model->id]);

                if ($producto['directores'] !== '') {
                    $this->relDirectores($model->id, $producto['directores']);
                }
                if ($producto['guionistas'] !== '') {
                    $this->relGuionistas($model->id, $producto['guionistas']);
                }
                if ($producto['musica'] !== '') {
                    $this->relMusica($model->id, $producto['musica']);
                }
                if ($producto['fotografia'] !== '') {
                    $this->relFotografia($model->id, $producto['fotografia']);
                }
                if ($producto['interpretes'] !== '') {
                    $this->relInterpretes($model->id, $producto['interpretes']);
                }
                if ($producto['productoras'] !== '') {
                    $this->relProductoras($model->id, $producto['productoras']);
                }
                if ($producto['generos'] !== '') {
                    $this->relGeneros($model->id, $producto['generos']);
                }
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tipos' => Tipos::lista(),
            'personas' => Personas::lista(),
            'productoras' => Productoras::lista(),
            'generos' => Generos::lista(),
        ]);
    }

    /**
     * Deletes an existing Productos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->borrarCartel();
        $model->delete();

        return $this->redirect(['index']);
    }

 
    /**
     * Finds the Productos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Productos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Productos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function relDirectores($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosDirectores([
                'producto_id' => $id,
                'persona_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function relGuionistas($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosGuionistas([
                'producto_id' => $id,
                'persona_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function relMusica($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosMusica([
                'producto_id' => $id,
                'persona_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function relFotografia($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosFotografia([
                'producto_id' => $id,
                'persona_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function relInterpretes($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosInterpretes([
                'producto_id' => $id,
                'persona_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function relProductoras($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosProductoras([
                'producto_id' => $id,
                'productora_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function relGeneros($id, $valores)
    {
        foreach ($valores as $v) {
            $relacion = new ProductosGeneros([
                'producto_id' => $id,
                'genero_id' => $v
            ]);
            $relacion->save();
        }
    }

    private function getRelacion($rel)
    {
        return $rel->select('nombre')->column();
    }

    private function obtenerValoracion($producto_id)
    {
        $valoracion = Valoraciones::findOne([
            'producto_id' => $producto_id,
            'usuario_id' => Yii::$app->user->id,
        ]);

        return $valoracion !== null ? $valoracion : new Valoraciones();
    }
}
