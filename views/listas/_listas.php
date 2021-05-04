<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$urlAgregar = Url::to(['usuarios-listas/agregar']);
$urlQuitar = Url::to(['usuarios-listas/quitar']);
$js = <<<EOT
    $('.agregar').click(function (ev){
        ev.preventDefault();
        let el = $(this);
        let lista_id = el.data('key');
        $.ajax({
            type: 'POST',
            url: '$urlAgregar',
            data: {
                lista_id: lista_id
            }
        }).done(function(data){
            $('#listas').html(data);
        });
        return false;
    });

    $('.quitar').click(function (){
        let el = $(this);
        let lista_id = el.data('key');
        $.ajax({
            type: 'POST',
            url: '$urlQuitar',
            data: {
                lista_id: lista_id
            }
        }).done(function(data){
            $('#listas').html(data);
        });
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
                    'template' => '{agregar} {quitar}',
                    'header' => '',
                    'buttons' => [
                    'agregar' => function ($url, $model, $key) use($datos){
                        $cond = !Yii::$app->user->isGuest && !in_array($key, $datos['listas']);
                        return  $cond ? Html::button('<span class="fas fa-plus"></span>', [
                            'class' => 'btn btn-success agregar',
                            'data-key' => $key,
                            ]) : false;
                        },
                        'quitar' => function ($url, $model, $key) use($datos){
                            $cond = !Yii::$app->user->isGuest && in_array($key, $datos['listas']);
                            return  $cond ? Html::button('<span class="fas fa-minus"></span>', [
                                'class' => 'btn btn-danger quitar',
                                'data-key' => $key,
                                ]) : false;
                            }
                ],
            ],
        ],
        ]); ?>

</div>
