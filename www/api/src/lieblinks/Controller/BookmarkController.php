<?php


namespace TBollmeier\Lieblinks\Controller;

use TBollmeier\Lieblinks\Model\Bookmark;
use tbollmeier\webappfound\http as http;


class BookmarkController
{
    public function read(http\Request $req, http\Response $res)
    {
        $bookmarksJson = Bookmark::readAll();

        $res->setResponseCode(200);
        $res->setHeader("Content-Type", "application/json");
        $res->setBody($bookmarksJson);
        $res->send();
    }

    public function create(http\Request $req, http\Response $res)
    {
        $data = json_decode($req->getBody());
        Bookmark::create($data->url, $data->description);
        Bookmark::saveAll();

        $res->setResponseCode(201);
        $res->send();
    }

    public function update(http\Request $req, http\Response $res)
    {

    }

    public function delete(http\Request $req, http\Response $res)
    {

    }

}