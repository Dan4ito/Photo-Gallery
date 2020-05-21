<?php
include_once(__DIR__ . '/CookieService.php');
include_once(__DIR__ . '/LoginValidationService.php');
include_once(__DIR__ . '/../models/User.php');

include_once('../../Data Layer/repositories/UserRepository.php');

class AuthorizationService
{
    public $cookieService;

    function __construct()
    {
        $this->cookieService = new CookieService();
        $this->userRepository = new UserRepository();
        $this->loginValidationService = new LoginValidationService();
    }

    public function login($loginCredentials)
    {
        ($this->loginValidationService)->validateCredentials($loginCredentials);
        $user = ($this->userRepository)->GetByEmail($loginCredentials->email);
        if ($user->id == null) {
            throw new Exception("Invalid credentials. No such email registered.", 400);
        }

        $dbPassword = $user->password;
        if(!password_verify($loginCredentials->password, $dbPassword)) {
            throw new Exception("Invalid credentials. Password is incorrect.", 400);
        }

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
