<?php

namespace TYPO3\TtAddress\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Service for category related stuff
 *
 * @todo the category functionality could may be replaced by using makeCategorizable
 */
class CategoryService {

    /**
     * Get child categories by calling recursive function
     * and using the caching framework to save some queries
     *
     * @param string $idList list of category ids to start
     * @param integer $counter
     * @param string $additionalWhere additional where clause
     * @param boolean $removeGivenIdListFromResult remove the given id list from result
     * @return string comma separated list of category ids
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getChildrenCategories($idList, $counter = 0, $additionalWhere = '', $removeGivenIdListFromResult = FALSE) {
        /** @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache */
        $cache = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('cache_ttaddress_category');
        $cacheIdentifier = sha1('children' . $idList);

        $entry = $cache->get($cacheIdentifier);
        if (!$entry) {
            $entry = self::getChildrenCategoriesRecursive($idList, $counter, $additionalWhere);
            $cache->set($cacheIdentifier, $entry);
        }

        if ($removeGivenIdListFromResult) {
            $entry = self::removeValuesFromString($entry, $idList);
        }

        return $entry;
    }

    /**
     * Remove values of a comma separated list from another comma separated list
     *
     * @param string $result string comma separated list
     * @param $toBeRemoved string comma separated list
     * @return string
     */
    public static function removeValuesFromString($result, $toBeRemoved) {
        $resultAsArray = GeneralUtility::trimExplode(',', $result, TRUE);
        $idListAsArray = GeneralUtility::trimExplode(',', $toBeRemoved, TRUE);

        $result = implode(',', array_diff($resultAsArray, $idListAsArray));
        return $result;
    }

    /**
     * Get rootline up by calling recursive function
     * and using the caching framework to save some queries
     *
     * @param integer $id category id to start
     * @param string $additionalWhere additional where clause
     * @return string comma separated list of category ids
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getRootline($id, $additionalWhere = '') {
        $cache = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Cache\\CacheManager')->getCache('cache_ttaddress_category');
        $cacheIdentifier = sha1('rootline' . $id);

        $entry = $cache->get($cacheIdentifier);
        if (!$entry) {
            $entry = self::getRootlineRecursive($id, $additionalWhere);
            $cache->set($cacheIdentifier, $entry);
        }
        return $entry;
    }

    /**
     * Get child categories
     *
     * @param string $idList list of category ids to start
     * @param integer $counter
     * @param string $additionalWhere additional where clause
     * @return string comma separated list of category ids
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    private static function getChildrenCategoriesRecursive($idList, $counter = 0, $additionalWhere = '') {

        $result = array();

        $cleanIdList = implode(",", GeneralUtility::intExplode(",", $idList));

        // add idlist to the output too
        if ($counter === 0) {
            $result[] = $cleanIdList;
        }

        $conn = self::getDBConnection('sys_category');

        $sql = 'SELECT uid FROM sys_category WHERE ((sys_category.parent IN (?)) AND (sys_category.deleted = ?))';

        if('' !== $additionalWhere) {
            $sql .= ' '.$additionalWhere;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute([$cleanIdList, 0]);
        $queryResult = $stmt->fetchAll();

        foreach($queryResult as $row) {
            $counter++;
            if ($counter > 10000) {
                $GLOBALS['TT']->setTSlogMessage('EXT:ricofferschr: one or more recursive categories where found');
                return implode(',', $result);
            }
            $subcategories = self::getChildrenCategoriesRecursive($row['uid'], $counter, $additionalWhere);
            $result[] = $row['uid'] . ($subcategories ? ',' . $subcategories : '');
        }

        $result = implode(',', $result);
        return $result;
    }

    /**
     * Get rootline categories
     *
     * @param integer $id category id to start
     * @param integer $counter counter
     * @param string $additionalWhere additional where clause
     * @return string comma separated list of category ids
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function getRootlineRecursive($id, $counter = 0, $additionalWhere = '') {
        $id = (int)$id;
        $result = array();

        $sql = "select uid,parent from sys_category where uid = ? and deleted = ?";

        if('' !== $additionalWhere) {
            $sql .= ' '.$additionalWhere;
        }
        $conn = self::getDBConnection('sys_category');
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id, 0]);

        $row = $stmt->fetch();

        if ($id === 0 || !$row || $counter > 10000) {
            $GLOBALS['TT']->setTSlogMessage('EXT:ricofferschr: one or more recursive categories where found');
            return $id;
        }

        $parent = self::getRootlineRecursive($row['parent'], $counter, $additionalWhere);
        $result[] = $row['parent'];
        if ($parent > 0) {
            $result[] = $parent;
        }

        $result = implode(',', $result);
        return $result;
    }


    /**
     * Translate a category record in the backend
     * @todo method seems to be unused, maybe remove it
     *
     * @param string $default default label
     * @param array $row category record
     * @return string
     *
     * @throws \UnexpectedValueException
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function translateCategoryRecord($default, array $row = array()) {
        if (TYPO3_MODE != 'BE') {
            throw new \UnexpectedValueException('TYPO3 Mode must be BE');
        }

        $overlayLanguage = (int)$GLOBALS['BE_USER']->uc['newsoverlay'];

        $title = '';

        if ($row['uid'] > 0 && $overlayLanguage > 0 && $row['sys_language_uid'] == 0) {
            $sql = 'select * from sys_category where deleted = ? and sys_language_uid = ? and l10n_parent = ?';
            $conn = self::getDBConnection('sys_category');
            $stmt = $conn->prepare($sql);
            $stmt->execute([0, $overlayLanguage, $row['uid']]);
            $overlayRecord = $stmt->fetch();

            if (isset($overlayRecord['title'])) {
                $title = $overlayRecord['title'] . ' (' . $row['title'] . ')';
            }
        }

        $title = ($title ? $title : $default);

        return $title;
    }

    /**
     * Helper method to create a QueryBuilder object for the given table name,
     * so raw queries in legacy code using TYPO3_DB can be refactored
     *
     * @param string $tableName
     * @return Connection
     */
    protected static function getDBConnection(string $tableName = "sys_category"): Connection {

        return GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable($tableName);
    }
}
