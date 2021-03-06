<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$url = Url::to(['productos/eliminar-premio']);

$js = <<<EOT
$('.eliminar').click(function(ev){
  
    var el = $(this);
    var key = el.data('key');
    $.ajax({
        type: 'POST',
        url: '$url',
        data: {
            id: key
        }
    })
      .done(function(data){
       $('#lista-premios').html(data);
    });
});   
EOT;
$this->registerJs($js);
?>
<div id="lista-premios">
    <?= GridView::widget([
        'dataProvider' => $premios,
       
        'columns' => [
            'header' =>[
                'visible' => false
            ],
            [
                'label' => 'Cantidad',
                'value' => 'cantidad',
                'format' => 'html'
            ],
            [
                'label' => 'Nombre',
                'value' => 'nombre',
                'format' => 'html'
            ],

            [
                '__class' => ActionColumn::class,
                'header' => '',
                'template' => '{eliminar}',
                'buttons' => [
                    'eliminar' => function ($url, $model, $key) {
                        return Html::button('X', [
                            'class' => 'btn btn-danger eliminar',
                            'data-key' => $key,
                            'title' => 'Eliminar premio',
                            'data-confirm' => '¿Está seguro de que quiere eliminar el premio ' . $model->nombre . '?'
                        ]);
                    }
                ],
            ],
        ],
    ]) ?>
</div>
