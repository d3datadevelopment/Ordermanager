<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.3 SourceGuardian (03.05.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
