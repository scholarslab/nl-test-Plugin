<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=76; */

/**
 * @package     omeka
 * @subpackage  neatline-Plugin
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


if (!defined('NL_PLUGIN_DIR')) {
    define('NL_PLUGIN_DIR', dirname(__FILE__));
}

require_once NL_PLUGIN_DIR . '/NeatlinePluginPlugin.php';

$expansions = new NeatlinePluginPlugin();
$expansions->setUp();
