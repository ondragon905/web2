<?php


namespace frontend\controllers;


use common\models\Spisok;
use common\models\Zadachi;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\web\Controller;

class ZadachiController extends Controller
{
    public function actionZad($id){

        $sort = new Sort([
            'attributes' =>
                [
                    'Sort' =>
                        [
                            'asc' =>['title' => SORT_ASC],
                            'desc' =>['title' => SORT_DESC]
                        ]
                ]
        ]);

        $spzad = Zadachi::find()->orderBy($sort->orders)->where(['idspisok' => $id]);
        $spzadcount = $spzad->count();
        $pages = new Pagination(['totalCount' => $spzadcount, 'pageSize' => 10, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $spzad = $spzad->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('zad', ['spzad' => $spzad, 'idspiska' => $id, 'pages' => $pages, 'sort' => $sort]);
    }

    public function actionDelete($id){
        $post = Zadachi::findOne($id);
        if ($post!= null){
            $post = Zadachi::findOne($id)->delete();
            if ($post)
            {
                Yii::$app->session->addFlash('success', 'Задача успешно удалена!');
            }
        }
        return $this->redirect('/site/spisok');
    }


    public function actionCreate($id){

        $zad = new Zadachi();
        $zad->idspisok = $id;
        $zad->save();
        $formData = Yii::$app->request->post();

        if ($zad->load($formData))
        {

            if ($zad->save())
            {
                Yii::$app->session->addFlash('success', 'Задача успешно добавлена!');
                return $this->redirect(['/site/spisok']);
            }
            else
            {
                Yii::$app->getSession()->setFlash('message', "Failed");
            }
        }
        return $this->render('create', ['zad' => $zad]);
    }

    public function actionUpdate($id){

        $zad = Zadachi::findOne($id);
        if ($zad->load(Yii::$app->request->post()) && $zad->save())
        {
            Yii::$app->session->addFlash('success', 'Задача успешно изменена!');
            return $this->redirect(['/site/spisok/']);
        }
        else{
            return $this->render('update', ['zad' => $zad]);
        }
    }

}