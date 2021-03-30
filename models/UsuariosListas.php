<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios_listas".
 *
 * @property int $id
 * @property int|null $usuario_id
 * @property int|null $lista_id
 *
 * @property ListasProductos[] $listasProductos
 * @property Productos[] $productos
 * @property Listas $lista
 * @property Usuarios $usuario
 */
class UsuariosListas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios_listas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'lista_id'], 'default', 'value' => null],
            [['usuario_id', 'lista_id'], 'integer'],
            [['lista_id'], 'exist', 'skipOnError' => true, 'targetClass' => Listas::className(), 'targetAttribute' => ['lista_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'lista_id' => 'Lista ID',
        ];
    }

    /**
     * Gets query for [[ListasProductos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListasProductos()
    {
        return $this->hasMany(ListasProductos::class, ['lista_id' => 'id'])->inverseOf('lista');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('listas_productos', ['lista_id' => 'id']);
    }

    /**
     * Gets query for [[Lista]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLista()
    {
        return $this->hasOne(Listas::class, ['id' => 'lista_id'])->inverseOf('usuariosListas');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('usuariosListas');
    }
}
