<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
