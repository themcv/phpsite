<?php
/**
 * The index referenced.
 *
 * PHP version 5
 *
 * @category Index
 * @package  SimpleCMS
 * @author   THEMCV <nah@nah.com>
 * @license  linktolicense Simplenameforlicense
 * @link     https://github.com/themcv/phpsite
 */
/**
 * The index referenced.
 *
 * @category Index
 * @package  SimpleCMS
 * @author   THEMCV <nah@nah.com>
 * @license  linktolicense Simplenameforlicense
 * @link     https://github.com/themcv/phpsite
 */
/**
 * Common entry point.
 */
require dirname(__FILE__).DIRECTORY_SEPARATOR.'base.inc.php';
/**
 * Initial body information.
 */
$body = SimpleCMS::tag(
    'body',
    $SimpleCMS->displayAdmin()
);
/**
 * Because of how I created the tag funciton we can call it outside the scope of the
 * instantiated class object.
 *
 * To think about, however, is a simpler means to include tags maybe.
 */
echo SimpleCMS::sanitizeItems(
    SimpleCMS::tag(
        'html',
        $body
    )
);
