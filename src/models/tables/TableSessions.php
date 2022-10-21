<?php

namespace app\models\tables;

use yii\db\ActiveRecord;

/**
 *
 * @property int $id [int(11)]
 * @property int $user_id [int(11)]
 * @property string $login_time [datetime]
 * @property string $logout_time [datetime]
 */
class TableSessions extends ActiveRecord
{
    public static function tableName()
    {
        return 'sessions';
    }
}