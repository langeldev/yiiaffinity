<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$urlEliminar = Url::to(['/usuarios-listas/delete']);

$js = <<<EOT
$('.eliminar').click(function (ev) {
    ev.preventDefault();
    var el = $(this);
    var lista_id = el.data('key');
    var titulo = el.data('titulo');
    var confirmado = confirm('¿Estás seguro que quiere eliminar "' + titulo + '"?');
    if (confirmado) {
    $.ajax({
        type: 'POST',
        url: '$urlEliminar',
        data: {
            lista_id: lista_id
        },
        success: function(data){
            if (data.titulo == titulo){
                el.parents('tr').fadeOut('normal', function (event) {
                    $(this).remove();
                });
           }
        }
    });
}
   return false;
});

EOT;

$this->registerJs($js);
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
                            if (!Yii::$app->user->isGuest) {
                                if ($model->usuario_id === Yii::$app->user->id) {
                                    return Html::button('<span class="fas fa-minus"></span>', [
                                        'class' => 'btn btn-danger eliminar',
                                        'data-key' => $key,
                                        'data-method' => 'POST',
                                        'title' => 'Eliminar de mis listas',
                                        'data-titulo' => $model->lista->titulo
                                    ]);
                                }
                            }
                            return false;
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
