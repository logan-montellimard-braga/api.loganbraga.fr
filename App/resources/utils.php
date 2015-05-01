<?php

$app['util.getController'] = $app->protect(function ($abbr) {
    list($class, $method) = explode('::', $abbr, 2);
    return sprintf('App\Controllers\%sController::%sAction', ucfirst($class), $method);
});

$app['util.getStatusCode'] = $app->protect(function ($n) {
    switch ($n) {
    case 0:
        $code = 400;
        break;
    case 1:
        $code = 200;
        break;
    default:
        $code = 500;
        break;
    }
    return $code;
});

$app['util.escapeAll'] = $app->protect(function ($el) use ($app) {
    if (is_array($el) || is_object($el)) {
        foreach ($el as $key => &$value) {
            $value = $app->escape($value);
        }
    } else {
        $el = $app->escape($el);
    }
    return $el;
});
