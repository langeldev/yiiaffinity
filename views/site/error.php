<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="fondo p-2">
<div class="col-12">
    <h1 class="text-center text-md-left h1 border-0""><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        El error anterior ocurrió mientras el servidor web procesaba su solicitud.
    </p>
    <p>
        Comuníquese con nosotros si cree que se trata de un error del servidor. Gracias.
    </p>

    </div>
</div>
