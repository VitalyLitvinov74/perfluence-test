<?php

namespace app\controllers;


use app\models\Determinant;
use app\models\Matrix;
use Yii;
use yii\helpers\VarDumper;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionMatrixRang()
    {
        $matrix = Matrix::fromArray(
            Yii::$app->request->post('matrix')
        );
        return ["rang"=>$matrix->rank()];
    }

    public function actionUsersByDate(){

    }

    public function actionDeterminant(){
        $det = Determinant::fromArray(
            Yii::$app->request->post('matrix')
        );
        return ["determinant"=>$det->value()];
    }
}
