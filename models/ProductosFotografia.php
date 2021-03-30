<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_fotografia".
 *
 * @property int $producto_id
 * @property int $fotografia_id
 *
 * @property Fotografia $fotografia
 * @property Productos $producto
 */
class ProductosFotografia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_fotografia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'fotografia_id'], 'required'],
            [['producto_id', 'fotografia_id'], 'default', 'value' => null],
            [['producto_id', 'fotografia_id'], 'integer'],
            [['producto_id', 'fotografia_id'], 'unique', 'targetAttribute' => ['producto_id', 'fotografia_id']],
            [['fotografia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fotografia::className(), 'targetAttribute' => ['fotografia_id' => 'id']],
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
            'fotografia_id' => 'Fotografia ID',
        ];
    }

    /**
     * Gets query for [[Fotografia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFotografia()
    {
        return $this->hasOne(Fotografia::className(), ['id' => 'fotografia_id'])->inverseOf('productosFotografias');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('productosFotografias');
    }
}
