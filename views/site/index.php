<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'YiiAffinity';

?>
<div class="fondo p-2">
    <div class="row p-0 m-0">
        <section class="body-content col-12 my-0">
            <h1 class="text-center text-md-left h1">Cartelera</h1>
            <?= $this->render('/productos/_productos', [
            'productos' => $productos,
        ]) ?>
        </section>
    </div>
</div>
