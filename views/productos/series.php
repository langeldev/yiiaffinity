<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = 'Series';

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
            <div class="my-5 col-12 ml-auto">
                <?php $form = ActiveForm::begin([
                    'action' => ['series'],
                    'method' => 'get',
                    'successCssClass' => false
                ]); ?>
                <div class="my-5 col-12 row ml-auto px-0">
                    <div class="col">

                        <?= $form->field($model, 'titulo')->textInput([
                            'placeholder' => 'Buscar series por título',
                            'class' => 'form-control form-style m-0'
                        ])->label(false) ?>

                    </div>
                    <?= Html::submitButton('<span class="fas fa-search"></span>', ['class' => 'btn btn-azul']) ?>

                </div>
                <?php ActiveForm::end(); ?>
            </div>
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
