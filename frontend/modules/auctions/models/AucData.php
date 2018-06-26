<?php

namespace frontend\modules\auctions\models;

use frontend\modules\auctions\components\ImagesTrait;
use frontend\modules\auctions\components\WithImagesInterface;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auc_data".
 *
 * @property integer $id
 * @property integer $source_auc_id
 * @property string $number_anno
 * @property integer $cruser_id
 * @property integer $org_id
 * @property integer $subject_id
 * @property integer $lienor_id
 * @property integer $agent_id
 * @property string $agent_phone
 * @property string $agent_email
 * @property string $agent_address
 * @property string $pledgor
 * @property string $payment_details
 * @property string $margin_pay_cond
 * @property string $notifications
 * @property string $media_public
 * @property integer $colcat_id
 * @property string $start_date
 * @property string $end_date
 * @property integer $buy_status
 * @property string $title_ru
 * @property string $title_kz
 * @property string $name_ru
 * @property string $name_kz
 * @property integer $sale_type
 * @property integer $auction_type
 * @property integer $lastupdateuserid
 * @property string $lastupdate
 * @property integer $count_lots
 * @property string $start_sum
 * @property string $margin_sum
 * @property string $reserve_price
 * @property string $increment
 * @property string $imgname
 * @property string $imgsavename
 * @property string $venue
 * @property integer $region_id
 * @property integer $is_collateral
 * @property string $apa_end_datetime
 * @property integer $is_direct_sale
 * @property integer $is_operator_ads
 */
class AucData extends ActiveRecord implements WithImagesInterface
{
    use ImagesTrait;

//    public $hash;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auc_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['source_auc_id', 'cruser_id', 'org_id', 'subject_id', 'lienor_id', 'agent_id', 'colcat_id', 'buy_status',
              'sale_type', 'auction_type', 'lastupdateuserid', 'count_lots', 'region_id', 'is_collateral',
              'is_direct_sale', 'is_operator_ads'], 'integer'],
            [['number_anno', 'cruser_id', 'subject_id', 'colcat_id', 'buy_status', 'title_ru', 'title_kz', 'name_ru',
              'name_kz', 'sale_type', 'count_lots', 'start_sum', 'margin_sum', 'imgname', 'imgsavename', 'venue'],
                'default', 'value' => null],
            [['start_date', 'end_date', 'lastupdate', 'apa_end_datetime'], 'safe'],
            [['name_ru', 'name_kz'], 'string'],
            [['start_sum', 'margin_sum', 'reserve_price', 'increment'], 'number'],
            [['number_anno'], 'string', 'max' => 20],
            [['agent_phone', 'agent_email', 'agent_address', 'pledgor', 'payment_details', 'margin_pay_cond',
              'notifications', 'media_public', 'title_ru', 'title_kz', 'imgname',
              'imgsavename', 'venue'], 'string', 'max' => 255],*/
            [['hash', 'agent_phone'], 'string'],
            /*[['imageFiles'], 'file', 'skipOnEmpty' => TRUE,
                'extensions' => 'png, jpg, bmp'],*/
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'source_auc_id' => Yii::t('app', 'Source Auc ID'),
            'number_anno' => Yii::t('app', 'Number Anno'),
            'cruser_id' => Yii::t('app', 'Cruser ID'),
            'org_id' => Yii::t('app', 'Org ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'lienor_id' => Yii::t('app', 'Lienor ID'),
            'agent_id' => Yii::t('app', 'Agent ID'),
            'agent_phone' => Yii::t('app', 'Agent Phone'),
            'agent_email' => Yii::t('app', 'Agent Email'),
            'agent_address' => Yii::t('app', 'Agent Address'),
            'pledgor' => Yii::t('app', 'Pledgor'),
            'payment_details' => Yii::t('app', 'Payment Details'),
            'margin_pay_cond' => Yii::t('app', 'Margin Pay Cond'),
            'notifications' => Yii::t('app', 'Notifications'),
            'media_public' => Yii::t('app', 'Media Public'),
            'colcat_id' => Yii::t('app', 'Colcat ID'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'buy_status' => Yii::t('app', 'Buy Status'),
            'title_ru' => Yii::t('app', 'Title Ru'),
            'title_kz' => Yii::t('app', 'Title Kz'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_kz' => Yii::t('app', 'Name Kz'),
            'sale_type' => Yii::t('app', 'Sale Type'),
            'auction_type' => Yii::t('app', 'Auction Type'),
            'lastupdateuserid' => Yii::t('app', 'Lastupdateuserid'),
            'lastupdate' => Yii::t('app', 'Lastupdate'),
            'count_lots' => Yii::t('app', 'Count Lots'),
            'start_sum' => Yii::t('app', 'Start Sum'),
            'margin_sum' => Yii::t('app', 'Margin Sum'),
            'reserve_price' => Yii::t('app', 'Reserve Price'),
            'increment' => Yii::t('app', 'Increment'),
            'imgname' => Yii::t('app', 'Imgname'),
            'imgsavename' => Yii::t('app', 'Imgsavename'),
            'venue' => Yii::t('app', 'Venue'),
            'region_id' => Yii::t('app', 'Region ID'),
            'is_collateral' => Yii::t('app', 'Is Collateral'),
            'apa_end_datetime' => Yii::t('app', 'Apa End Datetime'),
            'is_direct_sale' => Yii::t('app', 'Is Direct Sale'),
            'is_operator_ads' => Yii::t('app', 'Is Operator Ads'),
        ];
    }

}
