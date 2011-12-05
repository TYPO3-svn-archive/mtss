<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('web_txmtssM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
		
	t3lib_extMgm::addModule('web', 'txmtssM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}


if (TYPO3_MODE == 'BE')	{
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'tx_mtss_cm1',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_mtss_cm1.php'
	);
}


if (TYPO3_MODE == 'BE')	{
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'tx_mtss_cm2',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_mtss_cm2.php'
	);
}
?>