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

    /*
     * Сортируем матрицу по возрастанию индексов (например: 11, 12, 13 .... 4,4)
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
}