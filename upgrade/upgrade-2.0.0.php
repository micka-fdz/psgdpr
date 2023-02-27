<?php

/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * @param Psgdpr $module
 *
 * @return bool
 */
function upgrade_module_2_0_0($module)
{
    $errors = [];

    $sqlInstallFile = __DIR__ . '/../src/Migration/migration_01.sql';
    $sqlQueries = explode(PHP_EOL, file_get_contents($sqlInstallFile));

    $sqlQueries = str_replace('PREFIX_', _DB_PREFIX_, $sqlQueries);

    foreach ($sqlQueries as $query) {
        if (empty($query)) {
            continue;
        }

        try {
            \Db::getInstance()->execute($query);
        } catch (Exception $e) {
            $errors[] = [
                'key' => json_encode($e->getMessage()),
                'parameters' => [],
                'domain' => 'Admin.Modules.Notification',
            ];
        }
    }

    return empty($errors);
}
