<?php


namespace TBollmeier\Lieblinks\Controller;

use tbollmeier\webappfound\http as http;


class PageInfoController
{
    public function getTitle(http\Request $req, http\Response $res)
    {
        $title = "";

        $url = $req->getQueryParams()['url'];
        $html = @file_get_contents($url);

        if ($html !== false) {

            preg_match("#<title>([^<]+)</title>#m", $html, $matches);

            if ($matches !== false) {
                $title = trim($matches[1]);
            }

        }

        $res->setResponseCode(200);
        $res->setHeader("Content-Type", "text/plain");
        $res->setBody($title);
        $res->send();
    }
}