<?php

namespace app\models;

class Matrix
{
    private $elements;

    public static function fromRows(array $rows): self
    {
        $elements = [];
        foreach ($rows as $rowNum => $row) {
            foreach ($row as $colNum => $column) {
                $elements[] = new ElementStruct($rowNum, $colNum, $column);
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
    }

    public function rang()
    {
        $firstElem = $this->firstElemForRang();
        if ($firstElem->value() == 0) {
            return 0;
        }
        $friggingMinors = new FriggingMinors($this->elements, [$firstElem]);
        while (true) {
            foreach ($friggingMinors->list() as $friggingMinor){
                if($friggingMinor->value() != 0){
                    $friggingMinorElements = $friggingMinors->elementsByMinor($friggingMinor);
                    $friggingMinors = new FriggingMinors(
                        $this->elements,
                        $friggingMinorElements
                    );
                    break;
                }
            }
        }

    }

    /**
     * @return ElementStruct - не нулевой элемент матрицы, если такого нет то вернут нулевой эелмент
     */
    private function firstElemForRang(): ElementStruct
    {

    }
}