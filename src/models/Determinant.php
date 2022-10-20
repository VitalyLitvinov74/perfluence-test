<?php

namespace app\models;

class Determinant
{
    private $elements;
    private $matrixSort;

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
            foreach ($this->sortedElements() as $elemNum => $element) {
                $sum = $sum + $this->koef($elemNum)*$element->value();
            }
            return $sum;
        }
        $firstElem = $this->sortedElements()[0];
        foreach ($this->sortedElements() as $elemNum => $element){
            if($element != $firstElem){
                continue;
            }
            $minor = new Minor($this->sortedElements(), $element);
            $sum = $sum + $this->koef($elemNum) * $minor->value() * $element->value(); //знаки не расставлены
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
        return $this->matrixSort->ascIndex();
    }

    private function koef(int $elementNum): int{
        if ($elementNum % 2 == 0){
            return 1;
        }
        return -1;
    }
}