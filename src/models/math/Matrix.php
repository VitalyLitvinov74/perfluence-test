<?php

namespace app\models\math;

class Matrix implements IMatrix
{
    private $elements;

    public static function fromRows(array $rows): self
    {
        $elements = [];
        foreach ($rows as $rowNum => $row) {
            foreach ($row as $colNum => $column) {
                $elements[] = new ElementStruct($rowNum + 1, $colNum + 1, $column);
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

    public function rang(): int
    {
        $firstElem = $this->firstElemForRang();
        if ($firstElem->value() == 0) {
            return 0;
        }
        //окаймляющие миноры для ненулевого элемента (миноры 2-го порядка)
        $friggingMinors = new FriggingMinors($this->elements, [$firstElem]);
        while (true) {
            $allNullableFriggingMinors = true;
            foreach ($friggingMinors->list() as $friggingMinor) {
                //если значение минора не 0, то ищем окаймляющие миноры для этого минора
                if ($friggingMinor->value() != 0) {
                    $friggingMinorElements = $friggingMinors->elementsByMinor($friggingMinor);
                    $friggingMinors = new FriggingMinors(
                        $this->elements,
                        $friggingMinorElements
                    );
                    $allNullableFriggingMinors = false;
                    break;
                }
            }
            if ($allNullableFriggingMinors) {
                $rank = $friggingMinor->degree() - 1;
                break;
            }
            if ($this->minDimension() == $friggingMinor->degree()) {
                $rank = $friggingMinor->degree();
                break;
            }
        }
        return $rank;
    }

    /**
     * @return ElementStruct - не нулевой элемент матрицы, если такого нет то вернут нулевой элемент
     */
    private function firstElemForRang(): ElementStruct
    {
        foreach ($this->elements as $element) {
            if ($element->value() != 0) {
                return $element;
            }
        }
        return $this->elements[0];
    }

    private function minDimension(): int
    {
        $elements = $this->elements;
        $endElement = end($elements);
        return min($endElement->rowNum(), $endElement->columnNum());
    }
}