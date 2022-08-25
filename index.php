<?php
//declare(strict_types=1);

require_once __DIR__ . '././vendor/autoload.php';

use App\Router;
use App\Handler\Contact;
$router = new Router();

$router->get('/', function () {
    echo "Home page";
});

$router->get('/about-us', function (array $params = []) {
    echo "About Us page";
    if (!empty($params['username'])){
        echo '<h1> Hello ' . $params['username'] . '</h1>';
    }
});

$router->get('/contact-us', Contact::class . '::execute');
$router->post('/contact-us', function ($params){
    var_dump($params);
});

$router->addNotFoundHandler(function () {
    $title = "The Page you're trying to access is NOT Found!";
    require_once __DIR__ . '././templates/404.phtml';
});

$router->run();
