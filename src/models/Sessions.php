<?php

namespace app\models;

use app\models\tables\TableSessions;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Sessions
{
    private $dayDate;

    public function __construct(string $byDayDate)
    {
        $this->dayDate = $byDayDate;
    }

    public function maxActivityForDate(): CrossedTimeLine
    {
        $query = TableSessions::find()
            ->where([
                'and',
                ['>=', 'login_time', $this->startDate()],
                ["<=", "login_time", $this->endDate()],
                [
                    'or',
                    [">", 'logout_time', $this->startDate()],
                    [">", 'logout_time', null]
                ]
            ])
            ->orderBy(['logout_time' => SORT_ASC]);
        $sessions = $query->all();

//        /**@var TimeLine[] $timeLines */
//        $timeLines = [];
//        foreach ($sessions as $session) {
//            foreach ($timeLines as $timeLine) {
//                $timeLines[] = new TimeLine(
//                    $session->user_id,
//                    $session->login_time,
//                    $session->logout_time
//                );
//
//            }
//        }
//        $userMax = 0;
//        foreach ($timeLines as $timeLine) {
//            if ($timeLine->userCount() > $userMax) {
//                $userMax = $timeLine->userCount();
//            }
//        }
        return $userMax;
    }

    private function startDate()
    {
        return strtotime($this->dayDate);
    }

    private function endDate()
    {
        return strtotime('+1 day', $this->startDate());
    }
}