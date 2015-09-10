<?php

namespace auction\models;

use auction\components\Auction;
use auction\components\helpers\DatabaseHelper;
use auction\models\core\ActiveRecord;
use Yii;

/**
 * This is the model class for table "{{%dealer_company}}".
 *
 * @property integer $id
 * @property integer $dealer
 * @property integer $company
 * @property string $create_date
 * @property string $update_date
 * @property string $aprv_date
 * @property integer $aprv_by
 * @property integer $status
 * @property integer $is_active
 * @property integer $mode
 *
 * @property Dealers $dealer0
 * @property Companies $company0
 * @property DealerCompanyPreferences[] $dealerCompanyPreferences
 */
class DealerCompany extends ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{%dealer_company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dealer', 'company', 'is_active', 'mode'], 'required'],
            [['dealer', 'company', 'aprv_by', 'status', 'is_active', 'mode'], 'integer'],
            [['create_date', 'update_date', 'aprv_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dealer' => 'Dealer',
            'company' => 'Company',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'aprv_date' => 'approve date',
            'aprv_by' => 'approve by',
            'status' => 'Status',
            'is_active' => 'Is Active',
            'mode' => '1:-auto approve,2:-approval required',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealer0()
    {
        return $this->hasOne(Dealers::className(), ['id' => 'dealer']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany0()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDealerCompanyPreferences()
    {
        return $this->hasMany(DealerCompanyPreferences::className(), ['dc_id' => 'id']);
    }

    /**
     * Company Added By Dealer
     * then status => 1
     *
     * is_active need to change by company/company User
     */
    public function addedByDealer($id){

        $_model = DealerCompany::find()->where([
            'company' => $id,
            'dealer' => Auction::dealer()
        ])->one();

        if($_model === null){

            $_model = new DealerCompany();
            $_model->company = $id;
            $_model->dealer = Auction::dealer();
            $_model->is_active = DatabaseHelper::IN_ACTIVE;
            $_model->status = DatabaseHelper::ACTIVE;
            $_model->mode = DatabaseHelper::DEALER_APPROVE_APPROVAL_REQUIRED;

            Auction::infoLog('Creating A new Dealer Company Since No Record of DealerCompany of',['company' => $id ,'dealer' => Auction::dealer()]);

        }else{
            switch ($_model->status){

                case DatabaseHelper::ACTIVE :
                    $_model->status = DatabaseHelper::IN_ACTIVE;
                    break;

                case DatabaseHelper::IN_ACTIVE :
                    $_model->status = DatabaseHelper::ACTIVE;
                    break;
            }
            Auction::infoLog('Updating Dealer Company Status',['company' => $id ,'dealer' => Auction::dealer()]);
        }

        return $_model->save();
    }
}
