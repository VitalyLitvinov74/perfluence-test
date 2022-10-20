<?php

namespace app\models;

use yii\helpers\VarDumper;

class Minor
{
    private $inteseptionElements;

    /**
     * @param ElementStruct[] $detElements - элементы родительского определителя
     * @param ElementStruct $crossedElement - элемент, который находится на пересечении i-й строки и j-го столбца
     */
    public function __construct(array $detElements, ElementStruct $crossedElement)
    {
        $this->inteseptionElements = new InterseptionElements($detElements, [$crossedElement]);
    }

    public function value(): float
    {
        $determinant = new Determinant(
            //Т.е. получаем определитель, который лежит не на вычеркнутой строке или вычеркнутом столбце
            $this->inteseptionElements->notCrossedElements()
        );
        //минор на порядок ниже исходного
        return $determinant->value();
    }
}