<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
