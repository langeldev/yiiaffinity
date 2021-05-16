<?php


use yii\bootstrap4\Html;
use yii\helpers\Url;

$urlSeguir = Url::to(['/seguidores/seguir']);


$seguidor = !Yii::$app->user->isGuest ? Yii::$app->user->id : null ;

$js = <<<EOT
    $('#seguir').click(function (ev) {
        ev.preventDefault();
        let usuario = $usuario->id;
        let seguidor =  $seguidor;
        $.ajax({    
            type: 'POST',
            url: '$urlSeguir',
            data: {
                usuario_id: usuario,
                seguidor_id: seguidor
            }
        }).done(function(data){
            $('.perfil-usuario').html(data);
        })
        return false;
    });
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
                    <?= Html::button('Añadir a amigos', ['class' => 'btn btn-votar', 'id' => 'seguir']) ?>
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
