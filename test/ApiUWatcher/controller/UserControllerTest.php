<?php

namespace UWatcher\Controller;

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * @var UserController
     */
    private UserController $controller;

    protected function setUp()
    {
        $_SESSION["userId"] = 1;
        $this->controller = new UserController();
    }

    public function testGetStatisticListActon()
    {

    }

    public function testLogoutAction()
    {

    }

    public function testSignUpAction()
    {

    }

    public function testSetUrlWatcherAction()
    {
        $this->controller->setUrlWatcherAction("https://market.yandex.ru/product--protsessor-intel-core-i5-10400f/663773039?nid=55330&show-uid=16081405414590017266716001&context=search&onstock=1");
    }

    public function testSignInAction()
    {

    }
}
