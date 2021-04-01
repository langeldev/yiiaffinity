<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$js = <<<EOT
    $("#directores").select2({
        theme: "classic"
    });

    $("#guionistas").select2({
        theme: "classic"
    });

    $("#musica").select2({
        theme: "classic"
    });

    $("#fotografia").select2({
        theme: "classic"
    });

    $("#interpretes").select2({
        theme: "classic"
    });

    $("#productoras").select2({
        theme: "classic"
    });

    $("#generos").select2({
        theme: "classic"
    });
EOT;
$this->registerJs($js);
?>

<div class="productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulo_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anyo')->textInput() ?>

    <?= $form->field($model, 'duracion')->textInput() ?>

    <?= $form->field($model, 'tipo_id')->dropdownList($tipos) ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sinopsis')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'directors')->dropdownList($directores, [
                    'id' => 'directores',
                    'name' => 'directores',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>

    <?= $form->field($model, 'guions')->dropdownList($guionistas, [
                    'id' => 'guionistas',
                    'name' => 'guionistas',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>


    <?= $form->field($model, 'musicas')->dropdownList($musica, [
                    'id' => 'musica',
                    'name' => 'musica',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>


    <?= $form->field($model, 'fotografias')->dropdownList($fotografia, [
                    'id' => 'fotografia',
                    'name' => 'fotografia',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>

    <?= $form->field($model, 'interpretes')->dropdownList($reparto, [
                    'id' => 'interpretes',
                    'name' => 'interpretes',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>


    <?= $form->field($model, 'productoras')->dropdownList($productoras, [
                    'id' => 'productoras',
                    'name' => 'productoras',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>


    <?= $form->field($model, 'generos')->dropdownList($generos, [
                    'id' => 'generos',
                    'name' => 'generos',
                    'class'=> 'js-example-basic-multiple js-states form-control',
                    'multiple' => 'multiple',
                    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
