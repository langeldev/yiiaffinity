<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_musica".
 *
 * @property int $producto_id
 * @property int $musica_id
 *
 * @property Musica $musica
 * @property Productos $producto
 */
class ProductosMusica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_musica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'musica_id'], 'required'],
            [['producto_id', 'musica_id'], 'default', 'value' => null],
            [['producto_id', 'musica_id'], 'integer'],
            [['producto_id', 'musica_id'], 'unique', 'targetAttribute' => ['producto_id', 'musica_id']],
            [['musica_id'], 'exist', 'skipOnError' => true, 'targetClass' => Musica::className(), 'targetAttribute' => ['musica_id' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto_id' => 'Producto ID',
            'musica_id' => 'Musica ID',
        ];
    }

    /**
     * Gets query for [[Musica]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMusica()
    {
        return $this->hasOne(Musica::class, ['id' => 'musica_id'])->inverseOf('productosMusicas');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::class, ['id' => 'producto_id'])->inverseOf('productosMusicas');
    }
}
