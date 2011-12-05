<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Grzegorz Banka <grzegorz@grzegorzbanka.com>
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

/*
		includeLibs.displayFileLinks = EXT:tt_news/res/example_itemMarkerArrayFunc.php
		# call user function
		plugin.tt_news.itemMarkerArrayFunc = user_displayFileLinks
*/

function user_displayNewsTag ($markerArray, $conf){

	$keywords='';
	$markerArray['###LINK_TAGS###']=$markerArray['###TAGS###']='';
	$row = $conf['parentObj']->local_cObj->data;
	
	if($row['keywords']!='' && stristr($row['keywords'],',')) $keywords=explode(',',$row['keywords']);	
	if($keywords!='')
	{
		for($i=0; $i<count($keywords); $i++)
		{
			$array_param = array(
			'parameter' => $conf['parentObj']->conf['seatch_by_tags.']['pid'].' _self',
			'additionalParams' => '&tx_ttnews[swords]='.$keywords[$i],
			'ATagParams' => 'title="'.strtolower($keywords[$i]).'" rel="tag"',
			);			
			$add[]=$conf['parentObj']->local_cObj->typolink(strtolower($keywords[$i]),$array_param);
		}
		$markerArray['###TAGS###']=implode(',',$keywords);
		$markerArray['###LINK_TAGS###']=implode(', ',$add);
	}
	
	return $markerArray;

}



?>