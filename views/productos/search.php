<?php

/* @var $this yii\web\View */

use yii\bootstrap4\LinkPager;

$this->title = 'Búsqueda de "' .  $_GET['search'] . '"' ;


$confPager = [
    'pagination' => $pagination,
    'maxButtonCount' => 3,
    'firstPageLabel' => true,
    'lastPageLabel' => true,
];
?>
<div class="fondo p-2">
    <div class="row p-0 m-0">
        <section class="body-content col-12 my-0">
            <h2 class="text-center text-md-left h1"><?= $this->title ?></h2>   
            <div class="my-4 row col-12 justify-content-center d-md-none">
                <?= LinkPager::widget($confPager) ?>
            </div>
            <?= $this->render('/productos/_productos', [
                'productos' => $productos,
            ]) ?>
            <div class="my-4 row col-12 justify-content-center">
                <?= LinkPager::widget($confPager) ?>
            </div>
        </section>
    </div>
</div>
