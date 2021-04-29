<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ListasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'titulo',
        ],
    ]); ?>

</div>
