<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (09.02.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126F10AAQAAAAhAAAABKgAAACABAAAAAAAAAD/rZ/JEb9WcXYS1cQLxxi8Qx4wPRBsBa/EQ6yp+CURERv+15Lg8/mVq1cZWBV15UUNQRVpGCqA9piRgjToV4Gviu4HNxjStAu5Ovb0tiA+87ISI+01wo7GIh1QbkEvkX7hAX3U3K+F3Tfkk7hq4O4fMl8d9pyWIGy9qjYmefJ7Gv2EXpKDjLxGDU+uYWSUwUUcxnCLsaLVmfG0A6ImjpqJceIgoZzNhTurCAAAALgAAAAIHjkBTi9okO+zI/YWem86y/2EHGm+dOwa4csQ0ZZdniZVzHZ/C8k0l5H5IeFOaFC2Bdtk1b5YC3yImrPW5AAOhItoLNowSObIIDvxitk06YQfwWPo8PaLyTEeyRDUHpWyvp2msu7Y0zcKWP8xCH+y2C/Ia6SXE1/c3eo2XBrIaJm+eSRsavERDu2RESrpzBe1Czx8xt/ybycSLgBDBduhR57W+dbTpidWAI9yVVSbJANHZjHCvyQLUQAAALAAAABU3BIpS21DQn/YpbtViyqkC1MNrl/DGQA73YIgsO2b19CRWqN+WUbJpmZbdu5rkDg8R+D3lw36alfyNZeROCrFo5GnHj7reJjKvHM+yLYC4YtrX0DO2vDwzZsvAOujxQSpqVnVzLlDTJkG4LEXakxQarOPh8tRWpd9gy+p40iX2ax7Fx+EOJicb9KDae6Xf/iCn3k/88opUvvc0/g1CnkJvy90lrdIM7Si4EVZ9RRx41IAAACwAAAAFwHK3Q/r3gQy1uAiJo9Y3bTIQaSplvSTEviXsqzpp8K5xtqIsLWM8xvMWNCyG7WA/EvQWnmkpOjnfDB9GzANv+qsvxFUvlhUSYzytMAG4Aqpws7gJjrtPhAiI1kFv8D0POyCMv7m8k3eWwheaIRvnOCwTY4PKJfatJ0uIygFJhL4Hka7aWTK3rEmuDuKuvO4LKbP8am4Nb8HPt4jZkzBO0DUjKsBOMkkONNQVO3TucgAAAAA');
