<?php

namespace app\controllers;


use app\models\Matrix;
use Yii;
use yii\helpers\VarDumper;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionMatrixRang()
    {
        $matrix = new Matrix(
            Yii::$app->request->post('matrix')
        );
        return ["rang"=>$matrix->rang()];
    }

    public function actionUsersByDate(){

    }
}
