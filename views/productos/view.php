<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="productos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'titulo',
            'titulo_original',
            'anyo',
            [
                'label' => 'Duración',
                'value' => Html::encode($model->duracion . ' min')
         
            ],
            'tipo.nombre:text:Tipo',
            'pais',
            [
                'label' => 'Dirección',
                'value' => Html::encode(implode(' ', $direccion))
         
            ],
            [
                'label' => 'Guion',
                'value' => Html::encode(implode(' ', $guion))
         
            ],
            [
                'label' => 'Musica',
                'value' => Html::encode(implode(' ', $musica))
         
            ],
            [
                'label' => 'Fotografía',
                'value' => Html::encode(implode(' ', $fotografia))
         
            ],
            [
                'label' => 'Reparto',
                'value' => Html::encode(implode(' ', $reparto))
         
            ],
            [
                'label' => 'Productora',
                'value' => Html::encode(implode(' ', $productora))
         
            ],
            [
                'label' => 'Genero',
                'value' => Html::encode(implode(' ', $generos))
         
            ],
            'sinopsis:ntext',
            'media:decimal'
        ],
    ]) ?>
<?= GridView::widget([
    'dataProvider' => $premios,
    'columns' => [
        'cantidad',
        'nombre:text:Premio'
    ]
]) ?>

</div>
