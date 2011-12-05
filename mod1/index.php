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

$LANG->includeLLFile('EXT:mtss/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]
require_once(t3lib_extMgm::extPath("mtss").'/func/show.php');

$SHOW = new tx_mtss_show;
$IS_PATH='/var/www/mss/';
$IMG_PATH='/mss/';

/**
 * Module 'Szablony' for the 'mtss' extension.
 *
 * @author	Grzegorz Bańka <grzegorz@grzegorzbanka.com>
 * @package	TYPO3
 * @subpackage	tx_mtss
 */
class  tx_mtss_module1 extends t3lib_SCbase {
				var $pageinfo;

				/**
				 * Initializes the Module
				 * @return	void
				 */
				function init()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					parent::init();

					/*
					if (t3lib_div::_GP('clear_all_cache'))	{
						$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
					}
					*/
				}

				/**
				 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
				 *
				 * @return	void
				 */
				function menuConfig()	{
					global $LANG;
					$this->MOD_MENU = Array (
						'function' => Array (
							'1' => $LANG->getLL('function1'),
							'2' => $LANG->getLL('function2'),
							'3' => $LANG->getLL('function3'),
						)
					);
					parent::menuConfig();
				}

				/**
				 * Main function of the module. Write the content to $this->content
				 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
				 *
				 * @return	[type]		...
				 */
				function main()	{
				//exit;
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS,$FUNKCJE,$SHOW;
					//print_r($_SERVER);
					// Access check!
					// The page will show only if there is a valid page and if this page may be viewed by the user
					$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
					$access = is_array($this->pageinfo) ? 1 : 0;
				
					if (($this->id && $access) || ($BE_USER->user["admin"] && !$this->id) || ($BE_USER->user["uid"] && !$this->id))
					{

							// Draw the header.
						$this->doc = t3lib_div::makeInstance('mediumDoc');
						
						$this->doc->inDocStyles .= '
.info, .error, .create, .deleted {
background:#FFFF00;
border:2px solid #000000;
padding:10px;
color:#000000;
line-height:140%;
font-weight:bold;
}
.error {
background:#FF0000;
color:#FFFFFF;
text-align:center;
}
.create {
background:#FFA800;
}
.create b {
text-decoration:underline;
}
.deleted {
background:#0090FF;
}
table.szablon_conf td {
border:1px solid #999999;
background:#D7D7D7;
padding:3px;
}
tr.naglowek {
font-weight:bold; 
text-align:center;
}
table.szablon_conf a {
text-decoration:underline; 
color:#0000FF
}
.naw_menu {
padding:3px;
margin:1px 1px 3px 1px;
}
.naw_menu a {
border:1px solid #CCCCCC; padding:3px;
margin:1px;
}
.naw_menu a:hover {
border-color:#0000FF;
}
.naw_menu a.on {
border:1px solid red;
}
tr.is_update td input{
padding:5px;
cursor:pointer;
}
table.szablon_formularz td {
border:1px solid #CCCCCC; padding:3px;
}
tr.install td {
background:#EEEEEE;
}
.mtrep_template {
background:#FFEFC4;
padding:3px;
border:#FFCC66 1px solid;
margin:5px 0;
}
.mtrep_template_refresh {
text-align:center;
padding:3px;
margin-bottom:5px;
background:#66CC66;
}
';
						
						$this->doc->backPath = $BACK_PATH;
						$this->doc->form='<form action="" method="post" enctype="multipart/form-data">';

							// JavaScript
						$this->doc->JScode = '
							<script language="javascript" type="text/javascript">
								script_ended = 0;
								function jumpToUrl(URL)	{
									document.location = URL;
								}
							</script>
						';
						$this->doc->postCode='
							<script language="javascript" type="text/javascript">
								script_ended = 1;
								if (top.fsMod) top.fsMod.recentIds["web"] = 0;
							</script>
						';

						$headerSection = $this->doc->getHeader('pages',$this->pageinfo,$this->pageinfo['_thePath']).'<br />'.$LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.path').': '.t3lib_div::fixed_lgd_pre($this->pageinfo['_thePath'],50);

						$this->content.=$this->doc->startPage($LANG->getLL('title'));
						$this->content.=$this->doc->header($LANG->getLL('title'));
						$this->content.=$this->doc->spacer(5);
						$this->content.=$this->doc->section('',$this->doc->funcMenu($headerSection,t3lib_BEfunc::getFuncMenu($this->id,'SET[function]',$this->MOD_SETTINGS['function'],$this->MOD_MENU['function'])));
						$this->content.=$this->doc->divider(5);


						// Render content:
						$this->moduleContent();


						// ShortCut
						if ($BE_USER->mayMakeShortcut())	{
							$this->content.=$this->doc->spacer(20).$this->doc->section('',$this->doc->makeShortcutIcon('id',implode(',',array_keys($this->MOD_MENU)),$this->MCONF['name']));
						}

						$this->content.=$this->doc->spacer(10);
					} else {
							// If no access or if ID == zero

						$this->doc = t3lib_div::makeInstance('mediumDoc');
						$this->doc->backPath = $BACK_PATH;

						$this->content.=$this->doc->startPage($LANG->getLL('title'));
						$this->content.=$this->doc->header($LANG->getLL('title'));
						$this->content.=$this->doc->spacer(5);
						$this->content.=$this->doc->spacer(10);
					}
				
				}

				/**
				 * Prints out the module HTML
				 *
				 * @return	void
				 */
				function printContent()	{

					$this->content.=$this->doc->endPage();
					echo $this->content;
				}

				/**
				 * Generates the module content
				 *
				 * @return	void
				 */
				function moduleContent()	{
					global $LANG,$FUNKCJE,$SHOW,$BE_USER;

					switch((string)$this->MOD_SETTINGS['function'])	{
						case 1:
							$content=$SHOW->nawigacja($this->MOD_SETTINGS['function']);
							$content.=$SHOW->informacja(
							array(
							str_replace('@support@xumi.pl','<a href="mailto:support@xumi.pl" style=" text-decoration:underline">support</a>',$LANG->getLL('informacja_pomoc_zaslebka'))
							));
							$this->content.=$this->doc->section($LANG->getLL('naglowek_start'),$content,0,0);
						break;
						case 2:
							if(isset($_GET['set_html']) && isset($_GET['set_title']) && isset($_GET['set_uid']))
							{
								$docroot=$_SERVER['DOCUMENT_ROOT']!='/'?$_SERVER['DOCUMENT_ROOT']:'';
								$_GET['file']=$docroot.'/'.$_GET['set_html'];
								$_POST['szablon_nazwa']=$_GET['set_title'];
								$_POST['aktualizacja']=1;
								$_POST['tworzenie']=1;		
								$FUNKCJE->tv_comSet($_GET['set_uid'],$_GET['file']);					
							}
							$content.=$SHOW->nawigacja($this->MOD_SETTINGS['function']);
							
							if(isset($_GET['file'])) $content.=$SHOW->import_szablon($_GET['file']);
							else 
							{
								$content.=$SHOW->informacja(
									array($LANG->getLL('informacja_brak_pliku_szablonu'),
									$LANG->getLL('informacja_brak_pliku_szablonu_zelecenie_1'),
								));
								//$content.='<img src="'.t3lib_extMgm::extPath("mtss").'instrukcja_01.gif" style="border:1px solid; margin-left:1px;" />'; // Jeśli nie jest na localhost
								 $content.='<img src="/typo3conf/ext/mtss/instrukcja/instrukcja_01.gif" style="border:1px solid; margin-left:1px;" />';
							}
							
							
							$this->content.=$this->doc->section($LANG->getLL('naglowek_import'),$content,0,0);
						break;
						case 3:
							$content.=$SHOW->nawigacja($this->MOD_SETTINGS['function']);
							$content.='
							<table><tr>
							<td>'.$LANG->getLL('wybierz_strone_edycja').'</td>						
							<td>'.$SHOW->show_select('id',$FUNKCJE->get_storage_folder(),'','',$_POST['id']).'<br />
							<input name="wybieram" type="submit" value="'.$LANG->getLL('submit_edycja_szablonu').'" /></td></tr></table>';
							
							if(isset($_GET['id']) || isset($_POST['id']))  
							{
								$id=$_POST['id']!=''?$_POST['id']:$_GET['id'];
								$content.=$SHOW->show_all_template($id,$FUNKCJE->get_storage_folder());
							}
							
							$this->content.=$this->doc->section($LANG->getLL('naglowek_edycja'),$content,0,0);
						break;
					}
				}
				
		}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_mtss_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>