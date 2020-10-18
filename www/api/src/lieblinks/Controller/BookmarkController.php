<?php


namespace TBollmeier\Lieblinks\Controller;

use tbollmeier\webappfound\http as http;


class BookmarkController
{
    public function read(http\Request $req, http\Response $res)
    {
        $bookmarks = [
            [
                "url" => "http://coursera.org",
                "description" => "Lernportal"
            ]
        ];

        $res->setResponseCode(200);
        $res->setHeader("Content-Type", "application/json");
        $res->setBody(json_encode($bookmarks));

        $res->send();
    }

    public function create(http\Request $req, http\Response $res)
    {

    }

    public function update(http\Request $req, http\Response $res)
    {

    }

    public function delete(http\Request $req, http\Response $res)
    {

    }

}