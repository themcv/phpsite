<?php
/**
 * The index referenced.
 *
 * PHP version 5
 *
 * category Index
 * package  SimpleCMS
 * author   THEMCV <nah@nah.com>
 * @license linktolicense Simplenameforlicense
 * @link    https://github.com/themcv/phpsite
 */
/**
 * The index referenced.
 *
 * category Index
 * package  SimpleCMS
 * author   THEMCV <nah@nah.com>
 * @license linktolicense Simplenameforlicense
 * @link    https://github.com/themcv/phpsite
 */
/**
 * We need to pull in the configuration file.
 */
define('BASEPATH', dirname(__FILE__));
if (!file_exists(BASEPATH.DIRECTORY_SEPARATOR.'config.inc.php')) {
    printf(
        '%s. %s. %s: %s%s%s %s: %s%s%s',
        _('Configuration has not been setup'),
        _('You need to create your config.inc.php'),
        _('This can be done by editing'),
        BASEPATH,
        DIRECTORY_SEPARATOR,
        'config.inc.php',
        _('An example config file can be found at'),
        BASEPATH,
        DIRECTORY_SEPARATOR,
        'config-example.inc.php'
    );
    exit;
}
require 'config.inc.php';
/**
 * Because you have to start somewhere, we must include our class first.
 * In more complex setups you would want an "autoloader".
 */
require 'simpleCMS.php';
/**
 * Instantiate the simple cms class.
 */
$SimpleCMS = new SimpleCMS();
$body = SimpleCMS::tag(
    'body',
    $SimpleCMS->displayPublic()
);
/**
 * Because of how I created the tag funciton we can call it outside the scope of the
 * instantiated class object.
 *
 * To think about, however, is a simpler means to include tags maybe.
 */
echo SimpleCMS::tag(
    'html',
    $body
);
