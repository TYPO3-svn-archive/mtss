<?php

class  tx_mtss_dane{
				
	function xml($template_view='')
	{
		if($template_view!='') $template_view='<beLayout><![CDATA['.$template_view.']]></beLayout>';
		$start='<?xml version="1.0" encoding="utf-8" standalone="yes" ?>
<T3DataStructure>
	<meta type="array">
		<langDisable>1</langDisable>
		'.$template_view.'
	</meta>
	<ROOT type="array">
		<tx_templavoila type="array">
			<title>ROOT</title>
			<description>Select the HTML element on the page which you want to be the overall container element for the template.</description>
		</tx_templavoila>
		<type>array</type>
		<el type="array">';
		$end='</el>
	</ROOT>
</T3DataStructure>';
	return array($start,$end);
	}
	function xml_add($field,$all_array,$opcja)
	{
		global $LANG,$FCE;

		if($opcja=='CONTENT')
		{
			$title=$all_array['title'];
			if($all_array['search']==0) $allWrap=$all_array['allWrap'];
			else $allWrap='<!--TYPO3SEARCH_begin-->'.$all_array['allWrap'].'<!--TYPO3SEARCH_end-->';
			
			$return='
				<'.$field.' type="array">
					<tx_templavoila type="array">
						<title>'.$title.'</title>
						<sample_data type="array">
							<numIndex index="0"></numIndex>
						</sample_data>
						<eType>ce</eType>
						<TypoScript><![CDATA[
		10= RECORDS
		10.source.current=1
		10.tables = tt_content
		10.wrap = '.$allWrap.'
						]]></TypoScript>
						<oldStyleColumnNumber type="integer">0</oldStyleColumnNumber>
					</tx_templavoila>
					<TCEforms type="array">
						<config type="array">
							<type>group</type>
							<internal_type>db</internal_type>
							<allowed>tt_content</allowed>
							<size>5</size>
							<maxitems>200</maxitems>
							<minitems>0</minitems>
							<multiple>1</multiple>
							<show_thumbs>1</show_thumbs>
						</config>
						<label>'.$title.'</label>
					</TCEforms>
				</'.$field.'>
			';
		}
		if($opcja=='MEMCONTENT')
		{
			$title=$all_array['title'];
			$allWrap=$all_array['allWrap'];
			
			$return='
				<'.$field.' type="array">
					<tx_templavoila type="array">
						<title>'.$title.'</title>
						<sample_data type="array">
							<numIndex index="0"></numIndex>
						</sample_data>
						<eType>ce</eType>
						<TypoScript><![CDATA[
		10= RECORDS
		10.source.current=1
		10.source.postUserFunc = tx_kbtvcontslide_pi1->main
		10.source.postUserFunc.field = '.$field.'  
		10.tables = tt_content
		10.wrap = '.$allWrap.'
						]]></TypoScript>
						<oldStyleColumnNumber type="integer">0</oldStyleColumnNumber>
					</tx_templavoila>
					<TCEforms type="array">
						<config type="array">
							<type>group</type>
							<internal_type>db</internal_type>
							<allowed>tt_content</allowed>
							<size>5</size>
							<maxitems>200</maxitems>
							<minitems>0</minitems>
							<multiple>1</multiple>
							<show_thumbs>1</show_thumbs>
						</config>
						<label>'.$title.'</label>
					</TCEforms>
				</'.$field.'>
			';
		}
		
		if($opcja=='MENU' || $opcja=='MENU_1' || $opcja=='MENU_2' || $opcja=='MENU_3' || $opcja=='MENU_4' || $opcja=='MENU_5')
		{
	
			switch($opcja)
			{
				case 'MENU':
				$lib='lib.myMenu';
				break;
				
				case 'MENU_1':
				$lib='lib.myMenu_1';
				break;
				
				case 'MENU_2':
				$lib='lib.myMenu_2';
				break;
				
				case 'MENU_3':
				$lib='lib.myMenu_3';
				break;
				
				case 'MENU_4':
				$lib='lib.myMenu_4';
				break;
				
				case 'MENU_5':
				$lib='lib.myMenu_5';
				break;
			}
			
			$title=$all_array['title'];
			$all_dane=serialize($all_array);
	
			$return='
				<'.$field.' type="array">
					<tx_templavoila type="array">
						<title>'.$title.'</title>
						<sample_data type="array">
							<numIndex index="0"></numIndex>
						</sample_data>
						<eType>TypoScriptObject</eType>
						<TypoScriptObjPath>'.$lib.'</TypoScriptObjPath>
					</tx_templavoila>
				</'.$field.'>				
			';
			if($FCE!='') $return='';
		}
		if($opcja=='PATHWAY')
		{
		
			$all_dane=serialize($all_array);
			
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>TypoScriptObject</eType>
					<TypoScriptObjPath>lib.myPathway</TypoScriptObjPath>
				</tx_templavoila>
			</'.$field.'>
			
			<'.$field.'dane type="array">
				<type>no_map</type>
				<tx_templavoila type="array">
					<title>Data for menu</title>
					<sample_data type="array">
					</sample_data>
					<eType>none</eType>
				</tx_templavoila>
			</'.$field.'dane>
			
			';
		}
		if($opcja=='FOOTER')
		{
		
			$all_dane=serialize($all_array);
			
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>TypoScriptObject</eType>
					<TypoScriptObjPath>lib.myFooter</TypoScriptObjPath>
				</tx_templavoila>
			</'.$field.'>						
			';
		}
		if($opcja=='PAGETITLE')
		{
		
			$all_dane=serialize($all_array);
			
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>TypoScriptObject</eType>
					<TypoScriptObjPath>lib.myPageTitle</TypoScriptObjPath>
				</tx_templavoila>
			</'.$field.'>						
			';
		}	
		if($opcja=='PAGEDESC')
		{
		
			$all_dane=serialize($all_array);
			
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>TypoScriptObject</eType>
					<TypoScriptObjPath>lib.myPageDesc</TypoScriptObjPath>
				</tx_templavoila>
			</'.$field.'>						
			';
		}
		if($opcja=='LIB')
		{
		
			list(,$lib_name)=explode('field_lib_',$field);
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>TypoScriptObject</eType>
					<TypoScriptObjPath>lib.'.$lib_name.'</TypoScriptObjPath>
				</tx_templavoila>
			</'.$field.'>						
			';
		}
		
		if($opcja=='GHEADER')
		{
			//print_r($all_array);exit;
			$title=$all_array['title'];
			$ts=$all_array['ts'];
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>input_g</eType>
					<TypoScript>
'.$ts.'
					</TypoScript>
					<proc type="array">
						<int>0</int>
						<HSC>0</HSC>
						<stdWrap></stdWrap>
					</proc>
					<preview></preview>
				</tx_templavoila>
				<TCEforms type="array">
					<label>'.$title.'</label>
					<config type="array">
						<type>input</type>
						<size>48</size>
						<eval>trim</eval>
					</config>
				</TCEforms>
			</'.$field.'>
			
				
			';	
		}
		
		if($opcja=='HEADER' && $all_array['title']!='')
		{
			$title=$all_array['title'];
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>input_h</eType>
					<proc type="array">
						<stdWrap></stdWrap>
						<HSC type="integer">1</HSC>
					</proc>
					<preview></preview>
				</tx_templavoila>
				<TCEforms type="array">
					<label>'.$title.'</label>
					<config type="array">
						<type>input</type>
						<size>48</size>
						<eval>trim</eval>
					</config>
				</TCEforms>
			</'.$field.'>
			
				
			';
		}
		if($opcja=='TEXT')
		{
			$title=$all_array['title'];
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>input_h</eType>
					<proc type="array">
						<stdWrap></stdWrap>
						<HSC type="integer">1</HSC>
					</proc>
					<preview></preview>
				</tx_templavoila>
				<TCEforms type="array">
					<label>'.$title.'</label>
					<config type="array">
						<type>input</type>
						<size>48</size>
						<eval>trim</eval>
					</config>
				</TCEforms>
			</'.$field.'>
			
				
			';
		}
		if($opcja=='LINK')
		{
			$title=$all_array['title'];
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>link</eType>
					<TypoScript>
10 = TEXT
10.typolink.parameter.current = 1</TypoScript>
					<proc type="array">
						<HSC>0</HSC>
						<stdWrap></stdWrap>
					</proc>
					<preview></preview>
				</tx_templavoila>
				<TCEforms type="array">
					<label>'.$title.'</label>
					<config type="array">
						<type>input</type>
						<size>15</size>
						<max>256</max>
						<checkbox></checkbox>
						<eval>trim</eval>
						<wizards type="array">
							<_PADDING type="integer">2</_PADDING>
							<link type="array">
								<type>popup</type>
								<title>'.$title.'</title>
								<icon>link_popup.gif</icon>
								<script>browse_links.php?mode=wizard</script>
								<JSopenParams>height=300,width=500,status=0,menubar=0,scrollbars=1</JSopenParams>
							</link>
						</wizards>
					</config>
				</TCEforms>
			</'.$field.'>
			';
		}
		if($opcja=='LINKURL')
		{
			$title=$all_array['title'];
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>link</eType>
					<proc type="array">
						<stdWrap></stdWrap>
						<HSC>1</HSC>
						<int>0</int>
					</proc>
					<preview></preview>
					<TypoScript>
10 = TEXT
10.typolink.parameter.current = 1
10.typolink.returnLast=url
					</TypoScript>
				</tx_templavoila>
				<TCEforms type="array">
					<label>'.$title.'</label>
					<config type="array">
						<type>input</type>
						<size>15</size>
						<max>256</max>
						<checkbox></checkbox>
						<eval>trim</eval>
						<wizards type="array">
							<_PADDING type="integer">2</_PADDING>
							<link type="array">
								<type>popup</type>
								<title>Link</title>
								<icon>link_popup.gif</icon>
								<script>browse_links.php?mode=wizard</script>
								<JSopenParams>height=300,width=500,status=0,menubar=0,scrollbars=1</JSopenParams>
							</link>
						</wizards>
					</config>
				</TCEforms>
			</'.$field.'>
			
				
			';
		}
		
		if($opcja=='MEMLINK')
		{
			$return='
		<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>FCE header</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>none</eType>
					<proc type="array">
						<stdWrap></stdWrap>
						<HSC>1</HSC>
						<int>0</int>
					</proc>
					<preview></preview>
					<TypoScript>
	10 = TEXT
	10.typolink.parameter.field = '.str_replace('mem','',$field).'
	10.typolink.returnLast=url
	
					</TypoScript>
				</tx_templavoila>
				<TCEforms type="array">
					<label>FCE header</label>
				</TCEforms>
			</'.$field.'>
			
				
			';
		}
		if($opcja=='MEMLINKURL')
		{
			$return='
		<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>FCE header</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>none</eType>
					<proc type="array">
						<stdWrap></stdWrap>
						<HSC>1</HSC>
						<int>0</int>
					</proc>
					<preview></preview>
					<TypoScript>
	10 = TEXT
	10.typolink.parameter.field = '.str_replace('mem','',$field).'
	10.typolink.returnLast=url
	
					</TypoScript>
				</tx_templavoila>
				<TCEforms type="array">
					<label>FCE header</label>
				</TCEforms>
			</'.$field.'>
			
				
			';
		}
		if($opcja=='IMAGE')
		{
			//print_r($all_array);exit;
			$title=$all_array['title'];
			$return='
			<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>'.$title.'</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>imagefixed</eType>
					<TypoScript>
'.$all_array['ts'].'
</TypoScript>
					<preview></preview>
				</tx_templavoila>
				<TCEforms type="array">
					<label>'.$title.'</label>
					<config type="array">
						<type>group</type>
						<internal_type>file</internal_type>
						<allowed>gif,png,jpg,jpeg</allowed>
						<max_size>1000</max_size>
						<uploadfolder>uploads/tx_templavoila</uploadfolder>
						<show_thumbs>1</show_thumbs>
						<size>1</size>
						<maxitems>1</maxitems>
						<minitems>0</minitems>
					</config>
				</TCEforms>
			</'.$field.'>
				
			';
		}
		if($opcja=='FCEHEADER')
		{
			$return='
		<'.$field.' type="array">
				<tx_templavoila type="array">
					<title>FCE header</title>
					<sample_data type="array">
						<numIndex index="0"></numIndex>
					</sample_data>
					<eType>none</eType>
					<proc type="array">
						<stdWrap></stdWrap>
						<HSC>1</HSC>
						<int>0</int>
					</proc>
					<preview></preview>
					<TypoScript>
    10 = TEXT
    10.data = register:tx_templavoila_pi1.parentRec.header
    10.insertData=1
    10.wrap=|
					</TypoScript>
				</tx_templavoila>
				<TCEforms type="array">
					<label>FCE header</label>
				</TCEforms>
			</'.$field.'>
			
				
			';
		}
		
		
		return $return;
	}
	
}


?>