<?php

namespace app\models;

class FriggingMinors
{
    private $intersectionElements;
    private $inputDeterminantElements;
    private $mappedList = [];

    /**
     * @param ElementStruct[] $matrixElements
     * @param ElementStruct[] $detElements
     */
    public function __construct(array $matrixElements, array $detElements)
    {
        $this->intersectionElements = new InterseptionElements(
            $matrixElements,
            $detElements
        );
        $this->inputDeterminantElements = $detElements;
    }

    /**
     * @return Determinant[]
     */
    public function list(): array
    {
        $minors = [];
        foreach ($this->intersectionElements->notCrossedElements() as $notCrossedElement) {
            $elementsForMinor = array_filter(
                $this->intersectionElements->crossedElements(),
                function (ElementStruct $crossedElement) use ($notCrossedElement) {
                    if ($notCrossedElement->columnNum() == $crossedElement->columnNum()) {
                        return true;
                    }
                    if ($notCrossedElement->rowNum() == $crossedElement->rowNum()) {
                        return true;
                    }
                    return false;
                }
            );
            //добавляем исходные элементы определителя в окаймляющий минор
            $elementsForMinor = array_merge(
                $this->inputDeterminantElements, //исходные элемент определителя
                $elementsForMinor, //элементы которые лежат на пересечен
                [$notCrossedElement] //элемент который лежит вне пересечения
            );
            $minor = new Determinant($elementsForMinor);
            $minors[] = $minor;
            $this->mappedList[] = [
                'minor' => $minor,
                'elements' => $elementsForMinor
            ];
        }
        return $minors;
    }

    /**
     * @return array - возвращает соотношение: минор - элементы из которых он состоит
     */
    public function elementsByMinor(Determinant $minor): array
    {
        if (empty($this->mappedList)) {
            $this->list();
        }
        foreach ($this->mappedList as $item) {
            if ($item['minor'] == $minor) {
                return $item['elements'];
            }
        }
        return [];
    }
}