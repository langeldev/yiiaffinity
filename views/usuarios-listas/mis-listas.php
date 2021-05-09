<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;



$this->title = 'Mis listas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-right pr-3">
        <?= Html::a('Buscar listas', ['/listas/index']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Listas',
                'value' => function ($model){
                    return Html::a(Html::encode($model->lista->titulo), ['usuarios-listas/view', 'id' => $model->id]);
                },
                'format' => 'html'
    
              ],
   
            [
                '__class' => ActionColumn::class,
                'header' => '',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-minus"></span>', 
                        [
                            'usuarios-listas/delete',
                            'id' => $key
                        ]
                        ,
                        [
                            'class' => 'btn btn-danger',
                            'data-method' => 'POST',
                            'data-confirm' => '¿Desea borrar "' . Html::encode($model->lista->titulo) .
                            '" de sus listas?'
                        ]);
                    },
                ],
            ],
        ],
        'options' => [
            'class' => 'table table-responsive'
        ]
    ]); ?>


</div>
