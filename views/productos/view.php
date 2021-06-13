<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$url = Url::to(['productos/agregar-premio']);
$producto_id = $model->id;

$js = <<<EOT
$('#agregar-premio').click(function(ev){
    ev.preventDefault();
    let producto_id = $producto_id;
    let cantidad = $.trim($('#premios-cantidad').val());
    let nombre = $.trim($('#premios-nombre').val());

    if (cantidad != '' && nombre != '') {
        $.ajax({
            type: 'POST',
            url: '$url',
            data: {
                Premios: {
                    producto_id: producto_id,
                    nombre: nombre,
                    cantidad: cantidad
                }
            }
        })
        .done(function(data){
            $('#form-premios')[0].reset();
            $('#lista-premios').html(data);
        });
    }
    return false;
});   
EOT;
$this->registerJs($js);
?>
<div class="fondo p-2">
    <div class="col-12">

        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>

        <p class="text-right my-3">
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-principal']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-eliminar',
                'data' => [
                    'confirm' => '¿Estás seguro de que quiere borrar este producto?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Cartel',
                    'value' => Html::img($model->getImagen(), ['class' => 'img-fluid']),
                    'format' => 'html'

                ],
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
                    'value' => Html::encode(implode(', ', $direccion))

                ],
                [
                    'label' => 'Guion',
                    'value' => Html::encode(implode(', ', $guion))

                ],
                [
                    'label' => 'Música',
                    'value' => Html::encode(implode(', ', $musica))

                ],
                [
                    'label' => 'Fotografía',
                    'value' => Html::encode(implode(', ', $fotografia))

                ],
                [
                    'label' => 'Reparto',
                    'value' => Html::encode(implode(', ', $reparto))

                ],
                [
                    'label' => 'Productora',
                    'value' => Html::encode(implode(', ', $productora))

                ],
                [
                    'label' => 'Géneros',
                    'value' => Html::encode(implode(', ', $generos))

                ],
                'sinopsis:ntext',
                'media:decimal'
            ],
        ]) ?>

        <h2 class="text-center text-md-left h2">Premios</h2>
        <div class="premios-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form-premios',
            ]) ?>

        <?= $form->field($premio, 'cantidad')->textInput(['class' => 'form-control form-style'])  ?>

        <?= $form->field($premio, 'nombre')->textInput(['class' => 'form-control form-style']) ?>

        <div  class="text-right my-3">
            <?= Html::submitButton('Añadir', ['id' => 'agregar-premio', 'class' => 'btn btn-principal']) ?>
        </div>

        <?php ActiveForm::end() ?>
            </div>


        <?= $this->render('_lista-premios', ['premios' => $premios]) ?>

    </div>
</div>
