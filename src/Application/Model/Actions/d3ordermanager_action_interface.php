<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
