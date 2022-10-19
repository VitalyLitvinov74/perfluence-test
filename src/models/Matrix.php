<?php


namespace app\models;


use yii\helpers\VarDumper;

class Matrix
{
    private $elements;

//    private $_elements = null;

    public static function fromArray(array $matrix): self
    {
        $elements = [];
        foreach ($matrix as $rowNum=>$row){
            foreach ($row as $colNum=>$column){
                $elements[] = new ElementStruct($rowNum+1, $colNum+1, $column);
            }
        }
        return new self($elements);
    }

    /**
     * Matrix constructor.
     * @param ElementStruct[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function rank(): int
    {
        $rank = 0;
        $elements = $this->elements;
        foreach ($elements as $element){
            if($element->value() != 0){
                $minor = new Determinant([$element]);
                $rank = 1;
                break;
            }
        }
        if($rank == 0){
            return $rank;
        }

        while (true) {
            $friggingsMinors = $minor->friggingMinors(
                $this->elements
            );
            $allNullableFriggingMinors = true;
            foreach ($friggingsMinors as $friggingMinor) {
                if ($friggingMinor->value() > 0) {

                    $minor = $friggingMinor;
                    $allNullableFriggingMinors = false;
                    break;
                }
            }
            if ($allNullableFriggingMinors
                or $minor->order() == $this->minDimension()) {
                $rank = $minor->order();
                break;
            }
        }
        return $rank;
    }

    public function minDimension(): int
    {
        $elements = $this->elements;
        $endElement = end($elements);
        return
            $endElement->rowNum() < $endElement->columnNum()
                ? $endElement->rowNum()
                : $endElement->columnNum();
    }
}
