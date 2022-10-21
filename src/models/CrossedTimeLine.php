<?php

namespace app\models;

class CrossedTimeLine
{
    private $timeStart;
    private $timeEnd;
    private $users = [];

    public function __construct($timeStart, $timeEnd)
    {
        $this->timeEnd = $timeEnd;
        $this->timeStart = $timeStart;
    }

    public function addUser(int $userId): self
    {
        $this->users[] = $userId;
        return $this;
    }

    public function usersCount(): int
    {
        return count($this->users);
    }

    public function offsetStartTime($toEndTime): self
    {
        $this->timeEnd = $toEndTime;
    }

    public function offsetEndTime($toStartTime): self
    {
        $this->timeStart = $toStartTime;
    }

    public function crossetTimeStruct(){

    }
}