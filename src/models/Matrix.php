<?php


namespace app\models;


use yii\helpers\VarDumper;

class Matrix
{

    private $matrix;

    /**
     * Matrix constructor.
     * @param array[] $matrix
     */
    public function __construct(
        array $matrix =
        [
            [0, 0, 0, 0],
            [0, 0, 0, 0]
        ]
    ) {
        $this->matrix = $matrix;
    }

    public function rang()
    {

        $matrix = $this->matrix;
        $mainRow = array_shift($matrix);
        $modifiedMatrix = [];
        foreach ($matrix as $rowNum => $row) {
            $koef = $row[0] / $mainRow[0];
            $modifiedRow = [];
            foreach ($row as $columnNum => $column) {
                $modifiedRow[] = $column - $mainRow[$columnNum] * $koef;
            }
            $modifiedMatrix[] = $modifiedRow;
        }
        $mm = $this->walkByRows($modifiedMatrix);
        VarDumper::dump($this->removeFirstColumn($modifiedMatrix));
        return $modifiedMatrix;
    }

    private function removeFirstColumn(array $matrix)
    {
        $modifiedMatrix = [];
        foreach ($matrix as $row) {
            array_shift($row);
            $modifiedMatrix[] = $row;
        }
        return $modifiedMatrix;
    }

    private function removeNUllableRows($matrix){
        foreach ($m)
    }

    private function walkByRows(array $matrix)
    {
//        $matrix = $this->matrix;
        $needleColumnNum = 0;
        $needleMatrix = [];

        foreach ($matrix as $row) {
            $needleMatrix[] = array_filter($row, function ($key) use ($needleColumnNum) {
                if ($key >= $needleColumnNum) {
                    return true;
                }
                return false;
            }, ARRAY_FILTER_USE_KEY);
            $needleColumnNum++;
        }
        return $needleMatrix;
//        VarDumper::dump($needleMatrix);
    }
}