<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Editar Perfil';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-form">

<?php $form = ActiveForm::begin(); ?>

<?= $this->render('_usuarios-form', [
        'model' => $model,
        'generos' => $generos,
        'form' => $form,
    ]) ?>

<div class="form-group">
    <?= Html::submitButton('Modificar', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
