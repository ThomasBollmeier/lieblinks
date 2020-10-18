@echo off
php ..\www\api\src\vendor\tbollmeier\webappfound\bin\router_generate.php ^
	--namespace=TBollmeier\Lieblinks\Routing ^
	--name=Router ^
	--base-alias=BaseRouter ^
	-o ..\www\api\src\lieblinks\Routing\Router.php ^
	.\controllers