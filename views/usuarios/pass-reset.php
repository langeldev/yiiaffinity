<?php


use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Restablecimiento de  contraseña';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="site-login m-md-5 mx-0 row rounded">
    <div class="col-12 col-md-6 formulario ">

        <h1 class="text-center my-4"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>
        
        <p class="p-2 mb-5">
            Introduce tu nueva contraseña.
        </p>
        <div class="icon-group">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña', 'autofocus' => true])->label(false) ?>
            <i class="fas fa-lock"></i>
        </div>
        
        <div class="icon-group">
            <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Repetir contraseña', 'autofocus' => true])->label(false) ?>
            <i class="fas fa-lock"></i>
        </div>

        <div class="form-group">
            <div class="text-right">
                <?= Html::submitButton('Restablecer', ['class' => 'btn btn-principal col-12 col-lg-4 mt-3']) ?>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-12 col-md-6 imagen-login">
          
    </div>

</div>
