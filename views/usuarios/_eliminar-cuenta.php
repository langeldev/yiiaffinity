<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

if (!Yii::$app->user->isGuest):

?>
<div class="modal fade" id="modal-borrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Estas seguro de que quiere eliminar su cuenta?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>
        Si continua se borraran todos sus datos, así como todas las valoraciones, las críticas, listas y amigos que hizo.
      </p>
      
      <?php $form = ActiveForm::begin(); ?>
      <?= $form->field($model, 'password_repeat')->passwordInput([
        'id' => 'form-eliminar',
        'maxlength' => true,
        'class' => 'form-control form-style',
        'placeholder' => 'Introducir contraseña'
        ])->label('Si desea continuar por favor introduzca su contraseña:', ['class' => 'eliminar-label']) ?>
      <div class="form-group text-right py-3">
        <button type="button" class="btn btn-azul bg-secondary" data-dismiss="modal">Cancelar</button>
        <?= Html::submitButton('Eliminar cuenta', [
            'class' => 'btn btn-eliminar',
            'disabled' => true,
            'id' => 'btn-elimar-cuenta'
        ]) ?>
      </div>
    <?php ActiveForm::end(); ?>
      </div>
      
    </div>
  </div>
</div>

<?php endif ?>
