<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = $model->lista->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Mis Listas', 'url' => ['/usuarios-listas/mis-listas']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$urlCambiar = Url::to(['listas-productos/cambiar-posicion']);

$js = <<<EOT
    $('.subir').click(function(ev){
      ev.preventDefault();      
      let el = $(this).parents('li');
      let bajar = el.prev();  
      cambairPoscion(el, bajar,'$urlCambiar')
    });

    $('.bajar').click(function(ev){
      ev.preventDefault();      
      let el = $(this).parents('li');
      let subir = el.next();  
      cambairPoscion(subir,el,'$urlCambiar')
    });

  inhabilitar();  
EOT;
$this->registerJs($js);

?>
<div class="fondo p-2">
<div class="col-12">

  <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
  
  <div id="lista-productos">
    <?php if ($listaProducto) : ?>
    <ol>
      <?php foreach ($listaProducto as $lista) : ?>
        <li id="<?=$lista->id?>">
          <div class="row">
            <h3 class="col-6">
              <?= Html::a(Html::encode($lista->producto->titulo), ['/productos/ficha', 'id' => $lista->producto->id]) ?>
            </h3>
            <div class="col-4">
              <?php if (!Yii::$app->user->isGuest) : ?>
                <?php if ($model->usuario_id === Yii::$app->user->id) : ?>
                  <?= Html::button('<i class="fas fa-arrow-up"></i>', [
                    'class' => 'btn btn-outline-info border-0 rounded-0 subir',
                        'method' => 'post'
                        ])
                        ?>
                  <?= Html::button('<i class="fas fa-arrow-down"></i>', [
                    'class' => 'btn btn-outline-info border-0 rounded-0 bajar',
                    'data-key' => $lista->id,
                        'method' => 'post' 
                        ]) 
                        ?>
                  <?= Html::a('x', ['listas-productos/delete', 'id' => $lista->id], [
                    'class' => 'btn btn-outline-danger rounded-0',
                    'data' => [
                        'confirm' => '¿Quiere eliminar "' . Html::encode($lista->producto->titulo) . '" de esta lista?',
                        'method' => 'post',
                      ],
                  ]) ?>
                <?php endif ?>
              <?php endif ?>
            </div>
          </div>
        </li>
        <?php endforeach ?>
    </ol>
    <?php else: ?>
      <h3 class="text-center py-5">Esta lista está vacía.</h3>
    <?php endif ?>
  </div>
</div>
</div>
