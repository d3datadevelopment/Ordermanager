<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
