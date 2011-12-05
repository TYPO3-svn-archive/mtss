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

$IS_URL='mod.php?M=web_txmtssM1';
$LANG->includeLLFile('EXT:mtss/func/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]
require_once(t3lib_extMgm::extPath("mtss").'/func/func.php');
$FUNKCJE = new tx_mtss_function;
$FCE=$_GET['FCE'];

/**
 * Module 'Szablony' for the 'mtss' extension.
 *
 * @author	Grzegorz Bańka <grzegorz@grzegorzbanka.com>
 * @package	TYPO3
 * @subpackage	tx_mtss
 */
class  tx_mtss_show extends t3lib_SCbase {
				var $pageinfo;

				/**
				 * Initializes the Module
				 * @return	void
				 */
				function init()	
				{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS,$IS_URL;
					parent::init();
				}

				function main()	
				{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS,$IS_URL;
					
					
					$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
					$access = is_array($this->pageinfo) ? 1 : 0;
				
					if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	
					{


					}
				
				}
				/**
				 * Show nawigation
				 * @return	nawigation
				 */
				 
				 function nawigacja($opcja=0)
				 {
				 	global $LANG, $IS_URL;
					$class=array('','','');
					$class[$opcja]='on';
					
					$param=array('&id=0&M=web_txmtssM1&SET[function]=1');
					$return.=$this->get_link($IS_URL,$param,$LANG->getLL('pomoc'),'',$class[1]);
					
					$param=array('&id=0&M=web_txmtssM1&SET[function]=2');
					$return.=$this->get_link($IS_URL,$param,$LANG->getLL('import_szablonu'),'',$class[2]);
					
					$param=array('&id=0&M=web_txmtssM1&SET[function]=3');
					$return.=$this->get_link($IS_URL,$param,$LANG->getLL('edycja_szablonu'),'',$class[3]);
					$return = '<div class="naw_menu">'.$return.'</div>';
			
					return $return;
				 }
				 
				 function get_link($url,$param=array(),$value,$title='',$class='',$id='',$onclick='')
				 {
				 	$class=$class!=''?'class="'.$class.'"':'';
					$id=$id!=''?'id="'.$id.'"':'';
					$onclick=$onclick!=''?'onclick="'.$onclick.'"':'';
					$title=$title!=''?'title="'.$title.'"':'';
					
				 	return '<a href="'.$url.'&'.implode('&',$param).'" '.$class.$id.$onclick.$title.'>'.$value.'</a>';
				 }
				 
				 function informacja($content)
				 {
				 	return $this->get_info(implode('<br />',$this->all_str($content)),'info');
				 }
				 
				 function all_str($content)
				 {	
				 	$search=array(
					'%br',
					'%c1',
					'%c2',
					);
					$replace=array(
					'<br />',
					'<center>',
					'</center>'
					);
				 	return str_replace($search,$replace,$content);
				 }
				 
				 function get_info($content,$class)
				 {
				 	return '<div class="'.$class.'">'.$content.'</div>';
				 }
				 
				 function import_szablon($file)
				 {
				 	global $LANG,$FUNKCJE,$BE_USER,$FCE;
					
					list($uid,$pid,$title)=$FUNKCJE->get_template_info($file);
					list($file_path,$filename)=$FUNKCJE->get_file_all($file);
					$szalon_set=is_file($file_path.$filename.'.cachetmp');	
					if(!stristr($filename,' ')) 
					{			
						$template_conf=$file_path.'setup_'.$filename.'.txt'; // konfiguracja w odzielnym pliku, nadpisuje konf z pliku html
						$template_view=$file_path.'view_'.$filename; // wyglad po stronie backendu
					}
					else
					{
						$template_conf=$file_path.'setup_'.str_replace(' ','_',$filename).'.txt'; // konfiguracja w odzielnym pliku, nadpisuje konf z pliku html
						$template_view=$file_path.'view_'.str_replace(' ','_',$filename); // wyglad po stronie backendu
					}
					$template_image=$file_path.$filename.'.jpg'; // podgląd w backend

					$return='';
					
					if(isset($_POST['tworzenie']) && isset($_POST['szablon_nazwa']) && $_POST['szablon_nazwa']!='' && strlen($_POST['szablon_nazwa'])>=3 && preg_match('/[A-z]|[0-9]/',$_POST['szablon_nazwa']))
					{
						$return=$FUNKCJE->get_all_file($template_conf,$template_view,$template_image,$filename.'.jpg',$_POST['isconf'],$_POST['isview'],$_POST['isimage'],$_POST['isheader'],$file,$_POST['szablon_nazwa'],$FCE);						
					}elseif(isset($_POST['tworzenie'])) $table.=$this->get_info($LANG->getLL('informacja_brak_nazwy'),'error');
					
					if($return=='' && $uid==0 || $return=='' && isset($_POST['aktualizacja']))
					{
						if($_SERVER['DOCUMENT_ROOT']=='/')
						{
							list(,$check_file)=explode('/fileadmin',$file);
							$check_file='/fileadmin'.$check_file;
						}else $check_file=$file;
						
					//print_r(is_file($file));exit;
						if(is_file($check_file))
						{	
							$is_conf='';
							$is_view='';
							$is_image='';
							$info=$this->get_info($LANG->getLL('informacja_nadpisywanie'),'info');
							
							if(is_file($template_conf))
							{
								 $is_conf='
								<tr>
									<td>'.$LANG->getLL('znaleziono_isconf').'</td>
									<td><input name="isconf" type="checkbox" value="1" checked /></td>
								</tr>
								';
							}

							if(is_file($template_view)) 
							{
								 $is_view='
								<tr>
									<td>'.$LANG->getLL('znaleziono_isview').'</td>
									<td><input name="isview" type="checkbox" value="1" checked /></td>
								</tr>
								';
							}
							if(is_file($template_image))
							{
								 $is_image='
								<tr>
									<td>'.$LANG->getLL('znaleziono_isimage').'</td>
									<td><input name="isimage" type="checkbox" value="1" checked /></td>
								</tr>
								';
							}						
							if($FCE!=1)
							{
							 $is_header='
							<tr>
								<td>'.$LANG->getLL('znaleziono_header').'</td>
								<td><input name="isheader" type="checkbox" value="1" checked /></td>
							</tr>
							';	
							}
							else $info=$this->get_info($LANG->getLL('informacja_fce'),'info').$info;
								
							$file_name='<tr><td colspan="2">'.$file.'</td></tr>';					
							
							$table.='<table class="szablon_conf">'.$file_name.$is_header.$is_beview.$is_conf.$is_view.$is_image.'</table>'.$info;
							
							if(isset($_POST['aktualizacja'])) $return=$this->czy_aktualizowac($table,$this->get_info($LANG->getLL('to_jest_aktualizacja_szablonu'),'info'),$file,$BE_USER->user['uid']);
							else $return.=$this->generuj_szablon_formularz($table);
							
						}else $return=$this->get_info($LANG->getLL('error_plik_nie_istnieje'),'error');
					}elseif($uid!= 0 && !isset($_POST['aktualizacja'])) $return=$this->get_info($LANG->getLL('szablon_istnieje').$title,'info').$this->akutalizowac();
					
					return $return;
				 }
				
				function akutalizowac()
				{
					global $LANG;
					$content='
					<form action="" method="post">
						<table class="szablon_formularz">
							<tr class="is_update">
								<td>'.$LANG->getLL('czy_aktualizowac_szablon').'</td>
								<td><input name="aktualizacja" type="submit" value="'.$LANG->getLL('submit_aktualizacja_szablonu').'" /></td>
								<td><input name="wracaj" type="button" value="'.$LANG->getLL('submit_wracaj').'" onClick="parent.history.back(); return false;" /></td>
							</tr>				
						</table>
					</form>
					';

					return $content;
				}
				
				 function czy_aktualizowac($content,$info,$file,$user)
				 {

				 	global $FUNKCJE,$LANG;
					list($storage,$title,$dane,$error)=$this->get_template_info($file);

					if($error==0)
					{
						if(isset($_POST['szablon_nazwa'])) $nazwa_value=$_POST['szablon_nazwa'];
						else $nazwa_value=$title;
						
						$return='
						<form action="" method="post">
							'.$content.'
							<table class="szablon_formularz">
								<tr>
									<td>'.$LANG->getLL('edytuj_nazwe_szablonu').'</td>									
									<td><input name="szablon_nazwa" type="text" value="'.$nazwa_value.'" /></td>
									<input name="tworzenie" type="hidden" value="1" />
									<input name="storage" type="hidden" value="'.$storage.'" />									
								</tr>
								'.$dane.'	
								<tr class="is_update">
									<td>'.$LANG->getLL('czy_aktualizowac_szablon').'</td>
									<td><input name="aktualizacja" type="submit" value="'.$LANG->getLL('submit_aktualizacja_szablonu').'" /></td>
									
								</tr>			
							</table>
						</form>
						';
					}else $return=$dane;
				 	return $return;
				 }
				 
				 function get_template_info($file)
				 {
				 	global $FUNKCJE,$LANG;
				 	list($uid,$storage,$title)=$FUNKCJE->get_template_info($file); // dane storage uid i pid(siteroot)

					if($uid!=0)
					{
						$www=$FUNKCJE->get_page_root('',$storage);

						if($www!='')
						{
							$return.='<tr><td>'.$LANG->getLL('nazwa_www').'</td><td>'.$www.'</td></tr>';
							$return.='<tr><td>'.$LANG->getLL('nazwa_szablonu').'</td><td>'.$title.'</td></tr>';
							$return=array($storage,$title,$return,0);
						}else $return=array('','',$this->get_info($LANG->getLL('error_brak_szablonu'),'error'),1);			
						
					}else $return=array('','',$this->get_info($LANG->getLL('error_brak_szablonu'),'error'),1);
					return $return;
				 }
				 
				 function generuj_szablon_formularz($content='')
				 {
				 	global $LANG,$FUNKCJE;
				 	return '
					<form action="" method="post">
						'.$content.'
						<table class="szablon_formularz">
							
							<tr><td>'.$LANG->getLL('wybierz_strone_import').'</td>
							<td>'.$this->show_select('storage',$FUNKCJE->get_storage_folder(),'','',$_POST['storage']).'</td>
							</tr>
							<tr><td>'.$LANG->getLL('podaj_nazwe_szablonu').'</td>
							<td><input name="szablon_nazwa" type="text" value="'.$_POST['szablon_nazwa'].'" />
							<input name="tworzenie" type="submit" value="'.$LANG->getLL('submit_tworzenie_szablonu').'" />
							</td></tr>
						
						</table>
					</form>
					';
				 }
				 
				 function show_select($name,$select=array(),$id='',$class='',$on)
				 {
				 	global $LANG;
				 	$id=$id!=''?' id="'.$id.'"':'';
					$class=$class!=''?'class="'.$class.'"':'';
					
					if(is_array($select))
					{
						$value=array_keys($select);
						$text=array_values($select);	
										
						for($i=0; $i<count($select); $i++)					
						{
							if($on==$value[$i]) $return[]='<option value="'.$value[$i].'" selected="selected">'.$text[$i].'</option>';
							else $return[]='<option value="'.$value[$i].'">'.$text[$i].'</option>';
						}
					}else $return[]='<option value="0">'.$LANG->getLL('error_brak_stron').'</option>';
					return '<select name="'.$name.'" '.$class.$id.'>'.implode("\n",$return).'</select>';
				 }
				 
				 function show_all_template($uid,$pid)
				 {
				 	$add_FCE=$return=$info='';
				 	$pid=is_array($pid)?array_keys($pid):array();
				 	global $IS_PATH,$LANG;
					
				 	if(in_array($uid,$pid))
					{
						$where = 'pid="'.intval($uid).'"';
						$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('deleted,tstamp,crdate,uid,title,previewicon,fileref,datastructure','tx_templavoila_tmplobj',$where,'','crdate DESC','99');	
						
						while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
						{
							$class='';
							$file_exists=0;
							list($file)=explode('.cachetmp',$row['fileref']);
							if(is_file($file)) list($file_true,$file_exists)=array('<a href="'.$file.'"><abbr title="'.$file.'">'.substr($file,0,20).'...</abbr></a>',1);
							else $file_true=$this->get_info($LANG->getLL('brak_pliku_do_szablonu'),'error').'<a href="'.$file.'"><abbr title="'.$file.'">'.substr($file,0,20).'...</abbr></a>';
							
							$ac_uid=$set=$link='';
							$link['usun']='<input type="submit" name="usun['.$row['uid'].']" 
								value="'.$LANG->getLL('usun').'" onclick="return confirm(\''.$LANG->getLL('czy_chcesz_usunac_szablon').'\')" />
								';
							$link['uinstall']='<input type="submit" name="uinstall['.$row['uid'].']" 
							value="'.$LANG->getLL('uinstall').'" onclick="return confirm(\''.$LANG->getLL('czy_chcesz_odinstalowac_szablon').'\')" />
							';	

							$link['install']='<input type="submit" name="install['.$row['uid'].']" 
							value="'.$LANG->getLL('install').'" onclick="return confirm(\''.$LANG->getLL('czy_chcesz_zainstalowac_szablon').'\')" />
							';						
							
							$image_src=t3lib_extMgm::extPath("mtss").'images/no_previewicon.gif';
							if(is_file($IS_PATH.'uploads/tx_templavoila/'.$row['previewicon'])) $image_src='/uploads/tx_templavoila/'.$row['previewicon'];
							
							if(isset($_POST['uinstall'])) 
							{
								list($ac_uid) = array_keys($_POST['uinstall']);
								if($ac_uid==$row['uid']) $info=$this->template_uinstall($ac_uid,$row['datastructure'],$row['fileref'],$row['previewicon']);
								$set='uinstall';
								unset($link['uinstall']);
								$class='class="install"';
							}
							if(isset($_POST['install']) && $file_exists==1) 
							{
								list($ac_uid) = array_keys($_POST['install']);
								if($ac_uid==$row['uid']) $info=$this->template_install($ac_uid,$row['datastructure'],$row['fileref'],$row['previewicon']);
								$set='install';
								unset($link['install']);
								$class='class="uinstall"';
							}
							if(isset($_POST['usun'])) 
							{
								list($ac_uid) = array_keys($_POST['usun']);
								$info=$this->template_delete($ac_uid,$row['datastructure'],$row['fileref'],$row['previewicon']);
							}
							if(isset($_POST['usun']) && $ac_uid!=$row['uid'] || !isset($_POST['usun']))
							{ 
								if($row['deleted']==0 && $ac_uid!=$row['uid'])
								{
									 unset($link['install']);
									 $class='class="uinstall"';
								}
								if($row['deleted']==1 && $ac_uid!=$row['uid']) 
								{
									unset($link['uinstall']);
									$class='class="install"';
								}
								
								if($this->is_template($row['datastructure'])==1)
								{

								$edytuj='<a href="mod.php?&M=web_txmtssM1&SET[function]=2&file='.$file.'">'.$LANG->getLL('edytuj').'</a><br />';
								$return[]='
								<tr '.$class.'>
									<td>
										<abbr title="'.$LANG->getLL('utworzono').' '.date('H:i:s, m.d.y',$row['crdate']).'">'.date('m.d.y',$row['crdate']).'</abbr>
										<br /><br />
										<abbr title="'.$LANG->getLL('zaktualizowano').' '.date('H:i:s, m.d.y',$row['tstamp']).'">'.date('m.d.y',$row['tstamp']).'</abbr>
									</td>
									<td><img src="'.$image_src.'" /></td>
									<td>'.$edytuj.$row['title'].'</td>
									<td>'.implode('<br />',$link).'</td>
									<td>
										'.$file_true.'
									</td>
								</tr>
								';
								}
								else
								{
								$edytuj='<a href="mod.php?&M=web_txmtssM1&SET[function]=2&FCE=1&file='.$file.'">'.$LANG->getLL('edytuj').'</a><br />';
								$add_FCE[]='
								<tr>
									<td>
										<abbr title="'.$LANG->getLL('utworzono').' '.date('H:i:s, m.d.y',$row['crdate']).'">'.date('m.d.y',$row['crdate']).'</abbr>
										<br /><br />
										<abbr title="'.$LANG->getLL('zaktualizowano').' '.date('H:i:s, m.d.y',$row['tstamp']).'">'.date('m.d.y',$row['tstamp']).'</abbr>
									</td>
									<td><img src="'.$image_src.'" /></td>
									<td>'.$edytuj.$row['title'].'</td>
									<td>'.implode('<br />',$link).'</td>
									<td>
										'.$file_true.'
									</td>
								</tr>
								';
								}
							}	
						}
							if($return=='') $return=array(
							'	
								<tr>
									<td colspan="5" align="center"><b>'.$LANG->getLL('brak_elementow').'</b></td>
								</tr>
							'
							);
							if($add_FCE=='') $add_FCE=array();
							else {
								$add_FCE_header[]='
								<tr>
									<td colspan="5" align="center"><b>Flex Content Element</b></td>
								</tr>
								';
								$add_FCE=array_merge($add_FCE_header,$add_FCE);
							}
							$return=array_merge($return,$add_FCE);
						
						// konwertowanie szablonów ze z
						if(isset($_POST['mtrep_template']) && isset($_POST['id']))
						{
							$rep_tempalte_info = $this->rep_template(intval($_POST['id']));
						}
						$rep_template='
						<div class="mtrep_template">
							'.$rep_tempalte_info.'
							<p>
								Jeśli jakiś szablon wyświetla informacje o nieznalezieniu pliku szablonu to możesz automatycznie uruchomić proces naprawy ścieżek szablonu.
								<input name="mtrep_template" type="submit" value="Napraw" />
							</p>
						</div>
						';
						
						if($return!='') $return=$rep_template.'<table class="szablon_conf" ><tr class="naglowek"><td>'.$LANG->getLL('data').'</td><td>'.$LANG->getLL('podglad').'</td><td>'.$LANG->getLL('tytul').'</td><td>'.$LANG->getLL('opcje').'</td><td>'.$LANG->getLL('plik').'</td></tr>'.implode("\n",$return).'</table>';
						else $return=$this->get_info($LANG->getLL('error_brak_szablonow').' '.$LANG->getLL('error_brak_szablonow_pomoc'),'info');
					}else if($uid!=0) $return=$this->get_info($LANG->getLL('error_brak_szablonow').' '.$LANG->getLL('error_brak_szablonow_pomoc'),'info');
					return $info.$return;
				 }
				 
				 function rep_template($pid)
				 {
				 	$count=0;
					$where = 'deleted=0 AND pid='.$pid;
					$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,fileref_md5,fileref','tx_templavoila_tmplobj',$where);	
					
					while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
					{
						$file=$row['fileref'];
						if(stristr($file,'/fileadmin'))
						{
							$loc=$_SERVER['DOCUMENT_ROOT'];							
							$newfile=explode('/fileadmin',$file);

							if($newfile[0]!='/' && $newfile[0]!='' && $newfile[0]!=$loc)
							{
								$newfile=$loc.'/fileadmin'.$newfile[1].'.cachetmp';
								
								$md5file=md5($newfile);
								$updateArray = array(
								'tstamp'		=>	time(),
								'fileref_md5'	=>	$md5file,
								'fileref'		=>	$newfile
								);	
																			
								$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_tmplobj', 'uid="'.$row['uid'].'"', $updateArray);		
								$add = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);	
								$count++;
							}
								
						}
					}
					return '<p class="mtrep_template_refresh">Poprawiono <b>'.$count.'</b> szablonów, kliknij tutaj aby odświeżyć szablony <input name="refreme" type="submit" value="Odświeżenie" /></p>'; 
				 }
				 
				 function template_uinstall($uid,$data,$file,$preview)
				 {
				 	global $IS_PATH,$LANG;

					$updateArray = array('deleted'=>1);												
					$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_tmplobj', 'uid="'.$uid.'"', $updateArray);		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
					
					$updateArray = array('deleted'=>1);												
					$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_datastructure', 'uid="'.$data.'"', $updateArray);		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
					
					return $this->get_info($LANG->getLL('szablon_uinstall'),'info');					
				 }
				 
				 function template_install($uid,$data,$file,$preview)
				 {
				 	global $IS_PATH,$LANG;

					$updateArray = array('deleted'=>0);												
					$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_tmplobj', 'uid="'.$uid.'"', $updateArray);		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
					
					$updateArray = array('deleted'=>0);												
					$query = $GLOBALS['TYPO3_DB']->UPDATEquery('tx_templavoila_datastructure', 'uid="'.$data.'"', $updateArray);		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
					
					return $this->get_info($LANG->getLL('szablon_install'),'info');					
				 }
				 
				 function template_delete($uid,$data,$file,$preview)
				 {
				 	global $IS_PATH,$LANG;
					$query = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_templavoila_tmplobj', 'uid="'.$uid.'"');		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
					
					$query = $GLOBALS['TYPO3_DB']->exec_DELETEquery('tx_templavoila_datastructure', 'uid="'.$uid.'"');		
					$res = $GLOBALS['TYPO3_DB']->sql(TYPO3_db, $query);
					
					if(file_exists($file)) unlink($file);
					if($preview!='' && file_exists($IS_PATH.'uploads/tx_templavoila/'.$preview)) unlink($IS_PATH.'uploads/tx_templavoila/'.$preview);
					return $this->get_info($LANG->getLL('szablon_usuniety'),'deleted');					
				 }
				 
				 function is_template($uid)
				 {
				 	$is=0;
					$where = 'uid="'.intval($uid).'" AND scope=1';
					$res =  $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid','tx_templavoila_datastructure',$where);	
					
					while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
					{
						$is=1;
					}
					return $is;
				 }
		}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/mod1/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mtss/mod1/index.php']);
}


?>