<?php

namespace app\models\math;

use yii\helpers\VarDumper;

class Determinant
{
    private $elements;
    private $matrixSort;

    public static function fromArray(array $rows): self{
        $elements = [];
        foreach ($rows as $rowNum=>$row){
            foreach ($row as $columnNum=>$column){
                $elements[] = new ElementStruct(
                    $rowNum+1,
                    $columnNum+1,
                    $column
                );
            }
        }
        return new self($elements);
    }

    /**
     * @param ElementStruct[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
        $this->matrixSort = new MatrixSort($elements);
    }

    /**
     * @return float - значение определителя
     */
    public function value(): float
    {
        if ($this->degree() == 1) {
            return $this->sortedElements()[0]->value();
        }
        $sum = 0;
        if ($this->degree() == 2) {
            $multiple2 = 1;
            $multiple1 = 1;
            foreach ($this->sortedElements() as $elemNum=>$element) {
                if($elemNum == 0 or $elemNum == 3){
                    $multiple1 = $multiple1 * $element->value();
                }else{
                    $multiple2 = $multiple2 * $element->value();
                }

            }
            $sum = $multiple1 - $multiple2;
            return $sum;
        }
        $firstRow = $this->sortedElements()[0]->rowNum();
        foreach ($this->sortedElements() as $element){
            if($element->rowNum() != $firstRow){
                continue;
            }
            $minor = new Minor($this->sortedElements(), $element);
            $sum = $sum + $this->koef($element) * $minor->value() * $element->value();
        }
        return $sum;
    }

    /**
     * Определяет прядок определителя
     * @return int
     */
    public function degree(): int
    {
        return sqrt(
            count($this->elements)
        );
    }

    /**
     * @return ElementStruct[] - сортированные по индексам элементы
     */
    private function sortedElements()
    {
        return $this->matrixSort->reIndex();
    }

    private function koef(ElementStruct $element): int{
        return pow(-1, $element->rowNum() + $element->columnNum());
    }
}