<?= $form->field($model, 'login')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

<?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

<?= $form->field($model, 'anyo_nac')->textInput(['class' => 'form-control form-style']) ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control  form-style']) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true, 'class' => 'form-control  form-style']) ?>


<div class="d-flex row">
    <div class="col-6">
        <?= $form->field($model, 'genero')->dropdownList($generos, ['prompt' => 'Seleccione', 'class' => 'form-control  col-12 form-style']) ?>
    </div>
    <?php if (!Yii::$app->user->isGuest) : ?>
        <?php if (Yii::$app->user->identity->soyAdmin) : ?>
            <div class="col-6">
                <?= $form->field($model, 'rol_id')->dropdownList($roles, ['class' => 'form-control  col-12 form-style']) ?>
            </div>
        <?php endif ?>
    <?php endif ?>
</div>


<?= $form->field($model, 'pais')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

<?= $form->field($model, 'ciudad')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>
