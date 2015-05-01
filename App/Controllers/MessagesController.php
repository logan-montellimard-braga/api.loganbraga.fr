<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class MessagesController extends BaseController
{
    public function __construct()
    {
        parent::__construct('message');
    }

    public function createAction(Request $request, Application $app)
    {
        $res = parent::createAction($request, $app);
        if ($res->getStatusCode() === 200)
            self::sendMessageMail($request, $app);
        return $res;
    }

    private function sendMessageMail(Request $request, Application $app)
    {
        $params = $request->request->all();
        $date = date("Y/m/d à H:i");
        $body =<<<EOS
Nouveau message de «{$params['author']}» le {$date} :
===============================================

Titre
-----
    {$params['title']}

Message
-------
    {$params['content']}
EOS;

        $message = \Swift_Message::newInstance()
            ->setSubject('[loganbraga.fr] ' . $params['title'])
            ->setFrom($app['mail.from'])
            ->setTo($app['mail.to'])
            ->setBody($body);

        $app['mailer']->send($message);
    }
}
