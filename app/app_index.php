<?php


$app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig');
});

//Logout
$app->get("logout", function() use ($app) {
    logout();
    return $app->redirect("/");
});
