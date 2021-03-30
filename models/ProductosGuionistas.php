<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_guionistas".
 *
 * @property int $producto_id
 * @property int $guion_id
 *
 * @property Guionistas $guion
 * @property Productos $producto
 */
class ProductosGuionistas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_guionistas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'guion_id'], 'required'],
            [['producto_id', 'guion_id'], 'default', 'value' => null],
            [['producto_id', 'guion_id'], 'integer'],
            [['producto_id', 'guion_id'], 'unique', 'targetAttribute' => ['producto_id', 'guion_id']],
            [['guion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Guionistas::className(), 'targetAttribute' => ['guion_id' => 'id']],
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
            'guion_id' => 'Guion ID',
        ];
    }

    /**
     * Gets query for [[Guion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGuion()
    {
        return $this->hasOne(Guionistas::className(), ['id' => 'guion_id'])->inverseOf('productosGuionistas');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('productosGuionistas');
    }
}
