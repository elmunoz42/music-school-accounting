<?php


$app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig');
})
->after($save_location_uri);

//Logout
$app->get("logout", function() use ($app) {
    logout();
    return $app->redirect("/");
});
