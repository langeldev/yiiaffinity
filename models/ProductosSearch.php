<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Productos;

/**
 * ProductosSearch represents the model behind the search form of `app\models\Productos`.
 */
class ProductosSearch extends Productos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'duracion', 'tipo_id'], 'integer'],
            [['titulo', 'titulo_original', 'pais', 'sinopsis'], 'safe'],
            [['anyo'], 'number'],
            [['tipo.nombre'], 'string'],
        ];
    }

    public function attributes()
    {
        return \array_merge(parent::attributes(), ['tipo.nombre']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Productos::find()->joinWith('tipo t');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
        ]);
        $dataProvider->sort->attributes['tipo.nombre'] = [
            'asc' => ['t.nombre' => SORT_ASC],
            'desc' => ['t.nombre' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'anyo' => $this->anyo,
            'duracion' => $this->duracion,
        ]);

        $query->andFilterWhere(['ilike', 't.nombre',  $this->getAttribute('tipo.nombre')])
            ->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'titulo_original', $this->titulo_original])
            ->andFilterWhere(['ilike', 'pais', $this->pais])
            ->andFilterWhere(['ilike', 'sinopsis', $this->sinopsis]);

        return $dataProvider;
    }
}
