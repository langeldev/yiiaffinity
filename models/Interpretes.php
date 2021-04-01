<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interpretes".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosInterpretes[] $productosInterpretes
 * @property Productos[] $productos
 */
class Interpretes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interpretes';
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
     * Gets query for [[ProductosInterpretes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosInterpretes()
    {
        return $this->hasMany(ProductosInterpretes::class, ['interprete_id' => 'id'])->inverseOf('interprete');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_interpretes', ['interprete_id' => 'id']);
    }

    /**
    * Devuelve una lista con los interpretes
    *
    * @return array
    */
    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }
}
