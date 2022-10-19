<?php


namespace app\models;


use yii\helpers\VarDumper;

class Determinant
{
    private $detElements;
    /**
     * @var ElementStruct[]
     */
    private $_sortedElements = null;

    /**
     * Determinant constructor.
     * @param ElementStruct[] $matrixElements
     */
    public function __construct(array $matrixElements)
    {
        $this->detElements = $matrixElements;
    }

    /**
     * @return float -
     */
    public function value(): float
    {
        $sum = 0;
        if ($this->order() == 2) {
            foreach ($this->detElements as $elementNum => $element) {
                $sum = $sum + $this->koef($elementNum) * $element->value();
            }
            return $sum;
        }

        $firstRow = $this->detElements[0]->rowNum();
        foreach ($this->detElements as $elementNum => $element) {
            if ($element->rowNum() != $firstRow) {
                continue;
            }
            $minor = new Determinant(
                $this->notCrossedElements(
                    $element
                )
            );

            $sum = $this->koef($elementNum) * $element->value() * $minor->value() + $sum;
        }
        return $sum;
    }

    public function order(): int
    {
        return $this->lastColumn();
    }

    public function addElement(ElementStruct $element): self
    {
        $this->detElements[] = $element;
        return $this;
    }

    /**
     * @param ElementStruct[] $elements
     * @return Determinant[]
     */
    public function friggingMinors(array $elements): array
    {
        $minors = [];
        /**@var ElementStruct[] $crossedElements */
        $crossedElements = [];
        /**@var ElementStruct[] $notCrossedElements */
        $notCrossedElements = [];
        foreach ($elements as $element) {
            if ($element->columnNum() >= $this->firstColumnNum() and
                $element->columnNum() <= $this->lastColumn()
            ) {
                $crossedElements[] = $element;
                continue;
            }
            if (
                $element->rowNum() >= $this->firstRowNum() and
                $element->rowNum() <= $this->lastRowNum()
            ) {
                $crossedElements[] = $element;
                continue;
            }
            $notCrossedElements[] = $element;
        }
        foreach ($notCrossedElements as $notCrossedElement) {
            $minor = new Determinant(array_merge($this->detElements,[$notCrossedElement]));
            foreach ($crossedElements as $crossedElement) {
                if (
                    $crossedElement->rowNum() == $notCrossedElement->rowNum() or
                    $crossedElement->columnNum() == $notCrossedElement->columnNum()
                ) {
                    $minor->addElement($crossedElement);
                }
                if ($minor->order() + 1 == $this->order()) {
                    break;
                }
            }
            $minors[] = $minor;
        }
        return $minors;
    }

    private function lastRowNum(): int
    {
        $elements = $this->detElements;
        return end($elements)->rowNum();
    }

    private function lastColumn(): int
    {
        $elements = $this->detElements;
        return end($elements)->columnNum();
    }

    private function firstRowNum(): int
    {
        $elements = $this->detElements;
        return array_shift($elements)->rowNum();
    }

    private function firstColumnNum(): int
    {
        $elements = $this->detElements;
        return array_shift($elements)->columnNum();
    }

    /**
     * @param ElementStruct $element
     * @return ElementStruct[]
     */
    private function notCrossedElements(ElementStruct $element): array
    {
        return array_filter(
            $this->detElements,
            function (ElementStruct $elementStruct) use ($element) {
                if ($element->columnNum() == $elementStruct->columnNum()) {
                    return false;
                }
                if ($element->rowNum() == $elementStruct->rowNum()) {
                    return false;
                }
                return true;
            }
        );
    }

    private function koef(int $elementNum): int
    {
        $koef = 1;
        if ($elementNum % 2 == 0) {
            $koef = -1;
        }
        return $koef;
    }
}