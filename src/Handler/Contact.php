<?php


namespace App\Handler;


class Contact
{
    public function execute(array $params = []) {
        $username = isset($params['username']) ? $params['username'] : 'Guest';
        require_once __DIR__ . './../../templates/contact.phtml';
    }
}