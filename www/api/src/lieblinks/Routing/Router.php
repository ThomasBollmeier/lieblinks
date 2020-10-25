<?php
namespace TBollmeier\Lieblinks\Routing;

use tbollmeier\webappfound\routing\Router as BaseRouter;
use tbollmeier\webappfound\routing\RouterData;
use tbollmeier\webappfound\routing\ControllerData;
use tbollmeier\webappfound\routing\ActionData;
use tbollmeier\webappfound\routing\DefaultActionData;

class Router extends BaseRouter{
    public function __construct(
        $controllerNS = "",
        $baseUrl = "")
    {
        parent::__construct([
            "controllerNS" => $controllerNS,
            "defaultCtrlAction" => "HomeController.pageNotFound",
            "baseUrl" => $baseUrl ]);

        $routerData = new RouterData();

        $routerData->defaultAction = new DefaultActionData();
        $routerData->defaultAction->controllerName = "HomeController";
        $routerData->defaultAction->actionName = "pageNotFound";

        $routerData->controllers = [];

        $controller = new ControllerData();
        $controller->name = "BookmarkController";
    
        $action = new ActionData();
        $action->name = "read";
        $action->httpMethod = "GET";
        $action->pattern = "api\/bookmarks";
        $action->paramNames = [];
        $controller->actions[] = $action;
    
        $action = new ActionData();
        $action->name = "create";
        $action->httpMethod = "POST";
        $action->pattern = "api\/bookmarks";
        $action->paramNames = [];
        $controller->actions[] = $action;
    
        $action = new ActionData();
        $action->name = "update";
        $action->httpMethod = "PUT";
        $action->pattern = "api\/bookmarks\/(\d+)";
        $action->paramNames = ["bookmark_id"];
        $controller->actions[] = $action;
    
        $action = new ActionData();
        $action->name = "delete";
        $action->httpMethod = "DELETE";
        $action->pattern = "api\/bookmarks\/(\d+)";
        $action->paramNames = ["bookmark_id"];
        $controller->actions[] = $action;
    
        $routerData->controllers[] = $controller;

        $controller = new ControllerData();
        $controller->name = "PageInfoController";
    
        $action = new ActionData();
        $action->name = "getTitle";
        $action->httpMethod = "GET";
        $action->pattern = "api\/page\/title";
        $action->paramNames = [];
        $controller->actions[] = $action;
    
        $routerData->controllers[] = $controller;

        $this->setUpHandlers($routerData);
    }
}