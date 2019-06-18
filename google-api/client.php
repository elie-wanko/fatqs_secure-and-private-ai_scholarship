<?php
require 'globalvars.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
* @return \Google_Client
* @throws \Google_Exception
*/
function getClient($scopes)
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API');
    $client->setScopes($scopes);
    $client->setAuthConfig(json_decode(getenv('credentials'), true));
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    if (getenv('token')) {
        $accessToken = json_decode(getenv('token'), true);
        $client->setAccessToken($accessToken);
    }
    return $client;
}
