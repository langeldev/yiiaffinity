<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Criticas */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => $model->producto->titulo , 'url' => ['productos/ficha', 'id' => $model->producto_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="criticas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest) : ?>
                        <?php if ($model->usuario_id === Yii::$app->user->id) : ?>
                            <div>
                                <?= Html::a('Eliminar', ['criticas/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-eliminar',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quiere borrar la crítica?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                                <?= Html::a('Modificar', ['criticas/update', 'id' => $model->producto_id], [
                                            'class' => 'btn btn-votar',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                ]) ?>
                            </div>
                            <?php endif ?> <?php endif ?>
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
