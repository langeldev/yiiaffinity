<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "personas".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosDirectores[] $productosDirectores
 * @property Productos[] $productos
 * @property ProductosFotografia[] $productosFotografias
 * @property Productos[] $productos0
 * @property ProductosGuionistas[] $productosGuionistas
 * @property Productos[] $productos1
 * @property ProductosInterpretes[] $productosInterpretes
 * @property Productos[] $productos2
 * @property ProductosMusica[] $productosMusicas
 * @property Productos[] $productos3
 */
class Personas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'personas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[ProductosDirectores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosDirectores()
    {
        return $this->hasMany(ProductosDirectores::class, ['persona_id' => 'id'])->inverseOf('persona');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_directores', ['persona_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosFotografias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosFotografias()
    {
        return $this->hasMany(ProductosFotografia::class, ['persona_id' => 'id'])->inverseOf('persona');
    }

    /**
     * Gets query for [[Productos0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos0()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_fotografia', ['persona_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosGuionistas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGuionistas()
    {
        return $this->hasMany(ProductosGuionistas::class, ['persona_id' => 'id'])->inverseOf('persona');
    }

    /**
     * Gets query for [[Productos1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos1()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_guionistas', ['persona_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosInterpretes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosInterpretes()
    {
        return $this->hasMany(ProductosInterpretes::class, ['persona_id' => 'id'])->inverseOf('persona');
    }

    /**
     * Gets query for [[Productos2]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos2()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_interpretes', ['persona_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosMusicas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosMusicas()
    {
        return $this->hasMany(ProductosMusica::class, ['persona_id' => 'id'])->inverseOf('persona');
    }

    /**
     * Gets query for [[Productos3]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos3()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_musica', ['persona_id' => 'id']);
    }

        /**
    * Devuelve una lista con los directores
    *
    * @return array
    */
    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }
}
