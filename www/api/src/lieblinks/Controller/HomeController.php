<?php


namespace TBollmeier\Lieblinks\Controller;

use tbollmeier\webappfound\http as http;


class HomeController
{
    public function pageNotFound(http\Request $req, http\Response $res)
    {
        $res->setResponseCode(404);
        $res->send();
    }

}