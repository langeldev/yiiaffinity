<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = $model->lista->titulo;

$this->params['breadcrumbs'][] = [
  'label' => 'Listas de ' . Html::encode($model->usuario->login),
  'url' => ['/usuarios-listas/usuarios', 'id' => $model->usuario_id]
];

if ($model->usuario_id === Yii::$app->user->id) {
  $this->params['breadcrumbs'][] = ['label' => 'Mis Listas', 'url' => ['/usuarios-listas/mis-listas']];
}
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$urlCambiar = Url::to(['listas-productos/cambiar-posicion']);
$urlEliminar = Url::to(['listas-productos/delete']);

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

    $('.eliminar').click(function (ev) {
      ev.preventDefault();
      var el = $(this);
      var lista_id = el.data('key');
      var titulo = el.data('titulo');
      var confirmado = confirm('¿Estás seguro que quiere eliminar "' + titulo + ' de esta lista?');
      if (confirmado) {
      el.attr('disabled', true);
      $.ajax({
          type: 'POST',
          url: '$urlEliminar',
          data: {
              lista_id: lista_id
          },
          success: function(data){
              if (data.titulo == titulo){
                  el.parents('li').slideUp('normal', function (event) {
                      $(this).remove();
                      inhabilitar(); 
                  });
             }
          }
      });
  }
     return false;
  });
  

  inhabilitar();  
EOT;
$this->registerJs($js);

?>
<div class="fondo p-2">
  <div class="col-12">

    <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>

    <div id="lista-productos" class="py-5 px-3">
      <?php if ($listaProducto) : ?>
        <ol class="p-0">
          <?php foreach ($listaProducto as $lista) : ?>
            <li id="<?= $lista->id ?>" class="lista-producto">
              <div class="row">
                <div class="col img-lista pr-0">
                  <?= Html::img($lista->producto->getImagen(), ['class' => 'img-fluid']) ?>
                </div>
                <h3 class="col-7">
                  <?= Html::a(Html::encode($lista->producto->titulo), ['/productos/ficha', 'id' => $lista->producto->id]) ?>
                </h3>
                <div class="col-3">
                  <?php if (!Yii::$app->user->isGuest) : ?>
                    <?php if ($model->usuario_id === Yii::$app->user->id) : ?>
                      <?= Html::button('<i class="fas fa-arrow-up"></i>', [
                        'class' => 'btn btn-outline-info border-0 rounded-0 subir boton',
                        'method' => 'post'
                      ])
                      ?>
                      <?= Html::button('<i class="fas fa-arrow-down"></i>', [
                        'class' => 'btn btn-outline-info border-0 rounded-0 bajar boton',
                        'data-key' => $lista->id,
                        'method' => 'post'
                      ])
                      ?>
                      <?= Html::button('x', [
                        'class' => 'btn btn-outline-danger rounded-0 eliminar boton',
                        'data-key' => $lista->id,
                        'data-method' => 'POST',
                        'title' => 'Eliminar  de esta lista',
                        'data-titulo' => $lista->producto->titulo
                      ])
                      ?>
                    <?php endif ?>
                  <?php endif ?>
                </div>
              </div>
            </li>
          <?php endforeach ?>
        </ol>
      <?php else : ?>
        <h3 class="text-center py-5">Esta lista está vacía.</h3>
      <?php endif ?>
    </div>
  </div>
</div>
