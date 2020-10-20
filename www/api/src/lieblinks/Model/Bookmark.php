<?php


namespace TBollmeier\Lieblinks\Model;

use tbollmeier\webappfound\Session;


class Bookmark
{
    private static $instances = null;

    private $url;
    private $description;

    public static function readAll()
    {
        $ret = Session::getInstance()->get("bookmarks", "[]");

        $instancesData = json_decode($ret, true);
        self::$instances = [];

        foreach ($instancesData as $instData) {
            self::$instances[] = new Bookmark($instData['url'], $instData['description']);
        }

        return $ret;
    }

    public static function create($url, $description)
    {
        $ret = new Bookmark($url, $description);

        if (self::$instances === null) {
            self::readAll();
        }
        self::$instances[] = $ret;

        return $ret;
    }

    public static function saveAll()
    {
        $data = [];
        $bookmarks = self::getInstances();
        foreach ($bookmarks as $bookmark) {
            $data[] = [
                "url" => $bookmark->url,
                "description" => $bookmark->description
            ];
        }

        Session::getInstance()->bookmarks = json_encode($data);
    }

    private function __construct($url, $description)
    {
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