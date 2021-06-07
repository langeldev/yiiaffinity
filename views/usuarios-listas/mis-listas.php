<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;


$this->title = 'Mis listas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">
    <div class="col-12">


        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>

        <div class="my-3 text-right">
            <?= Html::a('Buscar listas', ['/listas/index'], ['class' => 'btn btn-azul']) ?>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>


        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'label' => 'Listas',
                    'value' => function ($model) {
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
                            return Html::a(
                                '<span class="fas fa-minus"></span>',
                                [
                                    'usuarios-listas/delete',
                                    'id' => $key
                                ],
                                [
                                    'class' => 'btn btn-danger',
                                    'data-method' => 'POST',
                                    'title' => 'Eliminar de mis listas',
                                    'data-confirm' => '¿Desea borrar "' . Html::encode($model->lista->titulo) .
                                        '" de sus listas?'
                                ]
                            );
                        },
                    ],
                ],
            ],
            'options' => [
                'class' => 'table table-responsive',
                'id' => 'table-listas'
            ]
        ]); ?>


    </div>
</div>
