<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Criticas */

if ($model->isNewRecord) {

    $this->title = 'Hacer crítica';
} else {
    $this->title = 'Modificar crítica';
}

$this->params['breadcrumbs'][] = ['label' => Html::encode($model->producto->titulo), 'url' => ['productos/ficha', 'id' => $model->producto->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">
    <div class="col-12 critica-form">

        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>


        <?php $form = ActiveForm::begin(); ?>
        <div class="col-12 py-5 px-0">

            <div class="dato-producto row pb-5">

                <div class="row col-12 col-md-9 m-0">
                    <div class="p-0 text-center col-12 col-md-3">
                        <?= Html::img($producto->getImagen(), ['class' => 'img-fluid', 'id' => 'cartel', 'itemprop' => 'image']) ?>
                    </div>
                    <div class="col-12 col-md-9 p-2">
                        <h2 class="text-center text-md-left pt-3 titulo-critica-prod"><?= Html::encode($producto->titulo) ?> <span class="anyo-prod">(<?= Html::encode($producto->anyo) ?>)</span></h2>
                        <div class="row col-12 media-voto-critica m-0 p-0">
                            <span class="media">
                                <?= Html::encode(number_format(Html::encode($producto->mediaCriticas), 1, ",", "")) ?>
                            </span>
                            <span class="total">
                                <?= Html::encode($producto->criticasTotales) ?> <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <?php if (count($producto->directores) > 0) : ?>
                            <p>
                                <?php foreach ($producto->directores as $key => $director) : ?>
                                    <?= "<span>" . Html::encode($director->nombre) .
                                        ($key + 1 < count($producto->directores) ? "</span>," : "</span>")
                                    ?>
                                <?php endforeach ?>
                            </p>
                        <?php endif ?>
                        <?php if (count($producto->interpretes) > 0) : ?>
                  
                    <p>
                        <?php foreach ($producto->interpretes as $key => $reparto) : ?>
                            <?= "<span>" . Html::encode($reparto->nombre) .
                                ($key + 1 < count($producto->interpretes) && $key < 9  ? "</span>," : "</span>")
                            ?>
                            <?php if ($key > 8) {
                             break;   
                            }?>
                        <?php endforeach ?>
                    </p>
                <?php endif ?>
                    </div>
                </div>
                <div class="offset-9 offset-md-0 col-3 text-center">
                <?= $form->field($model, 'valoracion')->dropdownList(
                    $puntosValoracion,
                    [
                        'prompt' => '-',
                        'class' => 'col-12   form-control form-style p-0
                        '
                        ]
                        )
                        ->label('Tu voto') ?>
                        </div>
            </div>

            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'critica')->textarea(['rows' => 6, 'class' => 'form-control form-style']) ?>


            <div class="form-group text-right">
                <?= Html::submitButton('Enviar', ['class' => 'btn btn-principal']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
