<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
