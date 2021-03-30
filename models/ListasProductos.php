<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "listas_productos".
 *
 * @property int $id
 * @property int|null $lista_id
 * @property int|null $producto_id
 * @property int|null $posicion
 *
 * @property Productos $producto
 * @property UsuariosListas $lista
 */
class ListasProductos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listas_productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lista_id', 'producto_id', 'posicion'], 'default', 'value' => null],
            [['lista_id', 'producto_id', 'posicion'], 'integer'],
            [['producto_id', 'lista_id'], 'unique', 'targetAttribute' => ['producto_id', 'lista_id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['lista_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsuariosListas::className(), 'targetAttribute' => ['lista_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lista_id' => 'Lista ID',
            'producto_id' => 'Producto ID',
            'posicion' => 'Posicion',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('listasProductos');
    }

    /**
     * Gets query for [[Lista]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLista()
    {
        return $this->hasOne(UsuariosListas::className(), ['id' => 'lista_id'])->inverseOf('listasProductos');
    }
}
