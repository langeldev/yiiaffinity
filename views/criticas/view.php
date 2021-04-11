<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Criticas */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Criticas' , 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="criticas-view">

    <h1><?= Html::encode($this->title) ?></h1>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'producto.titulo',
            'usuario.nombre',
            'valoracion',
            'titulo',
            'critica:ntext',
            'created_at:date',
        ],
    ]) ?>

</div>
