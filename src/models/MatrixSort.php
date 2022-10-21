<?php

namespace app\models;

class MatrixSort
{
    private $elements;
    private $_ascIndex = [];

    public function __construct(array $matrixElement)
    {
        $this->elements = $matrixElement;
    }

    /**
     * Сортируем матрицу по возрастанию индексов (например: 11, 12, 13 .... 4,4)
     * @return ElementStruct[]
     */
    public function ascIndex(): array
    {
        if (!empty($this->_ascIndex)) {
            return $this->_ascIndex;
        }
        $this->_ascIndex = $this->elements;
        usort(
            $this->_ascIndex,
            function (ElementStruct $a, ElementStruct $b) {
                if ($a->rowNum() > $b->rowNum()) {
                    return 1;
                } elseif ($a->rowNum() < $b->rowNum()) {
                    return -1;
                }
                if ($a->columnNum() > $b->columnNum()) {
                    return 1;
                }
                return -1;
            }
        );
        return $this->_ascIndex;
    }

    /**
     * @return ElementStruct[] - меняет индекс на начальный
     */
    public function reIndex(): array
    {
        $rowNum = $this->ascIndex()[0]->rowNum();
        $rowCounter = 1;
        $columnCounter = 1;
        $reindex = [];
        foreach ($this->ascIndex() as $element) {
            if ($element->rowNum() != $rowNum) {
                ++$rowCounter;
                $columnCounter = 1;
                $rowNum = $element->rowNum();
            }
            $reindex[] = new ElementStruct(
                $rowCounter,
                $columnCounter,
                $element->value()
            );
            ++$columnCounter;
        }
        return $reindex;
    }
}