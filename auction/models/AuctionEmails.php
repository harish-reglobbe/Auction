<?php

namespace auction\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
/**
 * This is the model class for table "{{%auction_emails}}".
 *
 * @property integer $id
 * @property string $to
 * @property string $cc
 * @property string $bcc
 * @property string $from
 * @property string $subject
 * @property string $message
 * @property string $replyTo
 * @property string $dateCreated
 * @property string $lastUpdated
 * @property integer $status
 * @property string $name
 */
class AuctionEmails extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'dateCreated',
                'updatedAtAttribute' => 'lastUpdated',
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auction_emails}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['to', 'from', 'subject', 'message'], 'required'],
            [['message'], 'string'],
            [['dateCreated', 'lastUpdated'], 'safe'],
            [['status'], 'integer'],
            [['to', 'cc', 'bcc', 'from', 'subject', 'replyTo', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to' => 'To',
            'cc' => 'Cc',
            'bcc' => 'Bcc',
            'from' => 'From',
            'subject' => 'Subject',
            'message' => 'Message',
            'replyTo' => 'Reply To',
            'dateCreated' => 'Date Created',
            'lastUpdated' => 'Last Updated',
            'status' => 'Status',
            'name' => 'Name',
        ];
    }
}
