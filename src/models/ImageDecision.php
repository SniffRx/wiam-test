<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_decision".
 *
 * @property int $id
 * @property int $image_id
 * @property string $decision
 */
class ImageDecision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image_decision';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_id', 'decision'], 'required'],
            [['image_id'], 'integer'],
            [['decision'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_id' => 'Image ID',
            'decision' => 'Decision',
        ];
    }
}
