<?php

namespace app\controllers;


use app\models\math\Determinant;
use app\models\math\Matrix;
use app\models\Sessions;
use Yii;
use yii\helpers\VarDumper;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionMatrixRang()
    {
        $matrix = Matrix::fromRows(
            Yii::$app->request->post('matrix')
        );
        return ["rang"=>$matrix->rang()];
    }

    public function actionAttendance(){
        $sessions = new Sessions(
            Yii::$app->request->get('day')
        );
        return $sessions->maxActivityForDate();
    }

    public function actionDeterminant(){
        $det = Determinant::fromArray(
            Yii::$app->request->post('matrix')
        );
        return ["determinant"=>$det->value()];
    }
}
