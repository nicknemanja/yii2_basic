<?php

namespace app\controllers;

use Yii;
use app\models\Feed;
use app\models\FeedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

/**
 * FeedController implements the CRUD actions for Feed model.
 */
class FeedController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
    	return [
    	'verbs' => [
    	'class' => VerbFilter::className(),
    	'actions' => [
    	'delete' => ['POST'],
    	],
    	],
    	];
    }

    /**
     * Lists all Feed models.
     * @return mixed
     */
    public function actionIndex()
    {
    	/*
        $searchModel = new FeedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        */

        $pageTitle = "Home";
        return $this->renderRssPage($pageTitle);
    }

    /**
     * Displays a single Feed model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	return $this->render('view', [
    		'model' => $this->findModel($id),
    		]);
    }

    /*
	*Action metode za obradu ruta
	*@param empty
	*@return mixed
    */

	public function actionScience(){
		$pageTitle = "Science";
		return $this->renderRssPage($pageTitle);
	}

	public function actionTech(){
		$pageTitle = "Tech";
		return $this->renderRssPage($pageTitle);
	}

	public function actionWorld(){
		$pageTitle = "World";
		return $this->renderRssPage($pageTitle);
	}

	public function actionPolitics(){
		$pageTitle = "Politics";
		return $this->renderRssPage($pageTitle);
	}

	public function actionHealth(){
		$pageTitle = "Health";
		return $this->renderRssPage($pageTitle);
	}

	public function renderRssPage($pageTitle){
		//default page num for pagination
		$page = Yii::$app->request->get('page',1);
		
		$dataKey = 'category_' . $pageTitle . '_page_' . $page;
		$sizeKey = 'category_' . $pageTitle . '_size';

		$data = Yii::$app->cache->get($dataKey);

		

		$isDataCached = true;

		if($data == false){
			$isDataCached = false;
		}

		var_dump('isDataCached', $isDataCached);


		//var_dump('CACHE', Yii::$app->cache);

		if(! $isDataCached){
			//data not found in cache
			if($pageTitle != 'Home'){
				$data = Feed::find()
				->join('JOIN','feed_type','feed.type_id = feed_type.id ')
				->where('feed_type.title = :type_title', array(':type_title ' => $pageTitle))
				->orderBy(['date_posted' => SORT_DESC]);
			}else{
				//home category
				$data = Feed::find()
				->orderBy(['date_posted' => SORT_DESC]);
			}
			var_dump('DATA',$data);
			//save data to cache
			$data_size = $data->count();

			var_dump('Broj feed-ova:', $data_size);

		}else{
			//data found in cache
			$data_size = Yii::$app->cache->get($sizeKey);
		}

		$pagination = new Pagination([
			'defaultPageSize' => 6,
			'totalCount' => $data_size,
		]);

		var_dump("Offset i limit:",$pagination->offset, $pagination->limit);

		if(!isDataCached){
			$feeds = $data->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

			Yii::$app->cache->set($data_key, $feeds);
			//if(Yii::$app->cache->get($size_key) === false){
				Yii::$app->cache->set($size_key, $data_size);
			//}
		}else{
			$feeds = $data;
		}

		var_dump('Zahtevani feedovi na kontroleru',$feeds);
		die();

		return $this->render('index', [
			'feeds' => $feeds,
			'pagination' => $pagination,
			"pageTitle" => $pageTitle,
		]);
	}

    /**
     * Creates a new Feed model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new Feed();

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->id]);
    	} else {
    		return $this->render('create', [
    			'model' => $model,
    			]);
    	}
    }

    /**
     * Updates an existing Feed model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->id]);
    	} else {
    		return $this->render('update', [
    			'model' => $model,
    			]);
    	}
    }

    /**
     * Deletes an existing Feed model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$this->findModel($id)->delete();

    	return $this->redirect(['index']);
    }

    /**
     * Finds the Feed model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feed the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = Feed::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
}
