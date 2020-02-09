<?php
include_once(__DIR__ . '/CookieService.php');
include_once(__DIR__ . '/../models/User.php');

class AuthorizationService
{
    public $cookieService;

    function __construct()
    {
        $this->cookieService = new CookieService();
    }

    public function login(User $user)
    {
        return $this->cookieService->setCookie($user);
    }

    public function logout()
    {
        return $this->cookieService->removeCookie();
    }

    public function isLoggedIn()
    {
        return $this->cookieService->isCookieValid();
    }

    public function getLoggedInUser()
    {
        return $this->cookieService->getLoggedInUserFromCookie();
    }
}
