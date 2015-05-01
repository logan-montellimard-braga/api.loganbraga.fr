<?php
namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ExperiencesController extends BaseController
{
    public function __construct()
    {
        parent::__construct('experience');
    }
}
