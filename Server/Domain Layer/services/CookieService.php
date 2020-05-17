<?php
include_once('../../Data Layer/repositories/UserRepository.php');

class CookieService
{

    public $userRepository;

    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function setCookie(User $user)
    {
        $cookie = base64_encode("$user->email:" . md5($user->password));
        setcookie('loginInfo', $cookie, time() + 3600, '/', NULL, NULL, TRUE);
        $loginInfoToDisplay = $user->username; //. '(' . $user->roleId . ')';
        setcookie('loginInfoToDisplay', $loginInfoToDisplay, time() + 3600, '/');
    }

    public function removeCookie()
    {
        if (isset($_COOKIE['loginInfo']) && !empty(isset($_COOKIE['loginInfo']))) {
            $cookie = $_COOKIE['loginInfo'];
            $decodedCookie = base64_decode($cookie);
            list($userEmail, $hashed_password) = explode(':', $decodedCookie);
            $loggedUser = $this->userRepository->GetByEmail($userEmail);
            setcookie('loginInfo', '', time() - 3600, '/');
            setcookie('loginInfoToDisplay', '', time() - 3600, '/');
        } else {
            throw new Exception("No user is logged in!", 400);
        }
    }

    public function isCookieValid()
    {
        if (!isset($_COOKIE['loginInfo'])) {
            return false;
        }
        $cookie = $_COOKIE['loginInfo'];
        $decodedCookie = base64_decode($cookie);
        list($userEmail, $hashed_password) = explode(':', $decodedCookie);
        // here you need to fetch real password from database based on email. ($password)
        $dbUser = $this->userRepository->GetByEmail($userEmail);
        $password = $dbUser->password;
        if (md5($password) != $hashed_password) {
            throw new Exception("Wrong cookie");
        }
        return true;
    }

    public function getCookieValue($cookieName)
    {
        return $_COOKIE[$cookieName];
    }

    public function getLoggedInUserFromCookie()
    {

        $cookie = $_COOKIE['loginInfo'];
        $decodedCookie = base64_decode($cookie);
        list($userEmail, $hashed_password) = explode(':', $decodedCookie);

        $dbUser = $this->userRepository->GetByEmail($userEmail);
        return $dbUser;
    }
}
