<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$urlAgregar = Url::to(['usuarios-listas/agregar']);
$urlQuitar = Url::to(['usuarios-listas/quitar']);
$urlEliminar = Url::to(['/listas/borrar']);
$js = <<<EOT
    $('.agregar').click(function (ev){
        var el = $(this);
        var lista_id = el.data('key');
        controlListas(lista_id, '$urlAgregar');
    });

    $('.quitar').click(function (){
        var el = $(this);
        var lista_id = el.data('key');
        controlListas(lista_id, '$urlQuitar');
    });

    $('.eliminar').click(function (ev) {
        ev.preventDefault();
        var el = $(this);
        var lista_id = el.data('key');
        controlListas(lista_id, '$urlEliminar');
        return false;
    });
EOT;
$this->registerJs($js);
?>
<div id="listas">

    <?= GridView::widget([
        'dataProvider' => $datos['dataProvider'],
        'columns' => [
            'titulo',
            [
                '__class' => ActionColumn::class,
                'template' => '{agregar} {quitar} {eliminar}',
                'header' => '',
                'buttons' => [
                    'agregar' => function ($url, $model, $key) use ($datos) {
                        $cond = !Yii::$app->user->isGuest && !in_array($key, $datos['listas']);
                        return  $cond ? Html::button('<span class="fas fa-plus"></span>', [
                            'class' => 'btn btn-success agregar',
                            'data-key' => $key,
                        ]) : false;
                    },
                    'quitar' => function ($url, $model, $key) use ($datos) {
                        $cond = !Yii::$app->user->isGuest && in_array($key, $datos['listas']);
                        return  $cond ? Html::button('<span class="fas fa-minus"></span>', [
                            'class' => 'btn btn-danger quitar',
                            'data-key' => $key,
                        ]) : false;
                    },
                    'eliminar' => function ($url, $model, $key) {
                        if (!Yii::$app->user->isGuest) {
                            return  Yii::$app->user->identity->soyAdmin ? Html::button('<span class="fas fa-trash"></span>', [
                                'class' => 'btn btn-danger eliminar',
                                'data-key' => $key,
                                'data-method' => 'POST',
                                'title' => 'Eliminar lista',
                                'data-confirm' => '¿Esta seguro de que quiere eliminar "'. $model->titulo .'"?'
                                ]) : false;
                            }
                        return false;
                    }
                ],
            ],
        ],
    ]); ?>

</div>
