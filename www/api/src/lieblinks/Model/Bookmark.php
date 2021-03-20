<?php


namespace TBollmeier\Lieblinks\Model;

use tbollmeier\webappfound\Session;


class Bookmark
{
    private static $instances = null;

    private $id;

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getDescription()
    {
        return $this->description;
    }

    private $url;
    private $description;

    public static function readAll()
    {
        $bookmarksJson = Session::getInstance()->get("bookmarks", "[]");

        $instancesData = json_decode($bookmarksJson, true);
        self::$instances = [];

        foreach ($instancesData as $instData) {
            self::$instances[] = new Bookmark(
                $instData['id'],
                $instData['url'],
                $instData['description']);
        }

        return self::$instances;
    }

    public static function read($id) {

        if (self::$instances === null) {
            self::readAll();
        }

        foreach (self::$instances as $bookmark) {
            if ($bookmark->id === $id) {
                return $bookmark;
            }
        }

        return null;
    }

    public static function create($url, $description)
    {
        $session = Session::getInstance();
        $nextId = $session->get("nextId", 1);

        $ret = new Bookmark($nextId, $url, $description);

        $session->nextId = $nextId + 1;

        if (self::$instances === null) {
            self::readAll();
        }

        self::$instances[] = $ret;
        self::saveAll();

        return $ret;
    }

    public static function update($id, $newUrl, $newDescription) {

        $ret = null;
        $bookmark = self::read($id);

        if ($bookmark !== null) {
            $bookmark->url = $newUrl;
            $bookmark->description = $newDescription;
            $ret = $bookmark;
        }

        self::saveAll();

        return $ret;
    }

    public static function delete($id)
    {
        if (self::$instances === null) {
            self::readAll();
        }

        self::$instances = array_filter(self::$instances, function($bookmark) use ($id) {
            return $bookmark->getId() !== $id;
        });

        self::saveAll();
    }

    public static function saveAll()
    {
        $data = [];
        $bookmarks = self::getInstances();
        foreach ($bookmarks as $bookmark) {
            $data[] = [
                "id" => $bookmark->id,
                "url" => $bookmark->url,
                "description" => $bookmark->description
            ];
        }

        Session::getInstance()->bookmarks = json_encode($data);
    }

    private function __construct($id, $url, $description)
    {
        $this->id = $id;
        $this->url = $url;
        $this->description = $description;
    }

    private static function getInstances()
    {
        if (self::$instances === null) {
            self::readAll();
        }

        return self::$instances;
    }
}