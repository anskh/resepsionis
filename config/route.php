<?php

declare(strict_types=1);

use App\Handler\{
    HomeController,
    GuestController,
    LoginAction,
    SurveyController,
    LogoutAction,
    AdminController
};

// $resources => [
//    $permission => [$method, $path, $handler];
//];
return [
    "home" => ["GET", "/", [HomeController::class, "index"]],
    "login" => [["GET","POST"], "/login", LoginAction::class],
    "logout" => ["GET", "/logout", LogoutAction::class],
    "list_guest" => ["GET", "/guest", [GuestController::class, "index"]],
    "view_guest" => ["GET", "/guest/{id:\d+}", [GuestController::class, "view"]],
    "create_guest" => [["GET","POST"], "/guest/create", [GuestController::class, "create"]],
    "create_survey" => ["GET", "/survey/create", [SurveyController::class, "create"]],
    "feedback_sangat" => ["GET", "/survey/create/sangat", [SurveyController::class, "sangat"]],
    "feedback_puas" => ["GET", "/survey/create/puas", [SurveyController::class, "puas"]],
    "feedback_cukup" => [["GET","POST"], "/survey/create/cukup", [SurveyController::class, "cukup"]],
    "feedback_tidak" => [["GET","POST"], "/survey/create/tidak", [SurveyController::class, "tidak"]],
    "admin"=>["GET", "/admin", AdminController::class],
    "admin_list_user"=>["GET", "/admin/user", [AdminController::class, "listUser"]],
    "admin_list_guest"=>["GET", "/admin/guest", [AdminController::class, "listGuest"]],
    "admin_list_survey"=>["GET", "/admin/survey", [AdminController::class, "listSurvey"]],
    "admin_view_guest"=>["GET", "/admin/guest/{id:\d+}", [AdminController::class, "viewGuest"]],
    "admin_edit_guest"=>[["GET","POST"], "/admin/guest/edit/{id:\d+}", [AdminController::class, "editGuest"]],
    "admin_create_guest"=>[["GET","POST"], "/admin/guest/create", [AdminController::class, "createGuest"]],
    "admin_remove_guest"=>["POST", "/admin/guest/delete/{id:\d+}", [AdminController::class, "removeGuest"]],
    "admin_create_user"=>[["GET","POST"], "/admin/user/create", [AdminController::class, "createUser"]],
    "admin_edit_user"=>[["GET","POST"], "/admin/user/edit/{id:\d+}", [AdminController::class, "editUser"]],
    "admin_remove_user"=>["POST", "/admin/user/delete/{id:\d+}", [AdminController::class, "removeUser"]],
    "admin_remove_survey"=>["POST", "/admin/survey/delete/{id:\d+}", [AdminController::class, "removeSurvey"]]
];