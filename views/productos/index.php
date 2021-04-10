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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Producto', ['create'], ['class' => 'btn btn-principal']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'tipo.nombre:text:Tipo',
            'titulo',
            'titulo_original',
            'anyo',
            'duracion',
            'pais',
            'sinopsis:ntext',
            'media:decimal',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'class' => 'table table-responsive'
        ]
    ]); ?>


</div>
