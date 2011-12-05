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


$LANG->includeLLFile('EXT:mtss/func/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
require_once(PATH_t3lib.'class.t3lib_tsparser.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]
require_once(t3lib_extMgm::extPath("mtss").'/func/dane.php');
$DANE=new tx_mtss_dane;

$MARKER_PARSE=array(
	'PATHWAY',
	'FOOTER',
	'LINKS',
	'CONTENT.*',
	'MEMCONTENT.*',
	'MENU.*',
	'MENU_1.*',
	'PAGETITLE',
	'PAGEDESC',
	'LIB_.*',
	'HEADER.*',
	'LINK.*',
	'LINKURL.*',
	'MEMLINK.*',
	'MEMLINKURL.*',
	'TEXT.*',
	'GHEADER.*',
	'FCEHEADER',
	'IMAGE.*'
);


$ARRAY_NOT_EMPTY=array('allWrap','wrap','wrapIn','submenu.allWrap','submenu.wrap');

$MENU_PREG=array(
		'title',
		'allWrap',		
		'wrap',
		'wrapFirst',
		'wrapLast',	
		'wrapIn',
			
		'classFirst',
		'classLast',
		'classOn',
		'classPid',
		'classSubPid',
		'classForOne',
		
		'submenu.allWrap',
		'submenu.wrap',
		'submenu.wrapFirst',
		'submenu.wrapLast',
		
		'submenu.classFirst',
		'submenu.classLast',
		'submenu.classOn',
		'submenu.classPid',
		'submenu.classSubPid',
		'submenu.classForOne',
		'submenu.show',
		'submenu.where',
		'submenu.style',
		'ts'
);
		
$PATHWAY_PREG=array(
	'allWrap',
	'wrap',
	'classFirst',
	'classLast',
	'classOn',	
	'wrapFirst',
	'wrapLast'
);
$GHEADER_PREG=array(
	'title',
	'ts',
);
$IMAGE_PREG=$GHEADER_PREG;
$TEXT=$HEADER=array(
	'title'
);
		
$ALL['MENU']=array(
	'allWrap'		=>	'<ul class="menu">|</ul>',
	'wrap'			=>	'<li addclass>|</li>',
	'wrapIn'		=>	'|',
	'title'			=>	'Menu',
	'classFirst'	=>	'first',
	'classLast'		=>	'last',
	'classOn'		=>	'on',
	'classPid'		=>	'is_pid',
	'classSubPid'	=>	'is_subpid',	
	'classForOne'	=>	'is_one',	
	
	'wrapFirst'		=>	'',
	'wrapLast'		=>	'',
								
	'submenu.allWrap'		=>	'<ul class="podmenu">|</ul>',
	'submenu.wrap'			=>	'<li addclass>|</li>',
	'submenu.classFirst'	=>	'first',
	'submenu.classLast'		=>	'last',
	'submenu.classOn'		=>	'on',
	'submenu.classPid'		=>	'is_pid',
	'submenu.classSubPid'	=>	'is_subpid',
	'submenu.classForOne'	=>	'is_one',
	
	'submenu.wrapFirst'		=>	'',
	'submenu.wrapLast'		=>	'',
	
	'submenu.show'			=>	0,
	'submenu.where'			=>	'auto_menu', // out_menu, in_menu
	'submenu.style'			=>	'ALL', // ON
);
$ALL['MENU_1']=$ALL['MENU_2']=$ALL['MENU_3']=$ALL['MENU_4']=$ALL['MENU_5']=$ALL['MENU'];
$ALL['MENU_1']['allWrap']='<ul class="menu_1">|</ul>';
$ALL['MENU_2']['allWrap']='<ul class="menu_2">|</ul>';
$ALL['MENU_3']['allWrap']='<ul class="menu_3">|</ul>';
$ALL['MENU_4']['allWrap']='<ul class="menu_4">|</ul>';
$ALL['MENU_5']['allWrap']='<ul class="menu_5">|</ul>';


$ALL['CONTENT']=array(
		'allWrap'	=>	'|',
		'title'		=>	'Content',	
		'search'	=>	1,
);
$ALL['MEMCONTENT']=array(
		'allWrap'	=>	'|',
		'title'		=>	'MEM Content',
		'search'	=>	0,
);

$ALL['PATHWAY']=array(
	'allWrap'		=>	'<div class="pathway">|</div>',
	'wrap'			=>	'| >',
	'classFirst'	=>	'first',
	'classLast'		=>	'last',
	'classOn'		=>	'on',	
	'title'			=>	'Pathway',
	'wrapFirst'	=>	$LANG->getLL('pathway_jestes_tutaj').': | >',
	'wrapLast'	=>	'|:',
);
$ALL['FOOTER']=array(
	'title'			=>	'Footer',
	'allWrap'		=>	'<div class="footer">|</div>',
	'wrap'			=>	'| - ',
	'classFirst'	=>	'first',
	'classLast'		=>	'last',
	'classOn'		=>	'on',
	'wrapFirst'	=>	'| - ',
	'wrapLast'	=>	'|',	
);
$ALL['LINKS']=array(
	'allWrap'		=>	'<div class="links">|</div>',
	'wrap'			=>	'| - ',
	'classFirst'	=>	'first',
	'classLast'		=>	'last',
	'classOn'		=>	'on',
	'wrapFirst'	=>	'| - ',
	'wrapLast'	=>	'|',	
);
$ALL['GHEADER']=array(
	'title'			=>	'G Header',
	'ts'			=>	'
10 = IMAGE
10.file = GIFBUILDER
10.file {
XY = [10.w]+10,[10.h]+10
backColor = #999999
10 = TEXT
	10.text.current = 1
	10.text.case = upper
	10.fontColor = #FFCC00
	10.fontFile =  t3lib/fonts/vera.ttf
	10.niceText = 0
	10.offset = 0,14
	10.fontSize = 14
}
	'
);
$ALL['IMAGE']=array(
	'title'		=>	'Image',
	'ts'		=>	'
	10 = IMAGE
	10.file.XY = 200,150
	10.file.import = uploads/tx_templavoila/
	10.file.import.current = 1
	10.file.import.listNum = 0
	10.file.maxW = 200
	10.file.minW = 200
	10.file.maxH = 150
	10.file.minH = 150
	'
);

$ALL['PAGE_TITLE']=$ALL['FOOTER'];
$ALL['PAGE_DESC']=$ALL['FOOTER'];
$ALL['HEADER']=$ALL['FOOTER'];
$ALL['LINK']=$ALL['HEADER'];
$ALL['LINKURL']=$ALL['LINK'];
$ALL['MEMLINKURL']=$ALL['LINK'];
$ALL['MEMLINK']=$ALL['LINK'];
$ALL['TEXT']=$ALL['HEADER'];
$ALL['FCEHEADER']=$ALL['HEADER'];
/**
 * Module 'Szablony' for the 'mtss' extension.
 *
 * @author	Grzegorz Bańka <grzegorz@grzegorzbanka.com>
 * @package	TYPO3
 * @subpackage	tx_mtss
 */
 
class  tx_mtss_function extends t3lib_SCbase {
				var $pageinfo;
				
				/**
				 * Create tmplobj for TV
				 * @return array(tmplobj,html_template)
				 */
				 function tv_comSet($uid,$file)
				 {
					$updateArray = array(
					'tstamp'			=>	time(),
					'fileref'			=>	$file.'.cachetmp',
					'fileref_md5'		=>	md5($file.'.cachetmp')
					);							
					$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_tmplobj', 'uid="'.$uid.'"', $updateArray);		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);			
				 }
				 function get_header($header,$path)
				 {					
				 	$path=str_replace($_SERVER['DOCUMENT_ROOT'],'',$path);
				 	$array=array(
					'/<.*meta.*http-equiv([^>])*>\s*/i',
					'/<.*title.*>([^>])*<.*\/.*title.*>\s*/i',
					'/<.*meta.*name.*=.*generator([^>])*>\s*/i',
					'/<.*meta.*name.*=.*description([^>])*>\s*/i',
					'/<.*meta.*name.*=.*keywords([^>])*>\s*/i',
					'/<.*base.*([^>])*>\s*/i',
					'/<.*!DOCTYPE .*([^>])*>\s*/i',
					'/<.*head.*>\s*/i',
					);
					
					for($i=0; $i<count($array); $i++)
					{
						$header=$this->delete_regula($array[$i],$header);
					}
					$header=$this->change_href($header,$path);
					
					return $header;
				 }
				 function change_href($header,$path='',$dont_use='')
				 {
				 	if($dont_use!='href' || $dont_use=='')
					{
						preg_match_all('/href=([^>].*)/i',$header,$all_change);					
						for($i=0; $i<count($all_change[0]); $i++)
						{
							$change[$i]=$all_change[0][$i];
							$is_change='';
	
							if(stristr($change[$i],'href="')) $is_change=str_replace('href="','href="'.$path,$change[$i]);
							else if(stristr($change[$i],'href="/')) $is_change=str_replace('href="/','href="'.$path,$change[$i]);
							else if(stristr($change[$i],'href=/')) $is_change=str_replace('href=/','href='.$path,$change[$i]);
							else if(stristr($change[$i],'href=')) $is_change=str_replace('href=','href='.$path,$change[$i]);
							
							$header=str_replace($change[$i],$is_change,$header);
						}
					}
					if($dont_use!='src' || $dont_use=='')
					{
						preg_match_all('/src=([^>].*)/i',$header,$all_change);
						
						for($i=0; $i<count($all_change[0]); $i++)
						{
							$change[$i]=$all_change[0][$i];
							$is_change='';
	
							if(stristr($change[$i],'src="')) $is_change=str_replace('src="','src="'.$path,$change[$i]);
							else if(stristr($change[$i],'src="/')) $is_change=str_replace('src="/','src="'.$path,$change[$i]);
							else if(stristr($change[$i],"src='/")) $is_change=str_replace("src='/",'src='.$path,$change[$i]);
							else if(stristr($change[$i],"src='")) $is_change=str_replace("src='",'src='.$path,$change[$i]);
							else if(stristr($change[$i],'src=/')) $is_change=str_replace('src=/','src='.$path,$change[$i]);
							else if(stristr($change[$i],'src=')) $is_change=str_replace('src=','src='.$path,$change[$i]);
							
							$header=str_replace($change[$i],$is_change,$header);
						}
					}

					return $header;
				 }
				 function delete_regula($regula,$header)
				 {
				 	preg_match_all($regula,$header,$delete);
					return str_replace($delete[0],'',$header);
				 }
				 
				 function tmplobj_parse($all,$file,$isheader,$isbeview,$opcja='')
				 {
				 	global $MARKER_PARSE,$FCE;
					
					$set_all_true=0;
					$error=1;
					$isnr=0;
					$nr=0;
					$path=explode('/',$file);
					unset($path[count($path)-1]);
					$path=implode('/',$path).'/';
				 	if($_SERVER['DOCUMENT_ROOT']!='/')
					{
						list(,$path)=explode('/fileadmin/',$path);
						$path='/fileadmin/'.$path;
					}
					
					$marker_menu=array();
					$marker_content=array();	
					$marker_last=array();
					
					$value_menu=array();
					$value_content=array();
					$value_last=array();
					
					if($opcja=='')
					{
						preg_match_all('/<.*body.*>/i',$all,$body_tag);
						$body_end=$body_tag[0][count($body_tag[0])-1];
						$body_tag=$body_tag[0][0];
						
						if($body_tag!='' && $body_end!='')
						{						
							list($header,$dane)=explode($body_tag,$all);
							$add_header=$isheader==1?$this->get_header($header,$path):'';						
							list($dane)=explode($body_tag,$dane);
							list($dane)=explode($body_end,$dane);	
							$dane=$this->change_href($dane,$path,'href');
							//print_r($dane);exit;						
							$MappingInfo['MappingInfo']['ROOT']['MAP_EL']='body[1]/INNER';
							$set_all_true=1;
							$error=0;
						}						
					}
					else
					{
						preg_match_all('/<!--.*###START###.*-->/isU',$all,$start);
						preg_match_all('/<!--[^<]*###END###.*-->/isU',$all,$end);						
						$start=$start[0][0];
						$end=$end[0][0];						
						list(,$dane)=explode($start,$all);
						list($dane)=explode($end,$dane);					
						list(,$file_name)=$this->get_file_all($file);
						$MappingInfo['MappingInfo']['ROOT']['MAP_EL']='div.'.$file_name.'[1]/INNER';
						if($dane!='' && stristr($start,'START') && stristr($end,'END'))
						{
							$set_all_true=1;
							$error=0;
						}
					}
						
					if($set_all_true==1 && $FCE=='') //  jeśli są wszystkie dane i importowany jest zwykły szablon ELSE jest przeznaczone dla szablonow FCE
					{			
						$next=$dane;
						preg_match_all('/<!--[^<]*###('.implode('|',$MARKER_PARSE).')?###.*-->/isU',$next,$allmarker);	

						for($i=0; $i<count($allmarker[1]); $i++)
						{
							list($allmarker[1][$i])=explode('[',$allmarker[1][$i]);
							if(stristr($allmarker[1][$i],'MENU') && !stristr($allmarker[1][$i],'CONTENT')) list($marker_menu[],$value_menu[])=array($allmarker[1][$i],$allmarker[0][$i]);
							if(stristr($allmarker[1][$i],'CONTENT') && !stristr($allmarker[1][$i],'MENU')) list($marker_content[],$value_content[])=array($allmarker[1][$i],$allmarker[0][$i]);
							if(stristr($allmarker[1][$i],'MEMCONTENT') && !stristr($allmarker[1][$i],'MENU')) list($marker_last[],$value_last[])=array($allmarker[1][$i],$allmarker[0][$i]);						
						}	
	
						$marker=array_unique($allmarker[1]);

						for($i=0; $i<count($marker); $i++)
						{
							$start=$allmarker[1][$isnr];
							$end=$allmarker[1][$isnr+1];
	
							if($start==$end)
							{
								$field='field_'.strtolower($start);
								$div_start='<div id="'.$field.'">'; $div_end='</div>';
	
								if($allmarker[0][$isnr]!=$allmarker[0][$isnr+1])
								{		
									list($MappingData_cached['MappingData_cached']['cArray'][$isnr],$next)=explode($allmarker[0][$isnr],$next);
									list($MappingData_cached['MappingData_cached']['cArray'][$field],$next)=explode($allmarker[0][$isnr+1],$next);		
								}
								else
								{	
									$all=explode($allmarker[0][$isnr],$next);	
									$MappingData_cached['MappingData_cached']['cArray'][$isnr]=$all[0];
									$MappingData_cached['MappingData_cached']['cArray'][$field]=$all[1];
									$next=$all[2];
								}
								
								$MappingData_cached['MappingData_cached']['cArray'][$field]=$div_start.$MappingData_cached['MappingData_cached']['cArray'][$field].$div_end;
								$MappingInfo['MappingInfo']['ROOT']['el'][$field]['MAP_EL']='div#'.$field;
								$isnr=$isnr+2;
							}else list($error,$i)=array(1,count($marker));
						}
						$MappingData_cached['MappingData_cached']['cArray'][$isnr]=$next;
						$MappingData_cached['MappingData_cached']['sub']=array();
						
						preg_match_all('/<head>(.*)<\/head>/isU',$add_header,$head);
						$MappingData_head_cached['MappingData_head_cached']=array(
							'cArray' => array(
								0	=>$head[1][0]
							),
							'sub'	=>	array()
						);
						$BodyTag_cached['BodyTag_cached']=$body_tag;
						$MappingInfo_head['MappingInfo_head']['headElementPaths']=NULL;
						$MappingInfo_head['MappingInfo_head']['addBodyTag']=1;
						
						$wynik=array_merge($MappingInfo_head,$MappingInfo);
						$wynik=array_merge($wynik,$MappingData_cached);
						$wynik=array_merge($wynik,$MappingData_head_cached);
						$wynik=array_merge($wynik,$BodyTag_cached);
						$web=$add_header.$preg_match_all.implode('',$MappingData_cached['MappingData_cached']['cArray']);
					 }	
					 elseif($set_all_true==1) //  jeśli są wszystkie dane i importowany jest FCE szablon
					 {
						$next=$dane;
						preg_match_all('/<!--[^<]*###('.implode('|',$MARKER_PARSE).')?###.*-->/isU',$next,$allmarker);	
									
						for($i=0; $i<count($allmarker[1]); $i++)
						{
							list($allmarker[1][$i])=explode('[',$allmarker[1][$i]);
							if(stristr($allmarker[1][$i],'MENU') && !stristr($allmarker[1][$i],'CONTENT')) list($marker_menu[],$value_menu[])=array($allmarker[1][$i],$allmarker[0][$i]);
							if(stristr($allmarker[1][$i],'CONTENT') && !stristr($allmarker[1][$i],'MENU')) list($marker_content[],$value_content[])=array($allmarker[1][$i],$allmarker[0][$i]);
							if(stristr($allmarker[1][$i],'MEMCONTENT') && !stristr($allmarker[1][$i],'MENU')) list($marker_last[],$value_last[])=array($allmarker[1][$i],$allmarker[0][$i]);						
						}	
	
						$marker=array_unique($allmarker[1]);

						for($i=0; $i<count($marker); $i++)
						{
							$start=$allmarker[1][$isnr];
							$end=$allmarker[1][$isnr+1];
							
							if($start==$end)
							{
								$field='field_'.strtolower($start);
								$div_start='<div id="'.$field.'">'; $div_end='</div>';
	
								if($allmarker[0][$isnr]!=$allmarker[0][$isnr+1])
								{		
									list($MappingData_cached['MappingData_cached']['cArray'][$isnr],$next)=explode($allmarker[0][$isnr],$next);
									list($MappingData_cached['MappingData_cached']['cArray'][$field],$next)=explode($allmarker[0][$isnr+1],$next);		
								}
								else
								{	
									$all=explode($allmarker[0][$isnr],$next);	
									$MappingData_cached['MappingData_cached']['cArray'][$isnr]=$all[0];
									$MappingData_cached['MappingData_cached']['cArray'][$field]=$all[1];
									$next=$all[2];
								}
								
								$MappingData_cached['MappingData_cached']['cArray'][$field]=$div_start.$MappingData_cached['MappingData_cached']['cArray'][$field].$div_end;
								$MappingInfo['MappingInfo']['ROOT']['el'][$field]['MAP_EL']='div#'.$field;
								$isnr=$isnr+2;
							}else list($error,$i)=array(1,count($marker));
						}
						
						$MappingData_cached['MappingData_cached']['cArray'][$isnr]=$next;
						$MappingData_cached['MappingData_cached']['sub']=array();

						$MappingInfo_head['MappingInfo_head']=NULL;
						
						$MappingData_head_cached['MappingData_head_cached']=array(
							'cArray' => array(
								0	=>NULL
							),
							'sub'	=>	array()
						);
						
						$BodyTag_cached['BodyTag_cached']=NULL;
						
						$wynik=array_merge($MappingInfo,$MappingInfo_head);
						$wynik=array_merge($wynik,$MappingData_cached);
						$wynik=array_merge($wynik,$MappingData_head_cached);
						$wynik=array_merge($wynik,$BodyTag_cached);

						$web='<div class="'.$file_name.'">'.implode('',$MappingData_cached['MappingData_cached']['cArray']).'</div>';
					 }

					 return array(serialize($wynik),$web,$marker,$error,$add_header);		 			 
				 }
				 
				/**
				 * Get conf from html template
				 * @return conf
				 */
				 
				 function conf_get($all)
				 {
				 	preg_match_all('/###([^#]*)###.*\{(.+)\}/isU',$all,$marker_conf); // get all conf from template
				 }
				
				
				function get_pliki($path='')
				{
					global $BE_USER;
					if($path=='')
					{
						$path=array_values($BE_USER->groupData['filemounts']);
						$path=$path[0]['path'];
					}
					return array(t3lib_div::get_dirs($path),t3lib_div::getFilesInDir($path));
				}
				
				 function get_all_file($template_conf,$template_view,$template_image,$image_name,$isconf,$isview,$isimage,$isheader,$file,$nazwa,$FCE)
				 {
				 	global $LANG,$SHOW,$BE_USER,$IS_PATH,$FCE;
					$all_view='';
					$all_conf='';
					$all_image='';
					$info='';
					$error=0;
					
					if($_SERVER['DOCUMENT_ROOT']=='/')
					{
						list(,$file)=explode('/fileadmin',$file);
						$file='/fileadmin'.$file;
					}
					
					$fopen=fopen($file,'r');
					if($fopen && filesize($file)!=0)
					{
						$dane=fread($fopen,filesize($file));
						fclose($fopen);
						if(is_file($template_conf) && $isconf==1)
						{
							$fopen=fopen($template_conf,'r');
							if($fopen) if(filesize($template_conf)>0) $all_conf=fread($fopen,filesize($template_conf));
							elseif(filesize($template_conf)>0) $info=$SHOW->get_info($LANG->getLL('informacja_error_pliku_dodatkowego'),'error');
							fclose($fopen);
						} 						
						if(is_file($template_view) && $isview==1)
						{
							$fopen=fopen($template_view,'r');
							if($fopen) if(filesize($template_view)>0) $all_view=$this->get_all_view(fread($fopen,filesize($template_view)));
							elseif(filesize($template_view)>0) $info=$SHOW->get_info($LANG->getLL('informacja_error_pliku_dodatkowego'),'error');
							fclose($fopen);
						}						
						if(is_file($template_image) && $isimage==1)
						{
							$fopen=fopen($template_image,'r');
							if($fopen) if(filesize($template_image)>0) 
							{
								$all_image=$BE_USER->user['uid'].$image_name;
								copy($template_image,$IS_PATH.'uploads/tx_templavoila/'.$all_image);
							}
							else $info=$SHOW->get_info($LANG->getLL('informacja_error_pliku_dodatkowego'),'error');
							fclose($fopen);
						}

						if($info=='')
						{
							list($tmplobj_parse,$web,$marker,$error,$add_header)=$this->tmplobj_parse($dane,$file,$isheader,$isbeview,$FCE);	
								
							$returnUrl=explode('/',$file);
							unset($returnUrl[count($returnUrl)-1]);
							$returnUrl=implode('/',$returnUrl);
										
							if($error==0)
							{

								if($FCE==1)
								{	
									 $dane_conf=$dane; // dla FCE szablonu									 
								}
								else list(,$dane_conf)=explode('</html>',$dane); // dla zwykłego szablonu
							
								preg_match_all('/###([^#]*)###.*\{([^}].+)\}/isU',$dane_conf,$marker_conf);
								
								$marker=array_values($marker);
								for($i=0; $i<count($marker); $i++)
								{
									if(!in_array($marker[$i],$marker_conf[1])) $marker_conf[1][]=$marker[$i];
								}
								$html_conf=$this->get_all_conf($marker_conf,$dane);
								
								
								$marker_conf=array();
								if($all_conf!='')
								{
									preg_match_all('/###([^#]*)###.*\{([^}].+)\}END/isU',$all_conf,$marker_conf);
									//print_r($marker_conf);exit;

									for($i=0; $i<count($marker); $i++)
									{
										if(!in_array($marker[$i],$marker_conf[1])) $marker_conf[1][]=$marker[$i];
									}
									
									$file_conf=$this->get_all_conf($marker_conf,$dane,0);
								}
								else $file_conf='';
								
								
								$DataStructure=$this->get_data_structure($marker,$html_conf,$file_conf,$add_header,$all_view,$file);
								$info=$this->create_szablon($file,$nazwa,$web,$tmplobj_parse,$DataStructure,$all_image);	
							}else $info=$SHOW->get_info(str_replace('%plik%','<a href="file_edit.php?target='.$file.'&returnUrl=file_list.php?id='.$returnUrl.'">'.$LANG->getLL('kliknij_tutaj').'</a>',$LANG->getLL('informacja_error_pliku_blad')),'error');		
						}

					}else $info=$SHOW->get_info($LANG->getLL('informacja_error_pliku'),'error');
					return $info;
				 }
				 
				 function get_all_view($read)
				 {
				 	$field='field_';
				 	preg_match_all('/###(.*)###/isU',$read,$marker);	
					for($i=0; $i<count($marker[0]); $i++)
					{
						$read=str_replace($marker[0][$i],'###'.$field.strtolower($marker[1][$i]).'###',$read);
					}
					return $read;
				 }
				 
				 function is_user_storage($uid,$user,$admin)
				 {
				 	//perms_userid
					
						$is=$admin;
						$where = 'deleted=0 AND hidden=0 AND uid="'.intval($uid).'" AND doktype=254 AND perms_userid="'.intval($user).'"';
						$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid','pages',$where,'','','1');	
						
						while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
						{
							$is=$uid;
						}
					return $is;					
				 }
				 
				 function create_szablon($file,$nazwa,$web,$tmplobj_parse,$DataStructure,$all_image)
				 {
				 	global $BE_USER,$SHOW,$LANG,$FCE;

					$filemounts=array_values($BE_USER->groupData['filemounts']);
					$filemounts=$filemounts[0]['path'];
					$storage=$this->is_user_storage($_POST['storage'],$BE_USER->user['uid'],$BE_USER->user['admin']);
					
						list($file_path,$filename)=$this->get_file_all($file);
						$web_file=$file_path.$filename.'.cachetmp';
					if(stristr($file,$filemounts) && $storage!=0)
					{				 

						$fopen=fopen($web_file,'w');
						fwrite($fopen,$web);
						fclose($fopen);		

						if(!isset($_POST['aktualizacja']))
						{		
							if($FCE=='') $scope=1;
							else $scope=2;
							
							$insertArray=array(
							'pid' 			=>	$storage,
							't3ver_oid' 	=>	0,
							't3ver_id' 		=>	0,
							't3ver_wsid' 	=>	0,
							't3ver_label' 	=>	0,
							't3ver_state' 	=>	0,
							't3ver_stage' 	=>	0,
							't3ver_count' 	=>	0,
							't3ver_tstamp' 	=>	0,
							't3_origuid' 	=>	0,
							'tstamp' 		=>	time(),
							'crdate' 		=>	time(),
							'cruser_id' 	=>	0,
							'deleted' 		=>	0,
							'sorting' 		=>	0,
							'title' 		=>	mysql_real_escape_string($nazwa),
							'dataprot' 		=>	$DataStructure,
							'scope' 		=>	$scope,
							'previewicon'	=>	$all_image
							);					
							
							$GLOBALS['TYPO3_DB']->exec_INSERTquery(
								'tx_templavoila_datastructure',
								$insertArray    			
							);
							$data_uid=$GLOBALS['TYPO3_DB']->sql_insert_id();
							
							$insertArray=array(
							'pid' 				=>	$storage,
							't3ver_oid' 		=>	0,
							't3ver_id' 			=>	0,
							't3ver_wsid'		=>	0 ,
							't3ver_label' 		=>	0,
							't3ver_state' 		=>	0,
							't3ver_stage' 		=>	0,
							't3ver_count' 		=>	0,
							't3ver_tstamp' 		=>	0,
							't3_origuid' 		=>	0,
							'tstamp' 			=>	time(),
							'crdate' 			=>	time(),
							'cruser_id' 		=>	0,
							'fileref_mtime' 	=>	time(),
							'deleted' 			=>	0,
							'sorting' 			=>	0,
							'title' 			=>	mysql_real_escape_string($nazwa),
							'datastructure' 	=>	$data_uid,
							'fileref' 			=>	mysql_real_escape_string($web_file),
							'templatemapping' 	=>	$tmplobj_parse,
							'previewicon' 		=>	'',
							'description' 		=>	'',
							'rendertype' 		=>	'',
							'sys_language_uid'	=>	0 ,
							'parent' 			=>	0,
							'rendertype_ref' 	=>	0,
							'localprocessing' 	=>	'',
							'fileref_md5' 		=>	md5(mysql_real_escape_string($web_file)),
							'previewicon'		=>	$all_image
							);					
							
							$GLOBALS['TYPO3_DB']->exec_INSERTquery(
								'tx_templavoila_tmplobj',
								$insertArray    			
							);
							$return=$SHOW->get_info(str_replace('%nazwa%','<b>'.$nazwa.'</b>',$LANG->getLL('informacja_create_template')),'create');
						}
						else
						{			
							$where = 'deleted=0 AND fileref="'.mysql_real_escape_string($file).'.cachetmp"';
							$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,datastructure','tx_templavoila_tmplobj',$where,'','','1');	
							while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
							{
								$uid_tmplobj=$row['uid'];
								$uid_datastructure=$row['datastructure'];
							}
									
							$updateArray = array(
							'tstamp'			=>	time(),
							'title' 			=>	mysql_real_escape_string($nazwa),
							'templatemapping' 	=>	$tmplobj_parse,
							'previewicon'		=>	$all_image
							);							
							$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_tmplobj', 'uid="'.$uid_tmplobj.'"', $updateArray);		
							$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
							
							$updateArray = array(
							'tstamp'		=>	time(),
							'title' 		=>	mysql_real_escape_string($nazwa),
							'dataprot' 		=>	$DataStructure,
							'previewicon'	=>	$all_image
							);							
							$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_datastructure', 'uid="'.$uid_datastructure.'"', $updateArray);		
							$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
				
							$returnUrl=explode('/',$file);
							unset($returnUrl[count($returnUrl)-1]);
							$returnUrl=implode('/',$returnUrl);
				
							$return=$SHOW->get_info(str_replace('%nazwa%','<b>'.$nazwa.'</b>',$LANG->getLL('informacja_update_template')).'<input type="button" value="'.$LANG->getLL('przeladuj_strone').'" onclick="window.location.reload()" /><br /><br />'.$SHOW->get_info(str_replace('%plik%','<a href="file_edit.php?target='.$file.'&returnUrl=file_list.php?id='.$returnUrl.'"><b>'.$LANG->getLL('kliknij_tutaj').'</b></a>',$LANG->getLL('informacja_edycja_liku')),'info'),'create');
							
						}						
					}
					else
					{
						if($storage==0) $return=$SHOW->get_info($LANG->getLL('informacja_error_brak_dostepu'),'error');
						else $return=$SHOW->get_info($LANG->getLL('informacja_error_path_template'),'error');
					}
					return $return;
				 }
				 
				 function get_file_all($file)
				 {
					$file_name=explode('/',$file);
					$filename=$file_name[count($file_name)-1];
					unset($file_name[count($file_name)-1]);
					$file_path=implode('/',$file_name);
					return array($file_path.'/',$filename);
				 }
				 
				 function get_data_structure($markery,$html_conf,$file_conf,$add_header,$template_view,$file)
				 {
				 	global $DANE,$MENU_PREG,$PATHWAY_PREG,$GHEADER_PREG,$IMAGE_PREG,$TEXT,$HEADER,$FCEHEADER;
					
					$add=array();
					
					list(,$www)=explode('fileadmin/',$file);
					list($www)=explode('/templates',$www);
					
					$template_view=str_replace('###field_www###',$www,$template_view);

					list($start,$end)=$DANE->xml($template_view);
					$add[]=$DANE->xml_add('field_header',array('header'=>$add_header),'HEADER');
					
					for($i=0; $i<count($markery); $i++)
					{
						$return_all=array();
						$marker=$markery[$i];
						$name=$marker;
						$lvl='';

						if(stristr($marker,'_')) list($marker,$lvl)=explode('_',$marker);
						if($marker=='MENU' && is_numeric($lvl)) $marker=$marker.'_'.$lvl;					
						
						switch($marker)
						{
							case ('CONTENT'):
								if($file_conf==array())
								{
									$title=$file_conf[$name]['title']==''?$html_conf[$name]['title']:$file_conf[$name]['title'];
									$allWrap=$file_conf[$name]['allWrap']==''?$html_conf[$name]['allWrap']:$file_conf[$name]['allWrap'];
									$search=$file_conf[$name]['search']==''?$html_conf[$name]['search']:$file_conf[$name]['search'];
								}
								else
								{
									$title=$html_conf[$name]['title'];
									$allWrap=$html_conf[$name]['allWrap'];
									$search=$html_conf[$name]['search'];
								}
								$add[]=$DANE->xml_add('field_'.strtolower($name),array('title'=>$title,'allWrap'=>$allWrap,'search'=>$search),$marker);
							break;
							case ('MEMCONTENT'):
								if($file_conf==array())
								{
									$title=$file_conf[$name]['title']==''?$html_conf[$name]['title']:$file_conf[$name]['title'];
									$allWrap=$file_conf[$name]['allWrap']==''?$html_conf[$name]['allWrap']:$file_conf[$name]['allWrap'];
									$search=$file_conf[$name]['search']==''?$html_conf[$name]['search']:$file_conf[$name]['search'];
								}
								else
								{
									$title=$html_conf[$name]['title'];
									$allWrap=$html_conf[$name]['allWrap'];
									$search=$html_conf[$name]['search'];
								}
								$add[]=$DANE->xml_add('field_'.strtolower($name),array('title'=>$title,'allWrap'=>$allWrap,'search'=>$search),$marker);
							break;
							
							case ('PATHWAY' || 'GHEADER' || 'HEADER' || 'IMAGE');
								
								 $preg_array=$PATHWAY_PREG;
								//if($marker=='PATHWAY') $preg_array=$PATHWAY_PREG;
								if($marker=='GHEADER') $preg_array=$GHEADER_PREG;
								
								switch($marker)
								{
									case 'GHEADER':
										 $preg_array=$GHEADER_PREG;
									break;
									
									case 'IMAGE':
										 $preg_array=$IMAGE_PREG;
									break;
									
									case ('TEXT' || 'HEADER'):
										 $preg_array=$TEXT;
									break;
									
									case 'FCEHEADER':
										 $preg_array=$FCE_HEADR;
									break;
									
								}

								if(is_array($file_conf)){
									
								
									for($z=0; $z<count($preg_array); $z++){
										$return_all[$preg_array[$z]]=$file_conf[$name][$preg_array[$z]]==''?$html_conf[$name][$preg_array[$z]]:$file_conf[$name][$preg_array[$z]];									
									}
								}
								else 
								{ 
									for($z=0; $z<count($preg_array); $z++){
										$return_all[$preg_array[$z]]=$html_conf[$name][$preg_array[$z]];
									}
								}
	
								$add[]=$DANE->xml_add('field_'.strtolower($name),$return_all,$marker);	
							break;
							
							case ('MENU' || 'MENU_1' || 'MENU_2' || 'MENU_3' || 'MENU_4' || 'MENU_5'):
								
								$preg_array=$MENU_PREG;
								if($file_conf==array()){								
									for($z=0; $z<count($preg_array); $z++){
										$return_all[$preg_array[$z]]=$file_conf[$name][$preg_array[$z]]==''?$html_conf[$name][$preg_array[$z]]:$file_conf[$name][$preg_array[$z]];									
									}
								}
								else 
								{
									for($z=0; $z<count($preg_array); $z++){
										$return_all[$preg_array[$z]]=$html_conf[$name][$preg_array[$z]];
									}
								}

								$add[]=$DANE->xml_add('field_'.strtolower($name),$return_all,$marker);	
							break;
						
						}
					}	
				 	return $start.implode("\n",$add).$end;
				 }

				 function get_all_conf($all,$dane,$option=1)
				 {
				 	global $ALL,$ARRAY_NOT_EMPTY;
					$array_getTS=array('IMAGE','GHEADER');
				 	for($i=0; $i<count($all[1]); $i++)
					{
						$conf='';
						$marker=$all[1][$i];
						$name=$marker;
						$all_conf=$all[2][$i];

						if(stristr($marker,'_')) list($marker)=explode('_',$marker);
						preg_match_all('/<!--.*###'.$name.'\[(.*)\]###.*-->/isU',$dane,$title);
						
						$title=$title==''?'':$title[1][0];
						$TSparserObject = t3lib_div::makeInstance('t3lib_tsparser');

						$TSparserObject->parse($all_conf);
						$TS=$TSparserObject->setup;
						if(in_array($marker,$array_getTS)) $TS=$all_conf;
						
/*
						switch($marker)
						{
							case ('CONTENT' || :
								$addConf[$name]=$this->replace_setup($ALL['CONTENT'],$TSparserObject->setup,$ARRAY_NOT_EMPTY,$marker,$title);		
							break;
							
							case 'MEMCONTENT':
								$addConf[$name]=$this->replace_setup($ALL['MEMCONTENT'],$TSparserObject->setup,$ARRAY_NOT_EMPTY,$marker,$title);		
							break;
							
							case 'PATHWAY':
								$addConf[$name]=$this->replace_setup($ALL['PATHWAY'],$TSparserObject->setup,$ARRAY_NOT_EMPTY,$marker,$title);		
							break;
							
							case ('MENU' || 'MENU_1' || 'MENU_2' || 'MENU_3' || 'MENU_4' || 'MENU_5'):
								$addConf[$name]=$this->replace_setup($ALL[$marker],$TSparserObject->setup,$ARRAY_NOT_EMPTY,$marker,$title);							
							break;
							
						}	
*/
					$addConf[$name]=$this->replace_setup($ALL[$marker],$TS,$ARRAY_NOT_EMPTY,$marker,$title);
					if(in_array($marker,$array_getTS)) $addConf[$name]['ts']=$TS;
					

					}

					return $addConf;
				 }
				 
				 function replace_setup($all,$conf,$empty,$marker,$title)
				 {	
				 	//print_r($all);
				 	if(is_array($all))
					{			
						
						$conf_key=array_keys($conf);
						$conf_value=array_values($conf);

						for($i=0; $i<count($conf_value); $i++) // konwertowanie składni TS na składnie potrzebną do interpretacji w menu
						{
							if(is_array($conf_value[$i]))
							{	
								$key=array_keys($conf_value[$i]);
								$value=array_values($conf_value[$i]);
								for($z=0; $z<count($key); $z++)
								{
									$add[$conf_key[$i].$key[$z]]=$value[$z];
								}
								unset($conf[$conf_key[$i]]);
								$conf=array_merge($conf,$add);
							}
						}
						$conf_key=array_keys($conf);
						$conf_value=array_values($conf);
					
						$add=array();
						$all_nazwa=array_keys($all);
						$all_value=array_values($all);
					
	
						for($i=0; $i<count($all_nazwa); $i++)
						{						
							$nazwa=$all_nazwa[$i];
	
							if(in_array($nazwa,$conf_key)) 
							{
								$key=array_search($nazwa,$conf_key);
								$value=$conf_value[$key];
								$add[$nazwa]=$value;
							}
							else
							{
								if($nazwa=='title' && $title!='') $add[$nazwa]=$title;
								else $add[$nazwa]=$all_value[$i];
							}
						}
					}else $add=array();
					return $add;
				 }
				 
				 function get_page_root($uid='',$storage='')
				 {
					$title='';
					$pid=0;
				 	if($storage!='')
					{
						$where = 'deleted=0 AND hidden=0 AND storage_pid ="'.$storage.'"';
						$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('pid','pages',$where,'','','1');	
							while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
							{
								$pid=$row['pid'];
							}
						if($pid!=0)
						{
						$where = 'deleted=0 AND hidden=0 AND uid ="'.$pid.'"';
						$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('title','pages',$where,'','','1');	
							while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
							{
								$title=$row['title'];
							}
						}
					}
					return $title;
				 }
				 
				 function get_template_info($file)
				 {
				 	$uid=0;
					$pid=0;
					$title='';
					
					$where = 'deleted=0 AND fileref="'.$file.'.cachetmp"';
					$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,pid,title','tx_templavoila_tmplobj',$where,'','','1');	
					while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
					{
						$uid=$row['uid'];
						$pid=$row['pid'];
						$title=$row['title'];
					}
					return array($uid,$pid,$title);					
				 }
				 
				 function get_storage_folder()
				 {
				 	global $BE_USER;
					
					if($BE_USER->user['admin']!=1)
					{
						$uid=explode(',',$BE_USER->user['db_mountpoints']);						
						for($i=0; $i<count($uid); $i++)
						{
							$where = 'deleted=0 AND hidden=0 AND uid="'.$uid[$i].'"';
							$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('title','pages',$where);	
							
							while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
							{
								$title[]=$row['title'];
							}
						}
						for($i=0; $i<count($uid); $i++)
						{
							$where = 'deleted=0 AND hidden=0 AND pid="'.$uid[$i].'" AND is_siteroot=1';
							$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('storage_pid','pages',$where);	
							
							while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
							{
								$return[$row['storage_pid']]=$title[$i];
							}
						}
					}else
					{
							$where = 'deleted=0 AND hidden=0 AND is_siteroot=1';
							$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('storage_pid,pid','pages',$where);	
							
							while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
							{
								$return[$row['storage_pid']]=$this->get_page_title($row['pid']);
							}
					}

					return $return;				 	
				 } 
				 function get_page_title($uid)
				 {
				 	$title='error';
					$where = 'deleted=0 AND hidden=0 AND uid='.$uid;
					$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('title','pages',$where);	
					
					while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
					{
						$title=$row['title'];
					}
					return $title;
				 }
				 
		}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/mod1/index.php']);
}

?>