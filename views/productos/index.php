<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">
    <div class="col-12">

        
        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
        
        <p class="text-right my-3">
            <?= Html::a('Crear Producto', ['create'], ['class' => 'btn btn-principal']) ?>
        </p>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
            'columns' => [
                [
                    'label' => 'Cartel',
                    'value' => function($model, $key){
                        return Html::img($model->getImagen(), ['class' => 'img-fluid']);
                    },
                    'format' => 'html',
                ],
                'tipo.nombre:text:Tipo',
                'titulo',
                'titulo_original',
                'anyo',
                'duracion',
                'pais',
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'options' => [
                'class' => 'table table-responsive'
                ]
            ]); ?>

</div>

</div>
