<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.3.0 SourceGuardian (07.09.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B31B126EC8AAQAAAAXAAAABHAAAACABAAAAAAAAAD/Ds4ohGC/2zFux1IumiZobJrbFjVhn0I8VeDAwAcYIFgvcTmqJ8unCMPkEbt3s318IOwuCNCrZUEKuiyyqVc6BU2OjVZkB9RNHMUJl6XuIEg8FsZWuNW3rd9RFWpCAudSCHXc6s9xQrbRbDCRnNRZOAgAAADYBAAAGNbxls22qpOAjMTKStspNaBnDIWYa7tn9W1sSMzUqe1IdevSyCT0Gc/9ME5gVYXLZ8sr6+eEPGPFI/P56kdwB44LhVrC44qFjf0TH7IU09cN8kws9FxxQLo6lsRJ3VoqFWcgOY7XCZ44GzruT+z9jAX7TvWIQ2RpgrwpJwT8wUjrwEftRUZGapggdPFydHhDHjFBUazOE332SaP9/xRq1S+SfW2dPcxyElGis+XIo5a9vdf0PJE4rwKq1kJQPikmEBhCWWLoTcFKr+BDZtM5ew6OJleAr7v1Rd9xAM4tmePBJxa6Zw/L7MMZv4zFldDJxHc6mKeqEXKsK7VsObsxR4jjlQV8GC7M2yFAhMYdsoampIIVYeNXrTTTMou+x+JYb8i2eFY2l+o0WCv6tL25WwHsAFyFC2vICy5wJXEkpnmqRblqhqcQlwL7Py/k3ow+lC50itNBdDyug6Ug/kqcWs0chUjlliJU9psOPBacKFkGxldTdTqo63FkPKuh/yucIp2Igw48QTeRS/1yCqtmxqzzsK9WxE1+p68c4qquYyyGMZsPIF/Q9RZ1BoErcg2AdNpQpvHOCVEkV5P/uJRFfUcjFOYT4HbeAcq4g71uUMUTlVo+S+rTMrC/h/OFdHnT2aFG4HDejqrBJBeGiCwwPqgpjZMuoMBZ+OJeppeeSxDqtFTVBzon+VrCu5PdWmrfdPNTVx3b5oXnLh/yNolA/QyfFpq4YXoAC5swMt69NIS8imz7XqvF7tFVPy6w9eKcTggTNe3L71lbXItUfm1MHPyjaBphBNnbiAEnkpOuYGZo7xUs2n5GIHufPJlyc733UwkDvUvUGVeXapZ1mn8aBQJiE6xmIemgU15vXtnzFCYnzmbys1kJ1K4V6U7w+dISg0UHgq4k+CdbypGHdUnengwaV1mO1cbWpZnqdlRqytYALbPBpqGKMKl/7cLSIg8htksYy1OEqUjgDftuVkC4mgklHUGowh29kHmZezBFeB6nIzGwks6vlZ32BxnHP6dFaPpAieAe0R4P58H4ujXA8oUyLsF7QMt7FOe7U6S902beCo8wo4ulJb7MzfXmXZvAFMdTZJzpAe7z7IetykFMI2jijIKDrP7wlDFLpVU8mQU/2YwVlq/EI/LBKzte0xLWlXy6TFd7bOpsB9P2pYXNojgYC5aZ1gzHU2h/+qW22FH6pc21cGQV/HZKhlzefMowfRoZ7tSYaFdeC+TR7A1bxd032HppNYiPxrgfzk30T6qikcygXq1jJ1vEI7GuSyrih4MqMnDZHFNt/15dqAxCd/iuXr6rshajVwo0PpyuFRYYI40PORxQX5irAg0vZl09JfnHdEzkAi68ZxjIghbHEZDPuD/QU2BB5uT/ypJ0BEouBM1A5pWsA6doBxvteZD7e+Aa1d7A57UB2UaHgSK0fkLH5Rg156jjUSgZ0BgJ67EPGk20zu0Y61qcJGbwgsQ3zSGS8zA3qnoHvb85XIBoQ5qL8emqFQyfWaPdrJwnHJfEtNZEbhiPSHm6K4F07Fe95OlQui0JgOcKjn1ueYll+D/t7R7tmweo9PlBa6U4b4gyFyPdugdYJ6D6otAyyMktY3DF4MBV2fnc1l3wp1GlMhbfEME5atTm8CDNNCWOrBFAumsPcG0CdVEAAADQBAAABrsmPbRMrFfCkQbPW+PcXstbVIadWjyTmENSwbM38UxTsGPqKy4aWavrEc52KA/wR/fFs23U1YaX2EcC/m1r9Cy2TI3o0sQU8o9IzqOneU7h1JOYruG0oW8hY48hrrRU4ujrNEu2/SIB7dzInvLUCnd7F3QJTZwPYJM/rzMUYl6v0uWYftEofsXoiM7iUd/Rk+bQ8qLhW0X0/8HKZC4UAlvNv9+/AZJY/h2PVmzi+HT6ffVvEMQf1RY3fPQZRvFpY1ZyAgOZEglJQxzev3534cxOFoV4OqiPDQ1t8VlF4S8Oy+wMnJWNTiGwY6+R1OLcKTf/7kqfhICjysB9jHFTZb5xozoOL1G3NQK6SrHF+F+LT3neOvHNHEtU2h/yn2IHqUzAQXYd0H0XwofwiV0nCmnbuRateW7nUkEW7ioCShk0OxxcXzF7LIZuR4yypOvqMA906gwdwGvOfyrQzR/rka58YwzzlN4nyCRuS2G8+FxNYp43omNuEJxR2aLzRFxfuCz6W1rDwHgWS92LA0NAObHd3ymBZIS1sagYAqDMQnHvPhW10LFH/eg4CKV/Ptpe1dIBZrDCOe8UP0DVGq1onjWE+xmdclEtEacZdPSn3oeq7JvMVzCiaQPGKMs65h73ouM/v+UAN7x9NKgE9gG/Ancb20uvgRR2ccxZ/lad2Z38ghxO+60naq86b/Ffq3o7pg+KUGS3KaIyf6D+EgUmj4a6U0N1EMfy7yGRVBBgouobh/OXBPq/Nots6VcQgqQaqN2tUwqGUIC1q66lbGI3c7yZZLjs31EelL+Ymj/VpgYbnuCjE1ymn5qjwPuMkzAgM3NBywsZpu4U+lBWjNvgGSCOBJke9NRFbfFipEjMuQ5dxPZ6EBkz/jClTgQuLp/gROKbOzR9Pa2ep6gWOKP/3QkLq+s8xErWFULffy/EDc9/PJPLgfSYF2Eko9CXMxu6dSaplMeVi2lwtHJu9IhoRjJV2OeUjxEVOTFA4p4qf5bTf0igFqYkKyb2Fi3D+djM95JD84AcGybVtla0jTM7p+eaPJHW688/qlaqUXOVGxpqNfNydj7IRwsJhn3xc8rnb6lZWfOOCamY4qzIw5uDJlPYmdlN2h+YswXj9CzLD3FVLaxwetzEsTTLpv/QUCikAduVPgX1hrlK0/P7TNJn2mmqDpTPKqdhcYVIOg5LpYtimREtIXOR1u9cqHzF9zlfcCvIoJ2ZQ+hAfp/j2p+AHUCyrnRbE8icW2qdptVy1GlOykr+SBzzE81BLFwgPISB+I6GjeF+G1P1KSiwa158RrrCuKX1f3aI5ogtI8I9CxbgGgVO+9dMY+1z/gUe2XD1/O2rIFSc4CPPRwcq7OhuRilWiCtlQA2zFRBpfkOtBwC/qh+HKbSbWWSOhdk2d/vO3tYYExMoPcAuJMAAYtmPbJkzDjouJhpaWsUkWx+x+oBCCF3rYq/xMlEC7haHRtXJzOH+Vf+X3wR80UKRAFdG20G5YVUwaRM8c8NIXZddWZVKCYxoQlhl4/3OlhpgXYyy6p3BRKgaq+pbztuXtO5w7zhGnRXl0zLPIvf47mfrfZz5pZgtRQJTkD7DLxZP10ml/4/C0ktw++OVk+XQMIvS/ZVSea+IsCpw7AQ4aKHVE6EAAAAA');
