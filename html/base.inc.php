<?php
/**
 * Instantiates our "needs" so a single
 * reference will be needed instead of
 * all of this information on all pages
 * we create.
 *
 * PHP version 5
 *
 * @category base.inc.php
 * @package  SimpleCMS
 * @author   THEMCV <nah@nah.com>
 * @license linktolicense Simplenameforlicense
 * @link    https://github.com/themcv/phpsite
 */
/**
 * Instantiates our "needs" so a single
 * reference will be needed instead of
 * all of this information on all pages
 * we create.
 *
 * @category base.inc.php
 * @package  SimpleCMS
 * @author   THEMCV <nah@nah.com>
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
