<?php


use yii\bootstrap4\Html;
use yii\helpers\Url;

$urlSeguir = Url::to(['/seguidores/seguir']);
$urlNoSeguir = Url::to(['/seguidores/borrar']);

$seguidor = !Yii::$app->user->isGuest ? Yii::$app->user->id : -1;

$js = <<<EOT
var usuario = $usuario->id;
var seguidor =  $seguidor;
if (seguidor != -1){
    $('#seguir').click(function (ev) {
        controlSeguir(usuario, seguidor, '$urlSeguir');
    });

    $('#no-seguir').click(function (ev) {
        controlSeguir(usuario, seguidor, '$urlNoSeguir');
    });
}
EOT;
$this->registerJs($js);
?>
<div class="row p-2">
    <div class="col-12 text-right">
        <?php if (!Yii::$app->user->isGuest):  ?>
            <?php if ($usuario->id === Yii::$app->user->id):  ?>
                <?= Html::a('Editar datos', ['/usuarios/editar-perfil'],['class' => 'btn btn-principal']) ?>
            <?php else:?>
                <?php if(!$usuario->seguido): ?>
                    <?= Html::button('Añadir a amigos', ['class' => 'btn btn-azul', 'id' => 'seguir']) ?>
                <?php else: ?>
                    <?= Html::button('Eliminar de amigos', ['class' => 'btn btn-azul', 'id' => 'no-seguir']) ?>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>
    </div>
    <div class="col-12 text-center">

        <i class="fa fa-user"></i>
        <h4 class="usuario-critica"><?= Html::encode($usuario->login) ?></h4>
        <span class="localidad">

            <?php        if ($usuario->ciudad || $usuario->pais) {
        echo $usuario->ciudad
        ? Html::encode($usuario->ciudad)
        : '';
        echo $usuario->pais
        ? ' (' . Html::encode($usuario->pais) . ')'
        : '';
    }
    ?>
    </span>
</div>
</div>
