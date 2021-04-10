<?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'anyo_nac')->textInput() ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'genero')->dropdownList($generos, ['prompt' => 'Seleccione']) ?>

<?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'ciudad')->textInput(['maxlength' => true]) ?>
