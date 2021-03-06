<?php

namespace TYPO3\TtAddress\ViewHelpers;

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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * ViewHelper to render data in <head> section of website
 *
 * # Example: Basic example
 * <code>
 * <n:headerData>
 *    <link rel="alternate"
 *      type="application/rss+xml"
 *      title="RSS 2.0"
 *      href="<f:uri.page additionalParams="{type:9818}"/>" />
 * </n:headerData>
 * </code>
 * <output>
 * Added to the header: <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="uri to this page and type 9818" />
 * </output>
 *
 */
class HeaderDataViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

  /**
   * Renders HeaderData
   *
   * @return void
  */
  public function render()
  {
    $pageRenderer = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
    $pageRenderer->addHeaderData($this->renderChildren());
  }
}
