<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
