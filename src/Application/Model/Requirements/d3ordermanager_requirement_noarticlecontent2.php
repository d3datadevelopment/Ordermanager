<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
