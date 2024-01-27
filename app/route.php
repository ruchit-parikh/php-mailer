<?php

namespace App\Http;

use App\Subscribers\Http\Requests\StoreSubscriberFormRequest;
use App\Subscribers\Http\Controllers\SubscribersController;
use Mailer\Http\Kernel;

$router = Kernel::getInstance()->getRouter();

$router->get('/subscribers/{subscriber}', [SubscribersController::class, 'show']);
$router->post('/subscribers', [SubscribersController::class, 'post'], StoreSubscriberFormRequest::class);
$router->get('/subscribers', [SubscribersController::class, 'index']);
