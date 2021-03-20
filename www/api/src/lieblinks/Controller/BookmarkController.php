<?php


namespace TBollmeier\Lieblinks\Controller;

use TBollmeier\Lieblinks\Model\Bookmark;
use tbollmeier\webappfound\http as http;


class BookmarkController
{
    public function read(http\Request $req, http\Response $res)
    {
        $bookmarks = Bookmark::readAll();
        $bookmarksData = array_map([$this, 'createBookmarkData'], $bookmarks);

        $res->setResponseCode(200);
        $res->setHeader("Content-Type", "application/json");
        $res->setBody(json_encode($bookmarksData));
        $res->send();
    }

    private function createBookmarkData(Bookmark $bookmark) {
        return [
            'url' => $bookmark->getUrl(),
            'description' => $bookmark->getDescription(),
            'links' => [
                'bookmark' => "api/bookmarks/" . $bookmark->getId()
            ]
        ];
    }

    public function create(http\Request $req, http\Response $res)
    {
        $data = json_decode($req->getBody());

        $newBookmark = Bookmark::create($data->url, $data->description);

        $res->setResponseCode(201);
        $res->setBody(json_encode($this->createBookmarkData($newBookmark)));
        $res->send();
    }

    public function update(http\Request $req, http\Response $res)
    {
        $bookmarkId = intval($req->getUrlParams()['bookmark_id']);
        $data = json_decode($req->getBody());

        $changedBookmark = Bookmark::update(
            $bookmarkId,
            $data->url,
            $data->description);

        if ($changedBookmark !== null) {
            $res->setBody(json_encode($this->createBookmarkData($changedBookmark)));
        } else {
            $res->setResponseCode(404);
        }

        $res->send();

    }

    public function delete(http\Request $req, http\Response $res)
    {
        $bookmarkId = intval($req->getUrlParams()['bookmark_id']);
        Bookmark::delete($bookmarkId);

        $res->send();
    }

}