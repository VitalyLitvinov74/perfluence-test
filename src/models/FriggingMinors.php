<?php

namespace app\models;

class FriggingMinors
{
    private $matrixElements;
    private $detElements;
    private $_crossedElements = [];

    /**
     * @param ElementStruct[] $matrixElements
     * @param ElementStruct[] $detElements
     */
    public function __construct(array $matrixElements, array $detElements)
    {
        $this->detElements = $detElements;
        $this->matrixElements = $matrixElements;
    }

    /**
     * @return Determinant[]
     */
    public function list(): array
    {

    }

    /**
     * @return array - возвращает соотношение: минор - элементы из которых он состоит
     */
    public function elementsByMinor(Determinant $minor): array
    {

    }
}