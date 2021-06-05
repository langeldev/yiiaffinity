<?php


use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

/*
if (data.lista_id == lista_id){
    
*/
$urlAgregar = Url::to(['/usuarios-listas/agregar']);
$urlQuitar = Url::to(['/usuarios-listas/quitar']);
$urlEliminar = Url::to(['/listas/borrar']);
$js = <<<EOT
    $('.agregar').click(agregarLista);

    $('.quitar').click(quitarLista);

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
                if (data.lista_id == lista_id){
                    el.parents('tr').fadeOut('normal', function (event) {
                        $(this).remove();
                    });
               }
            }
        });
    }
    
       return false;
    });

    function agregarLista(){
        var el = $(this);
        var id = el.data('key');
        $.ajax({
            type: 'POST',
            url: '$urlAgregar',
            data: {
                lista_id: id
            },
            success: function(data){
                if (data.lista_id == id){
                    var conf = {
                        simbolo: '<span class="fas fa-minus"></span>',
                        titulo: 'Quitar de mis listas',
                        color: 'danger',
                        accion: quitarLista
                    }
                    cambiarBoton(el, conf);
               }
            }
        });
    }

    function quitarLista(){
        var el = $(this);
        var id = el.data('key');
        $.ajax({
            type: 'POST',
            url: '$urlQuitar',
            data: {
                lista_id: id
            },
            success: function(data){
                if (data.lista_id == id){
                    var conf = {
                        simbolo: '<span class="fas fa-plus"></span>',
                        titulo: 'Agregar a mis listas',
                        color: 'success',
                        accion: agregarLista
                    }
                    cambiarBoton(el, conf);
               }
            }
        });
    }

    
EOT;
$this->registerJs($js);
$this->title = 'Listas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">
    <div class="col-12">
        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
        <div class="my-3 text-right">
            <?= Html::a('Mis listas', ['usuarios-listas/mis-listas'], ['class' => 'btn btn-azul']) ?>
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?php if (Yii::$app->user->identity->soyAdmin) : ?>
                    <?= Html::a('Crear', ['create'], ['class' => 'btn btn-principal']) ?>
                <?php endif ?>
            <?php endif ?>
            <?php echo $this->render('_search', ['model' => $datos['searhModel']]); ?>
        </div>

        <?php if (!Yii::$app->user->isGuest) : ?>
        <?php endif ?>
        <div id="listas">


            <?= GridView::widget([
                'dataProvider' => $datos['dataProvider'],
                'columns' => [
                    'titulo',
                    [
                        '__class' => ActionColumn::class,
                        'template' => '{agregar} {quitar} {modificar} {eliminar}',
                        'header' => '',
                        'buttons' => [
                            'agregar' => function ($url, $model, $key) use ($datos) {
                                $cond = !Yii::$app->user->isGuest && !in_array($key, $datos['listas']);
                                return  $cond ? Html::button('<span class="fas fa-plus"></span>', [
                                    'class' => 'btn btn-success agregar',
                                    'data-key' => $key,
                                    'title' => 'Agregar a mis listas',
                                ]) : false;
                            },
                            'quitar' => function ($url, $model, $key) use ($datos) {
                                $cond = !Yii::$app->user->isGuest && in_array($key, $datos['listas']);
                                return  $cond ? Html::button('<span class="fas fa-minus"></span>', [
                                    'class' => 'btn btn-danger quitar',
                                    'data-key' => $key,
                                    'title' => 'Quitar de mis listas',
                                ]) : false;
                            },
                            'modificar' => function ($url, $model, $key) {
                                if (!Yii::$app->user->isGuest) {
                                    return  Yii::$app->user->identity->soyAdmin ? Html::a(
                                        '<span class="fas fa-pen-alt"></span>',
                                        ['/listas/update', 'id' => $key],
                                        [
                                            'class' => 'btn btn-info',
                                            'title' => 'Modificar lista',
                                        ]
                                    ) : false;
                                }
                                return false;
                            },
                            'eliminar' => function ($url, $model, $key) {
                                if (!Yii::$app->user->isGuest) {
                                    return  Yii::$app->user->identity->soyAdmin ? Html::button('<span class="fas fa-trash"></span>', [
                                        'class' => 'btn btn-danger eliminar',
                                        'data-key' => $key,
                                        'data-method' => 'POST',
                                        'title' => 'Eliminar lista',
                                        'data-titulo' => $model->titulo
                                    ]) : false;
                                }
                                return false;
                            }
                        ],
                    ],
                ],
            ]); ?>

        </div>

    </div>
</div>
