<?php

class UrlService
{
    private $url;
    private $parsedUrl;
    private $queryParams;

    function __construct()
    {
        $this->url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->parsedUrl = parse_url($this->url);
        $this->queryparams = parse_str(parse_url($this->url, PHP_URL_QUERY), $this->queryParams);
    }

    public function GetQueryParam(string $queryParamName)
    {
        return $this->queryParams[$queryParamName];
    }
}
