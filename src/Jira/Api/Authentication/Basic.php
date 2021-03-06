<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 *## Basic class
 *
 * @author Alex Zet <zetdev@gmail.com>
 * @copyright 2013 Alex Zet <https://github.com/alexzv>
 * @license http://www.opensource.org/licenses/MIT MIT License
 * 
 * @package Jira\Api\Authentication
 * @since 1.0
 */

namespace Jira\Api\Authentication;

use Guzzle\Http\Client;
use Guzzle\Plugin\CurlAuth\CurlAuthPlugin;

class Basic implements AuthenticationInterface
{
    protected $_baseUrl;
    protected $_userId;
    protected $_password;
    protected $_client;

    public function __construct($base_url, $user_id, $password)
    {
        $this->_baseUrl = $base_url;
        $this->_userId  = $user_id;
        $this->_password = $password;
    }

    public function getCredentials()
    {
        return array($this->_userId, $this->_password);
    }

    public function getClient($token = false, $token_secret = false)
    {
        if (!is_null($this->_client)) {
            return $this->_client;
        } else {
            $this->_client = new Client($this->_baseUrl);
            $this->_client->addSubscriber(new CurlAuthPlugin($this->_userId, $this->_password));
            
            return $this->_client;
        }
    }
}
