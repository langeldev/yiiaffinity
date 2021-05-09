<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$urlAgregarLista = Url::to(['/listas-productos/agregar']);

$js = <<<EOT
$('#listas').change(function (ev){
    ev.preventDefault();
    let lista = $(this).val();
    if(lista != ''){
    $.ajax({
        type: 'POST',
        url: '$urlAgregarLista',
        data: {
            lista_id: lista,
            producto_id: $producto
        }
    }).done(function(data){
        let listas = $('#listas');
        var options = '<option value>Añadir a lista</option>';
        for (const prop in data.misListas) {
            options += '<option value="' + prop + '">'+data.misListas[prop]+'</option>';
        }
        listas.html(options);
        $(this).prop('disabled', false);
    })
}
return false;
});
EOT;
$this->registerJs($js);
?>

<div class="valoraciones-form">

    <?php $form = ActiveForm::begin([
'successCssClass' => false,

    ]); ?>


    <?= $form->field($productoLista, 'lista_id')->dropdownList($misListas, [
    'prompt' => 'Añadir a lista',
    'class' => 'form-control valoracion-form',
    'id' => 'listas'
    ])->label(false)?>


    <?php ActiveForm::end(); ?>

</div>
