<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CriticasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Criticas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="criticas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'producto.titulo',
            'usuario.login',
            'valoracion',
            'titulo',
            'critica:ntext',
            'created_at:date',
        ],
    ]); ?>


</div>
