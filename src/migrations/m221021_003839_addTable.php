<?php

use app\models\tables\TableSessions;
use Faker\Factory;
use yii\db\Migration;

/**
 * Class m221021_003839_addTable
 */
class m221021_003839_addTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sessions', [
            'id'=>$this->primaryKey(),
            'user_id'=>$this->integer()->notNull(),
            'login_time'=>$this->integer(),
            'logout_time'=>$this->integer()->defaultValue(null),
        ]);
        $faker = Factory::create();
        foreach (range(0, 300) as $item) {
            $loginTime = $faker->dateTimeThisMonth();
            $dayDiffs = date_diff($loginTime, new DateTime())->days;
            $logoutTime = $faker->dateTimeBetween("-" . $dayDiffs . " days", 'now');
            $session = new TableSessions([
                'user_id' => $item + 1,
                'login_time' => $loginTime->getTimestamp(),
                'logout_time' =>$logoutTime->getTimestamp()
            ]);
            $session->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sessions');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221021_003839_addTable cannot be reverted.\n";

        return false;
    }
    */
}
