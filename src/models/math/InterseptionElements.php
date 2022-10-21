<?php

namespace app\models\math;

class InterseptionElements
{
    private $matrixElements;
    private $_crossedElements = [];
    private $_notCressedElements = [];
    private $centreSort;

    /**
     * @param ElementStruct[] $matrixElements - все эелменты матрицы
     * @param ElementStruct[] $intersectionCentre - элементы лежащие на пересечении (т.е. в центре пересечения)
     */
    public function __construct(array $matrixElements, array $intersectionCentre)
    {
        $this->matrixElements = $matrixElements;
        $this->centreSort = new MatrixSort($intersectionCentre);
    }


    /**
     * @return ElementStruct[]
     */
    public function crossedElements(): array
    {
        if(!empty($this->_crossedElements)){
            return $this->_crossedElements;
        }
        $this->filterOut();
        return $this->_crossedElements;
    }

    /**
     * @return ElementStruct[]
     */
    public function notCrossedElements(): array
    {
        if(!empty($this->_notCressedElements)){
            return $this->_notCressedElements;
        }
        $this->filterOut();
        return $this->_notCressedElements;
    }

    public function filterOut(): void
    {
        $crossedElements = [];
        $notCrossedElements = [];
        foreach ($this->matrixElements as $element) {
            if (
                $element->rowNum() >= $this->firstRowNum() and
                $element->rowNum() <= $this->lastRowNum()
            ) {
                $crossedElements[] = $element;
                continue;
            }
            if ($element->columnNum() >= $this->firstColumnNum() and
                $element->columnNum() <= $this->lastColumnNum()
            ) {
                $crossedElements[] = $element;
                continue;
            }
            $notCrossedElements[] = $element;
        }
        $this->_notCressedElements = $notCrossedElements;
        $this->_crossedElements = $crossedElements;
    }

    private function firstColumnNum(): int
    {
        $elems = $this->sortedElements();
        return array_shift($elems)->columnNum();
    }

    private function lastColumnNum(): int
    {
        $elems = $this->sortedElements();
        return end($elems)->columnNum();
    }

    private function firstRowNum(): int
    {
        $elems = $this->sortedElements();
        return array_shift($elems)->rowNum();
    }

    private function lastRowNum(): int
    {
        $elems = $this->sortedElements();
        return end($elems)->rowNum();
    }

    private function sortedElements(): array
    {
        return $this->centreSort->ascIndex();
    }
}