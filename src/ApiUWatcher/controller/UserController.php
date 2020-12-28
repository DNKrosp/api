<?php

namespace UWatcher\Controller;

use Database\ConnectionSingleton;
use Server\Controller;
use Server\Response;
use UWatcher\Helper\Crypt;
use UWatcher\Query\UserQuery;

class UserController extends Controller
{
    public function setUrlWatcherAction($url)
    {
        $result = "";
        $status = true;
        $connect = ConnectionSingleton::getPgConnect();
        $urlInfo = parse_url($url);
        $resourceId = $connect->query(UserQuery::findByName("findResourceByHost"), ["host"=>$urlInfo["host"]]);
        if (count($resourceId) == 1)
        {
            $resourceId = $resourceId[0]["id"];

            $id = $connect->query(UserQuery::findByName("setWatchUrl"), [
                "tst"=>time(),
                "resourceId"=>$resourceId,
                "userId"=>$_SESSION["userId"],
                "path"=>$urlInfo["path"],
                "query"=>$urlInfo["query"]]
            );

            if (count($id) !== 1)
            {
                $status = false;
                $result = "create error";
            } else
                $result = $id[0]["id"];

        } else
            if ($status = false)
                $result = "resource not found";

        return Response::message($result, $status);
    }

    public function getStatisticListActon()
    {

    }

    public function logoutAction()
    {
        session_abort();
        return Response::message("goodbie");
    }

    public function signInAction($login, $password)
    {
        $result = "";
        $status = true;
        $connect = ConnectionSingleton::getPgConnect();

        $id = $connect->query(UserQuery::findByName("getUserFromLogin"), ["login"=>$login]);
        if (count($id) == 1)
        {
            $id = $id[0]["id"];
            $passwordData = $connect->query(UserQuery::findByName("getAuth"), ["id"=>$id]);
            if (count($passwordData) == 1)
            {
                $hash = $passwordData["pwd"];
                $salt = $passwordData["salt"];

                if (Crypt::assertPassword($password, $salt, $hash))
                {
                    $result = "welcome";
                    $_SESSION["userId"] = $id;
                } else
                {
                    $result = "error";
                    $status = false;
                }
            }
        }

        return Response::message($result, $status);
    }

    public function signUpAction($login, $password)
    {
        $status = true;

        $connect = ConnectionSingleton::getPgConnect();

        $findLogin = $connect->query(UserQuery::findByName("findByNickname"), ["login"=>$login]);

        if(count($findLogin) == 0)
        {
            $placeholder = [];
            $placeholder["salt"] = Crypt::generateSalt();
            $placeholder["login"] = $login;
            $placeholder["pwd"] = Crypt::getHash($password, $placeholder["salt"]);
            $placeholder["createTst"] = time();
            $message = $connect->query(UserQuery::findByName("createUser"), $placeholder);
            $_SESSION["userId"] = $message[0]["id"];
        } else {
            $message = "login is exist";
            $status = false;
        }

        return Response::message($message, $status);
    }
}