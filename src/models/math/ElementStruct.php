<?php


namespace app\models\math;


class ElementStruct
{
    private $rowNum;
    private $colNum;
    private $value;

    public function __construct(int $rowNum, int $columnNum, $value)
    {
        $this->value = $value;
        $this->colNum = $columnNum;
        $this->rowNum = $rowNum;
    }

    public function rowNum(): int
    {
        return $this->rowNum;
    }

    public function columnNum(): int
    {
        return $this->colNum;
    }

    public function value()
    {
        return $this->value;
    }
}