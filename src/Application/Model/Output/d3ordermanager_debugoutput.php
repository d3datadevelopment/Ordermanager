<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
