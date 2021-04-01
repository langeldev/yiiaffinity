<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */


use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$css = "
body{
    background-color: #0f49b9;
    background-image: linear-gradient(40deg, #0f49b9, #38c0e7);
    background-image: -moz-linear-gradient(40deg, #0f49b9, #38c0e7);;
    background-image: -o-linear-gradient(40deg, #0f49b9, #38c0e7);
    background-image: -webkit-linear-gradient(40deg, #0f49b9, #38c0e7);
    background-attachment: fixed;
}

";


$this->registerCss($css);
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="site-login m-5 row rounded">
    <div class="col-12 col-md-6 formulario ">

        <h1 class="text-center my-4"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
        ]); ?>

            <div class="icon-group">
                <?= $form->field($model, 'username')->textInput(['placeholder' => 'Usuario', 'autofocus' => true])->label(false) ?>
                <i class="fas fa-user"></i>
            </div>
            <div class="icon-group">   
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña'])->label(false) ?>
                <i class="fas fa-lock"></i>
            </div>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <div class="text-center">
                <?= Html::submitButton('Login', ['class' => 'btn btn-login col-12 col-lg-4 mt-3', 'name' => 'login-button']) ?>
                <?= Html::a('Registrarse', ['usuarios/registro'], ['class' => 'btn btn-login col-12 col-lg-4 mt-3']) ?>
            </div>

        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-12 col-md-6 imagen-login">
          
    </div>

</div>
