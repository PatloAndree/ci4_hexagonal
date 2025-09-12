<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

class Autoload extends AutoloadConfig
{
    public const SRCPATH = ROOTPATH . 'src/';

    public $psr4 = [
        APP_NAMESPACE => APPPATH,
        'Src'         => self::SRCPATH,
    ];

    public $helpers = [];
}