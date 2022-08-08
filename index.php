<?php

require_once "controller/template.controller.php";
require_once "controller/administradores.controller.php";
require_once "controller/destination.controller.php";

require_once "model/ID90Api.php";
require_once "model/admin.model.php";
require_once "model/destination.model.php";

ID90Api::init('https://beta.id90travel.com');

$templeate = new TemplateController();
$templeate->templeate();