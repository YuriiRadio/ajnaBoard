<?php

namespace app\modules\user\controllers;

use Yii;
use app\models\Advert;
use app\modules\user\models\AdvertSearch;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use app\models\AdvertImage;
use yii\web\UploadedFile;

/**
 * AdvertsController implements the CRUD actions for Adverts model.
 */
class AdvertController extends AppUserController
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
     * Lists all Adverts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdvertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adverts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
//            'images' => AdvertImage::find()
//                                    ->where(['advert_id' => $id])
//                                    ->orderBy(['is_main' => SORT_ASC])
//                                    ->all(),
        ]);
    }

    /**
     * Creates a new Adverts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Advert();

        if ($model->load(Yii::$app->request->post())) {

            # Встановлюємо кінцеву дату публікації та користувача
            $model->end_publication = add_month(time());
            $model->user_id = Yii::$app->user->identity->id;
            $model->title = \yii\helpers\Html::encode($model->title);
            $model->body = \yii\helpers\HtmlPurifier::process($model->body);

            if ($model->save()) {
                // Завантажуємо файли якщо модель верифікована та збережена
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                $countImagesload = count($model->imageFiles);
                // перевіряємо кількість картинок
                if ($countImagesload > 5) {
                    Yii::$app->session->setFlash('error', 'The maximum number of images can not be more 5!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                $flagMain = true;
                foreach ($model->imageFiles as $file) { // Перебираємо всі файли та зберігаємо
                    if ($flagMain) {
                        $this->saveResizeImage($model->id, $file->tempName, 1);
                        $flagMain = false;
                    }
                    $this->saveResizeImage($model->id, $file->tempName);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } else { return 'fack advert!!!';}
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Adverts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->identity->id) {
            $images = AdvertImage::find()->where(['advert_id' => $id])->all();
            if ($model->load(Yii::$app->request->post())) {
                $model->title = \yii\helpers\Html::encode($model->title);
                $model->body = \yii\helpers\HtmlPurifier::process($model->body);
                if ($model->save()) {
                    // Завантаження файлів
                    $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                    $countImagesModel = count($images);
                    $countImagesload = count($model->imageFiles);
                    // перевіряємо кількість картинок
                    if ($countImagesModel + $countImagesload > 5) {
                        Yii::$app->session->setFlash('error', 'The maximum number of images can not be more 5!');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    // Якщо все добре завантажуємо файли
                    foreach ($model->imageFiles as $file) { // Перебираємо всі файли
                        $this->saveResizeImage($model->id, $file->tempName);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                } else { return 'fack advert!!!';}
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'images' => $images
                ]);
            }
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * Deletes an existing Adverts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->user_id == Yii::$app->user->identity->id) { // for user
            if ($result = $this->deleteAllImages($model->id)) {
                $model->delete();
            }
            return $this->redirect(['index']);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * Finds the Adverts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adverts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advert::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDelImage($img_id) {
        $img_id = intval($img_id);
        $model = AdvertImage::findOne(['id' => $img_id]);
        //if ($model !== null) { // for admin
        if ($model->advert->user_id == Yii::$app->user->identity->id) { // for user
            $dir = Yii::getAlias('uploads/adverts/');
            //debug($model); die;
            @unlink($dir.$model->img_src);
            @unlink($dir.'thumbs/'.$model->img_src_thumb);
            $flagNextMain = false;
            if ($model->is_main == 1) { $flagNextMain = true; }
            $model->delete();
            if ($flagNextMain) {
                if ($modelNextMain = AdvertImage::findOne(['advert_id' => $model->advert_id])) {
                    $modelNextMain->is_main = 1;
                    $modelNextMain->save();
                }
            }
            return $this->redirect(['update', 'id' => $model->advert_id]);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * Видаляє всі картинки оголошення
     * @param integer $advert_id
     * @return boolean/null
     */
    private function deleteAllImages($advert_id = null) {
        if (is_null($advert_id)) { return false; }
        $advert_id = intval($advert_id);
        $images = AdvertImage::findAll(['advert_id' => $advert_id]);
        //debug($images); die;
        if (count($images) > 0) {
            $dir = Yii::getAlias('uploads/adverts/');
            foreach ($images as $image) {
                @unlink($dir.$image->img_src);
                @unlink($dir.'thumbs/'.$image->img_src_thumb);
            }
            return AdvertImage::deleteAll(['advert_id' => $advert_id]) ? true: false;
        } else {
            return true;
        }
    }

    public function actionSetMainImage($img_id) {
        $img_id = intval($img_id);
        $model = AdvertImage::findOne(['id' => $img_id]);
        //if ($model !== null) { // for admin
        if ($model->advert->user_id == Yii::$app->user->identity->id) { // for user
            if (($modelMainImg = AdvertImage::findOne(['advert_id' => $model->advert_id, 'is_main' => 1])) !== null) {
                $modelMainImg->is_main = 0;
                $modelMainImg->save();
            }
            $model->is_main = 1;
            $model->save();
            return $this->redirect(['update', 'id' => $model->advert_id]);
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * Завантажує малюнок
     * @return Boolean
     */
    private function saveResizeImage($item_id = null, $tempName, $is_main = 0, $img_alt = '') {

        if (is_null($item_id)) {
            return false;
        }

        $image_info = getimagesize($tempName);
        if (($image_info['mime'] == 'image/gif') || ($image_info['mime'] == 'image/jpeg') || ($image_info['mime'] == 'image/png') || ($image_info['mime'] == 'image/bmp')) {

            // Директорії для завантаження фото
            $dir = Yii::getAlias('uploads/adverts/');
            $upload_dir_image = $dir;
            $upload_dir_image_thumbs = $dir.'thumbs/';

            // Визначаємо яке буде розширення у файла - $img_ext
            switch ($image_info['mime']) {
                case 'image/bmp' : $img_ext = ".bmp";
                    break;
                case 'image/gif' : $img_ext = ".gif";
                    break;
                case 'image/jpeg': $img_ext = ".jpg";
                    break;
                case 'image/png' : $img_ext = ".png";
                    break;
                default : return false;
            }

            // Створюємо імя для файла
            $time_random = time() . mt_rand(0000, 9999);
            $image_src = $item_id . '-' . $time_random . $img_ext;
            $image_src_thumb = $item_id . '-' . $time_random . '-thumb' . $img_ext;

            $upload_image = $upload_dir_image . $image_src;
            $upload_image_thumbs = $upload_dir_image_thumbs . $image_src_thumb;

            $width = 800;
            $height = 800;

            $width_thumbs = 100;
            $height_thumbs = 100;

            switch ($image_info['mime']) {
                case 'image/bmp' : $image = imagecreatefromwbmp($tempName);
                    break;
                case 'image/gif' : $image = imagecreatefromgif($tempName);
                    break;
                case 'image/jpeg': $image = imagecreatefromjpeg($tempName);
                    break;
                case 'image/png' : $image = imagecreatefrompng($tempName);
                    break;
                default : return false;
            }

            // Для $upload_image
            // Воконуємо якісь розрахунки
            if ($image_info[0] < $width and $image_info[1] < $height) {//"Picture is too small!"
                //"Picture is too small!"
                return false;
            }
            $ratio = min($width / $image_info[0], $height / $image_info[1]);
            $width = $image_info[0] * $ratio;
            $height = $image_info[1] * $ratio;
            $x = 0;

            $new = imagecreatetruecolor($width, $height);

            if ($image_info['mime'] == "image/gif" or $image_info['mime'] == "image/png") {
                imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
                imagealphablending($new, false);
                imagesavealpha($new, true);
            }

            imagecopyresampled($new, $image, 0, 0, $x, 0, $width, $height, $image_info[0], $image_info[1]);

            switch ($image_info['mime']) {
                case 'image/bmp' : imagewbmp($new, $upload_image);
                    break;
                case 'image/gif' : imagegif($new, $upload_image);
                    break;
                case 'image/jpeg': imagejpeg($new, $upload_image);
                    break;
                case 'image/png' : imagepng($new, $upload_image);
                    break;
            }

            // Тепер для $upload_image_thumbs
            // Воконуємо якісь розрахунки
            $ratio = min($width_thumbs / $image_info[0], $height_thumbs / $image_info[1]);
            $width_thumbs = $image_info[0] * $ratio;
            $height_thumbs = $image_info[1] * $ratio;
            $x = 0;

            // Звільняємо память
            imagedestroy($new);

            $new = imagecreatetruecolor($width_thumbs, $height_thumbs);

            if ($image_info['mime'] == "image/gif" or $image_info['mime'] == "image/png") {
                imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
                imagealphablending($new, false);
                imagesavealpha($new, true);
            }

            imagecopyresampled($new, $image, 0, 0, $x, 0, $width_thumbs, $height_thumbs, $image_info[0], $image_info[1]);

            switch ($image_info['mime']) {
                case 'image/bmp' : imagewbmp($new, $upload_image_thumbs);
                    break;
                case 'image/gif' : imagegif($new, $upload_image_thumbs);
                    break;
                case 'image/jpeg': imagejpeg($new, $upload_image_thumbs);
                    break;
                case 'image/png' : imagepng($new, $upload_image_thumbs);
                    break;
            }

            // Звільняємо память
            imagedestroy($new);
            imagedestroy($image);

            $model = new AdvertImage();
            $model->advert_id = $item_id;
            $model->is_main = $is_main;
            $model->img_src = $image_src;
            $model->img_src_thumb = $image_src_thumb;
            $model->img_alt = $img_alt;

            if ($model->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
