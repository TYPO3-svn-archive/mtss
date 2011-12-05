<?php

/***************************************************************

*  Copyright notice

*

*  (c) 2009 Grzegorz Bańka <grzegorz@grzegorzbanka.com>

*  All rights reserved

*

*  This script is part of the TYPO3 project. The TYPO3 project is

*  free software; you can redistribute it and/or modify

*  it under the terms of the GNU General Public License as published by

*  the Free Software Foundation; either version 2 of the License, or

*  (at your option) any later version.

*

*  The GNU General Public License can be found at

*  http://www.gnu.org/copyleft/gpl.html.

*

*  This script is distributed in the hope that it will be useful,

*  but WITHOUT ANY WARRANTY; without even the implied warranty of

*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

*  GNU General Public License for more details.

*

*  This copyright notice MUST APPEAR in all copies of the script!

***************************************************************/

/**

 * [CLASS/FUNCTION INDEX of SCRIPT]

 *

 * Hint: use extdeveval to insert/update function index above.

 */









/**

 * Addition of an item to the clickmenu

 *

 * @author	Grzegorz Bańka <grzegorz@grzegorzbanka.com>

 * @package	TYPO3

 * @subpackage	tx_mtss

 */

class tx_mtss_cm1 {

	function main(&$backRef,$menuItems,$table,$uid)	{

		global $BE_USER,$TCA,$LANG;



		$localItems = Array();

		if (!$backRef->cmLevel)	{

					// Adds the regular item:

				$LL = $this->includeLL();

				/*

					// Repeat this (below) for as many items you want to add!

					// Remember to add entries in the localconf.php file for additional titles.

				$url = t3lib_extMgm::extRelPath('mtss').'cm1/index.php?id='.$uid;

				$localItems[] = $backRef->linkItem(

					$GLOBALS["LANG"]->getLLL("cm1_title",$LL),

					$backRef->excludeIcon('<img src="'.t3lib_extMgm::extRelPath("mtss").'cm1/cm_icon.gif" width="15" height="12" border="0" align="top" />'),

					$backRef->urlRefForCM($url),

					1	// Disables the item in the top-bar. Set this to zero if you with the item to appear in the top bar!

				);

				

				*/



			if (@is_file($table)) {



				if ($BE_USER->isAdmin() || stristr($BE_USER->groupData['modules'],'web_txmtssM1')) {



					if (function_exists('finfo_open')) {

						//$fi = finfo_open(FILEINFO_MIME);

						//$enabled = (@finfo_file($fi, $table) == 'text/html');

						$pi = @pathinfo($table);

						$enabled = preg_match('/(html?|tmpl)/', $pi['extension']);	

						if(stristr($pi['filename'],'FCE'))
						{
							list($disabled)=explode('_',$pi['filename']);
							if($disabled=='FCE') $enabled=false;
							$enabled=false;
						}	

					}

					else {

						$pi = @pathinfo($table);

						$enabled = preg_match('/(html?|tmpl)/', $pi['extension']);	

						if(stristr($pi['filename'],'FCE'))

						{

							list($disabled)=explode('_',$pi['filename']);

							if($disabled=='FCE') $enabled=false;

						}		

					}

					if ($enabled) {



						$url = t3lib_extMgm::extRelPath('mtss').'cm1/index.php?file='.rawurlencode($table);

						$url='mod.php?&M=web_txmtssM1&SET[function]=2&file='.rawurlencode($table);

						

						$localItems[] = $backRef->linkItem(

					$GLOBALS["LANG"]->getLLL("cm1_title",$LL),

					$backRef->excludeIcon('<img src="'.t3lib_extMgm::extRelPath("mtss").'cm1/cm_icon.gif" width="15" height="12" border="0" align="top" />'),

					$backRef->urlRefForCM($url),

					1	// Disables the item in the top-bar. Set this to zero if you with the item to appear in the top bar!

						);

					}

				}

				

			

			}

			

				// Removes the view-item from clickmenu  

			//unset($menuItems["view"]);

		}

		if (count($localItems))	{

			$menuItems = array_merge($menuItems,$localItems);

		}



		return $menuItems;

	}

	

	/**

	 * Reads the [extDir]/locallang.xml and returns the \$LOCAL_LANG array found in that file.

	 *

	 * @return	[type]		...

	 */

	function includeLL()	{

		return $GLOBALS['LANG']->includeLLFile('EXT:mtss/locallang.xml', false);

	}

}







if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/class.tx_mtss_cm1.php'])	{

	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/class.tx_mtss_cm1.php']);

}



?>