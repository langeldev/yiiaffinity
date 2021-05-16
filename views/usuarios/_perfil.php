<?php

use yii\bootstrap4\Html;
?>
<div class="row p-2">
    <div class="col-12 text-right">
        <?php if (!Yii::$app->user->isGuest):  ?>
            <?php if ($usuario->id === Yii::$app->user->id):  ?>
                <?= Html::a('Editar datos', ['/usuarios/editar-perfil'],['class' => 'btn btn-principal']) ?>
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
