<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('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');
