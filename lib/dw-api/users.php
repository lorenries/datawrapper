<?php

/*
 * get list of all users
 * @needs admin
 */
$app->get('/users', function() use ($app) {
    $users = UserQuery::create()->find();
    $res = array();
    foreach ($users as $user) {
        $res[] = $user->toArray();
    }
    $app->render('json-ok.php', $res);
});


/*
 * create a new user
 */
$app->post('/users', function() use ($app) {
    $data = json_decode($app->request()->getBody());

    $user = new User();
    $user->setCreatedAt(time());
    $user->setEmail($data->email);
    $user->setPwd($data->pwd);
    $user->save();
    $result = $user->toArray();
    $app->render('json-ok.php', array($result));
});


/*
 * update an existing user
 * @needs admin or existing user
 */
$app->put('/users/:id', function($user_id) use ($app) {
    $data = json_decode($app->request()->getBody());
    $user = new User();
    $user->setCreatedAt(time());
    $user->setEmail($data->email);
    $user->setPwd($data->pwd);
    $user->save();

    $result = $user->toArray();
    unset($result['Pwd']); // never transmit the password to the client

    $app->render('json-ok.php', array($result));
});