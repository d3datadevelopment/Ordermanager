<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 6.0.0.0 SourceGuardian (22.01.2024) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2024, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3A7126E48AAQAAAAhAAAABKgAAACABAAAAAAAAAD/x3SZSirT96P+WjAE7XE/Uh+sokgwvmmzH0q6XpkUw2zetU/x0bmCE2cyC+d8bUV+9mO+ee1J++2LTz+Hu+/EhvODx693BO7Xc2VyPZe4+XCuEpwfWtDqxT9YjgQRqeKHjMtavu7HBNPom3lkaRej/j+PvWs8S53mzeNEYlWcOW1YTuzSC7xsPHbU7sCaBma8tqNqi7SLFZWw5VTXdqoAP0fj92m7PNzkCAAAAKgFAACNudBP2rIfEFkLTHE1dY7noVtbWOSCEw9CCWx3DqkwiWYhByUR4Uti8t6D5dbsql1PhU3mukLm+GqFfeFve49G1ZBHEJNOrOEFLbBIGaizBWijEKwx6FO416VXolWxOS0VoWEik+cS4idtNKEjTMSytHQlfUsp9Vqk8Ap4pSMCPt9TwyZnWK7PpE8vEeF7HDOcEDYUGTZWU/DkfieDBhvrWAICFAWsFLIBB8SJYimaW5ZmcBUfYKBK4/KXCTkG6gUMula1kb0aN+Iy4QWSiTL2YLnlBkNU/gH0fXYuGwh7K5IJo4VVYlGEdjQx9bKnjz52XWns3T971sWgETXhPGEbYUBYBDu8f0234abcc2guRjRqiStoeCEpsGSBTXaDArMB5d0CFEiyBRzi/aTpYuvfuIRiugXJRd3a4UzzmWpIRNJo1soYHROpeXHPD+Wud8rlCQKkRJDWdVoNBvme6CXvd41f9qOiYfTXv801dFHQbPdRFsNnsfMyIQNMjGQiZ5BlTpF0cBuco0PZ2MutqvJ8bXo8bdZ60MAlsU1NuZJ/6CzG8tT8xB4YXpj87+rNNznrnyh2kk8rl3/oDsNuH9mzPndCa6aNnCyUmX/WUu38SHyzCA95aw0LCCVve0ByyOFZvSAD1/XXgmy/E7jsVCRHEIJfv4fLpDpKezds4sbtVg6vkKLmgyLdg2r8huS1N6pRTwD+aeo9NF1lrIta5Z1mQ2P0vV+WBFOJktrAsIJlokdHkS4wf7Yi7P5SXtr49lL8E13RMy1elQgMr5hVOw8K9PzaeYbMQIGOR+u/PzONKxdA86k794P18utbYlZRlcECkPerDe/VDTuS0Q5R5W7jLSAwGzV5+wkKEBZHhN273Z7flUypGFVJgDUTzhz0kM1enLcXjHHqM01N4uPJ0i5+cib5l9nr2Yu5m8AJPnjRg2545xik6wL9iXoeO5Mjxc9hiHJQLzEmVERpgVqYS712lrQlhnLmYHxYG7LdhA4gpMvlZMiIXz85ZSHge//WapgvNKFUtO7Na6M9XFVuyG5dNloHb1CBow+p0scyypSPo286Z1kFD2faDB9I+wInRgMx0Ezw9aaoUCF3KE5r9XAwMYAYBRW4vs1J8+CI0TTOA8rVHMNjDfBj1/LEsmIcfktgJz8R2IALCSQqsWVmGuQoa4i22Q2DvqRlbwWSJhTNBdU4x+JNfRfx9+uVKpyXkM4uI34Lhb1QyZyOr0vJqmdUdYAkANGUgvzxPYE8sxIJ9Y/MOBjX5D8v8KCMsKVnqbuFIzYRk5hA45Qk8rlt18v1MjRLWgwmeM9D4l3+E5uDJ9aRbxWT2Px+MRC4l5YAxM/asFBjXmblg8CLuEQkHDei/OM/sldampeDk7FERDH2wWKNA9it97xMqqRUmaz4B0hKxyC+Ni56c6feObWTlnLWjxVOwp5it1a3F/wlFlsy+F7uiV82PxK/3f+VqchdPhRofWdB7PEkbekKj9wY73XEQTVTvkVFWX5hd2c0rb/AuPSUjVP6LQVvn2DHFl2uCUrQ5ZYE1SKK+d7Q/c1SsUINVt6sML0VxR33lGTtsNGYAWajQIrSbO85FzvDeJTgFyertzfU9aVhLZ0LYYQiZnKQmatszBFaEgeeRd3F2N6tgOYEgV7usLJTUlXRKcJIZthsdiBi8I5YP4aXBLNuV/nJ/GJ3+VBbyYxvzvJDrWGYdUlFBm4GU+FSAq1TRJKp6pYgR0wsz8ob2K4e2uzIgVcFrlp+T2+Tx7xnk5DqSM4r6j/E3TS1Dd+q95vqQvDUwcxPhmEROPdjYNXRgQGGPhT8tU8dOERjXj8wZvjZLi1aurnIkatBwxEsH9t/J3VP10xoT2fXxMectCbJFW5I6HQ15s18fpJ1QVIa1yzT7mOo6ra+QqjwwsCgaQlh+nL4kTAWvtK14/g7XFEAAACIBQAAtq6nSafqEsZSMbsVvSt+f3gCuCiTzZozAv58efnn+v7BcwSK4GlN/CbbAq7nQKcJafvhD6UGJ9u5uAwsNrWO5ZHmfvaek4Hev34Pai6OdApiNgLCBnhaO+scLRQgBBRS13cpayAjZcOL2sw2dNvdJhw40X6pfFs1QuJhbNy84stIh11+rlB5a5B/QhB8qYEqAmQcFqsuUnS0ciqOIDb/g0u+kECD9rCRm0MgXBWVuuNbdXZg/UznVmrfDnXT+K7FvRfIqn4hRRnSMCwRA+rt2CgDQt9IPwqObwpZlKU5rpcKl1ZcByhsUpaDCdqIDWtCOUxSowKEOW1D1qzZwEM+y0u8I1c2v+3WCLZumPDPimF1W/nx7Tbud2BVeRHkBvjJn52gQ4l3cATVQAoZCrcO8M01Kmaw9bCgbEe+Fqne3/L40PbyxEhT+MyfC8D74gdkd/tBDL+AMQSAKrnlJ9+bk3tvGqdhn3+ENmZDUop3BK8ZCp/dslIO83InAKrFjEVuefardtIUoCm7KlWnVsUAQsTlusLBRHNY8bGbNWGcKwPG+DpLTFTcO5uJjYiHx3fHzDYiDF5uy1PHoa9maRQRcwaGksj1d2fsE8FxilJkR9teyOKCyAaLmRetyRJ0I4F6o7yx3SU+J9MU3IYwGcpl0lURRnjC0pHpQUM5FJYYaxkE3pS2d/Om0ITBEsff4ftAS+czbTLm31bBBQECd2IdSXHV1WPBJ0DYqgZXb9PwGrI2YTKTUhw+PNpCGBYcOfR12qhoqGFQ7VhMy7VCbrs3XstwK/UBD4UKmUk2TLKFaN5j3bDf5oH1uVPj3YWBkmrL+gAH8fARq/YsYOrjIKuuQMY/uR1roC/RctZDcC+RXwWmPPPbcN/7z+In4wPny4fw7KF+rxCkF3Gr5XeQIyTDX36hRZzA/4K+Es/I8yTXEISSJvYOsNVt5m9ZqVmE4nizwkdbVBvjBhsUey90+F8Hx/2hQmreOU0eVBCylk9CYQRrtft+fEPIu6mDe5ukus9r8rqNqSGioS9jOqqtob4rtuOTp/2+5igmiQf+pUYndS33cMnmoDaJPXtrgBAbsF0NR3sSJsASBYL4g6DH7W2zY3Wki59gs9SjC5Stv6iVq2jJmr+zcawESgttSl4KyAUy5n7R9flUEzdW0w2VURZmYDnoc0ePASsXrDSgluoNiPk6T3WG++zDLmkWt4GzDYNrYx/sTcsEHiaGYF5xHQMOCs8QGv8ZOQInBAyNhBIscLHdX+3vieL3YH81C/g0l4BFyF0CO6bNbNTilZ6eBk2xxiLLoViastXpiEkJSzBgMwOcaa6Loib7h8y7nir30x2qZsm9xJVTUMgMs6o+0zfRxlk8OvvMHbvH+fttRgoJ4HbUETpRFT9ssUaVf1zWKiIRiyEDu1xAVuOshB2q1y793Ql9F31qSKko+lfsGgx3hgECVn/lPP/ETRE0nDXXCzMcdEdBI+7jeGbUYW4X3Ck5r7y9wS94FVO7+o624WpAdKZ9iBj1onS/4w78QqGu0Z2EIOb2JkO7YA3Pj/DDbZrLaK4TIgcd2VbtBwZZXAp76HHWke5oPkTkL4QOAOz15IhZx9BZ4ngNEI7XG3RyiMQOCqbf6FrJNqtqDEobiB4RCrU34/aiGjphqDNdrVDdQC8X//mi4rTPjmjtJD9ELOwv4toImZ9QNSfl581O7ZCfso2gHJNqklJaUck6izpa2jAxMniShTlEZk2gc6wmZ1ofOUC0IdwlsUv60FTP0wWZdp1TnFqLguDMnTU3/B899ZOnVnHHfxjexC9q3SCCd74pquy5YVNDU1FpfvVVt/3WjH8vEcEm9NaWqmZD3KomqMKm1ERkJYeoODGTh6UN/PDaMGUfTiz2JQq+UgAAAIgFAACFEXZ03Sn4tnCL+kUoqNHzpNVjXiWquWV6is0nLwraGBPNh3c37sFwYtnBWqDI5oKFYIWUiwuxeruCVHu/mIxV9SLpoxlGLW5viOSzg4KSOfT46KIB7OTRXkF+Ldx6YhB1LpWSO+/SelcxdOJGq/W1obm8TMl9Q9Rg2A1ctzmngZ3chBEtjgkGHPhvf+tdgpPJxh2EXNupfEApdTOXuTEJXrkZ2eKDQjzCN8NQOJCpNTVQrtA60JMuh4e0eZftDG13AOy8iWMopZX+JqZX04eeY0FzG3lmjVYDnRCsIJ4ntjDYncqwScQB+7T1VZKmvqTiNHhcLXylnuzhlSWySvwmuP/82NujFBpOiOD7I4/9D3KLoOImztNiWomNPTzqJh9anJdxUhdTtPrZkvB+49ZeLNQsTdu7+4qWSwGevQSuBqTFdqv5gq/1v6b/JHmLqAznLqXd79wGkz7flUm/5uXQGfojqUPINS7iy+X32b63vz4DXJvURR9iroPo0eKefh8jwSeZFE4IM8/EuhsRiT4TkkTLyotEnG/E8gWkwepgpqw6Gpwpejok2NDKwkcjehFKY55kmz/iomtdZxIHr/s2iDYS5jIbiY7zlJ26z1jZfmCCDRiK24jypr1E35nIBvGzkaIszgFwIyOLQJkc7Eyr0+Sf9LUzhDf+BpU7QJ3NcZM7yTAj90IPSorEcxhHFGRdU/O4TrdvBR9033wrHD05zI1aKX53FQ19C6/kaeNXZiRdP0KwEyeB+U8NJua2271cBXdxvTEwM6Mr/qaViF5GbandmbXPwNNjeWOmH9Mv8HPWzeZU83BRWLSoZkesVjaspC+kV5ToyW0BXtl2MIj3CwwZbZ1UOKn9I1+wf2Gyly1zbszLCCy2/+YcethW6JhbvHDNPMNPDPXJHt3G1+83WjqMDG6Z2cUV1TZqpPX+0+ccaLwyVR9wpeqbksxjT4j1N7sK0NaBUHGg1BsQTQ1WzVS0G6ngkqwaN0Y/vYXAgno/dWgkZBFrXljnru/yyKrYakoTN5WkkCDM9fPNkVNdu0gg6pVhzBU9pd4CN8uBRv8Ypz5cz49MDbNQhSL4TlJTzfPSxo5hepVycJhdkK35NldTD6V24D/KBBOTicbyvcK8tsV91gr2uz1DTgRunSZLd95HKbBW09WA1qV5uWgQDyiRtggzgST/K9w9Pp+8vjHLNysCBN0NBN7JaVWGuAkbSB8Lsc3DbyXBlgyyvUWze1wyPh+PKJFiAvXGaERqKuzilveJYhtqbW2OTcUc5yw3jty3W5XuihFWC9M+pwb7kugyxzr0oTCpk6AUbvfEKFCo9ofJPJ+XKIgHsdg4XlvRy4BO1Y+MNibkuH9xidJs8H6BdEPjGgkvuoh8Hn7BqRpWwet14+3pfJXln2hc1j02dFqTQUodI+lboYJyuBTe4UgEBvYUfCMjeuDj4Ji1kF81Cyk2bQec0Hj5xahLahfsl6tSdH30zYDzKLzEk9wK4zvj25YNulRxT8YCLh7/aiWn2VrC2VAYoZEuldNx7qRYQAAI1Drx2wmhKpkas7gmkXxNDIGcGguJrHTKfE8nPjIa+t7Qsl7dZRqmcmJz+sBrD7/d9S1Bjt4ccs5ODninZe09HgXl59LzfdEcrxE9MiRYEDbJyuOxxTCtQcEvQVwkADyAoooTv2ogo7A5jsaAGORITro9uRhxsC4zwLwk9zG/8zkmNeRjadwSr4ITOQODV2SHCE2zeKIwuAEq8POdJZxFYi5EfEpaMgaUNdHLlT40xY2Q4zXvBluzY7tdAcOzjW8PkcVwq7JPmO7LbJDI2fXzF7Pb/tbuxBoS0Sq7R9f0NuiQpsSDb7RO9P6lmgbMa2wi/fopcbYUnKU+OHMHUISVvhkcyVsAAAAA');