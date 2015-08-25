<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property string $id
 * @property string $created_on
 * @property string $updated_on
 *
 * @property Users[] $users
 */
class Role extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_on', 'updated_on'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['id'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['user_role' => 'id']);
    }
}
