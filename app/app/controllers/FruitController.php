<?php
namespace app\controllers;
use yii\httpclient\Client;
use app\models\Fruit;
use app\models\Nutrition;
use yii\web\Controller;
// Send a GET request to the API URL to fetch the fruit data
class FruitController extends Controller
{

    public function actionIndex()
    {
    $client = new Client();
    $response = $client->createRequest()
    ->setMethod('GET')
    ->setUrl('https://fruityvice.com/api/fruit/all')
    ->send();

// Parse the JSON response and loop through each fruit object
if ($response->isOk) {
    $fruitsData = $response->getData();
    foreach ($fruitsData as $fruitData) {
        // Create a new Fruit object and set its properties
        $fruit = new Fruit();
        $fruit->genus = $fruitData['genus'];
        $fruit->name = $fruitData['name'];
        $fruit->Fruit_Id = $fruitData['id'];
        $fruit->family = $fruitData['family'];
        $fruit->order = $fruitData['order'];
        // Save the Fruit object to the database
        $fruit->save();
        // Create a new Nutrition object and set its properties
        $nutrition = new Nutrition();
        $nutrition->carbohydrates = $fruitData['nutritions']['carbohydrates'];
        $nutrition->protein = $fruitData['nutritions']['protein'];
        $nutrition->fat = $fruitData['nutritions']['fat'];
        $nutrition->calories = $fruitData['nutritions']['calories'];
        $nutrition->sugar = $fruitData['nutritions']['sugar'];
        $nutrition->fruit_FK_Id = $fruit->id;
        // Save the Nutrition object to the database
        $nutrition->save();
    }
}




    }


    public function actionAbout()
    {
        return $this->render('about');
    }
}