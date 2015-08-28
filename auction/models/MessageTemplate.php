<?php

namespace auction\models;

use Yii;

/**
 * This is the model class for table "{{%message_template}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_active
 */
class MessageTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%message_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'text', 'created_at', 'updated_at', 'is_active'], 'required'],
            [['type', 'is_active'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_active' => 'Is Active',
        ];
    }
}
