<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.1.1 SourceGuardian (15.03.2023) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2023, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B30D126E98AAQAAAAXAAAABHAAAACABAAAAAAAAAD/FoRI810Uvk/kc0VeUYKJp98jmkrcmqhYigFtQEqqkIWG+M/CFoVnelxhB7KuyKu/v0ujc/iBE1xp4gUxGBK1PmkWB+xcoV9Qm4pHKg4nmfnzhqoXHBNPDcvMAh9rLnGwIqh6ntlNlS/Y2FgtJfXFcggAAAAAIAAAYgetA/FyudLUz9djpTZtc1bTEiPuTvfWDXLOeH1QgMiLg9cKBceI9F3amsKe7MFKdhgoTo5VN5O26iUitIyXONq6AipQ/8kdc0/ayPfWugj+xvG0ZFbBIR7uCaPLkSGRundmTpNuwcvE8HNv/SwnPbl/rN/6Ff69lsXxCUle7j+0QhkEhM//mb8A11n8AK34Ef3xlmgC1YJbeKRjHsbSqCxCWtMt8Lffec2b2kfdLInmELVueTWAq0ZX3zudSRUW/f1ONrmp9mCMdJ3/qwo3umipVPySMsPbgRgeVlryT/BpYc0ogZWaigPxAgLO0f4iVoDwscPO1e2SnFL0t36ifgV/pa/tdZb5ifQT/ASaXnYciQiYOoLQ6whx6rHPf4+qTFHh/cVtFV4vOayCf8IAMY1rPNTsKazS2xld9QfBtrB+jXSRMnR4Cs3onYnBapqHTW0/cGYjBOC4W/ox2UoMgv3WQgcdD3grRZg6SYnsyjaTmzQPDQmAFVs7YBp2DMK81BsRHnLZMvmSvp8S/FLzs+k+jVj2d45kWqI056uJ45vkvywrXC2o3PyE4F+9+a5ySy66sr/gnJpjOcHA8FvLZpR8fp+5uX43kc3bLpBjdCoWXjdYWfZ6QbTlkSHFLWb7HM/FuFlGwaOiPRwiKu/BV/+lLxCoeBInPYQbpO8wKOc9BNt4gDtONSIYy+JU2M9JwVuL03RmJ1jlwzmge6Wh+Ntg6HXeCAIXVQQ53mbrPDYd9RQHxdfK3nAO7wvNzNBR74sJcGr0RNvBcyM49k2D1b0SSuDxKe+Q5RWp/GGX6nNaXGg/Nh+KhxJLgL6ziITXCS4kvUEHYyB/uXOAqf1S3tmWpPNokquvklydfUc4bT4evH6xeKAKzivK9o1SflqOeooOLgh3IcQXRbR+uqG9hT6Zo8hz2/w2i0y4UrdhJPhX14+CIGqf5yikUw1Ysglar4hX9yN6E/TfRmUVhO6hFIkRmxVenMklA2qwg+0U+hno6Wt6184ptK4VjwgY59drXCCuvhi16nEeTPUDNjHu63e2qPBs9pMdwAewpJO2G9rUokuijB12Vpo4+yBqOcxt5OrXgHKwfoArcksZzN3VZ9xRinwrl8MvbCrM0r/efAq5JxOfX0raoeEfC/b2R2H/COp7PB9+GrhomIDUcoaVuS3ZK2qFopUsAEbDfex46Vwbj7BZU0l5o4H5x1WRKPaiAf+qkvt1Q/O4OhYF/ScWBI8LNMksKYKq+h6kr+J3RwMibsWSJvpkuP3jc4zP8LfZwOAme0rmqKEf/1GaihNEDI8aTOI+f3ipryZvtLNDYcmTngoh1K94/VVw+tk41F3ugKk2xa97LpHhvgTfT0gfa1GK6tN/xXCgkRntehqNPZl4T2WW0WTayzxgmMSCPtJZo5XJnFsvxl1CM/Nh3mii+biFXmFg0tKuTtw7rvgHlvxI538pb1Lr3Fc4jWKBb7idq05SBCtsijlWF2zIP2NN8sR8kkTGqYKT02TLbICskP8rqChRhfsXr+wurZY59EcsCv/xgUVzjJUXe5RFn8T3bjdOetYsz6hhlnPFWvyQ8d+W9hI76RWGb0A+aSc7jiPaW7GC+uv2soVAuKz+YoQPCH27ixp+DBavGNjy/0JnThmIqktXlGWbw/AuG+ZGPF4HGj2uKYr4LfY+Vx4qSFkeWhOvT4DIB0ax6io3xwRZhvXQajOEtDa5TBBQA860ZCwelc4oyhCw2pNYrQQWeR+ePiRtxdYSj8BCZrc+PZeY0KJqyeBoKC0jVYCeIuYIAcmIo/9jwq/I5/RJkB4iGnaa10DD9IWsZKDmiKT4ynnL21wwV1aAs843SwR4jhiCm1RdWG+y88CEHqUfAn4wPZO0dkE7SH5EouoQI09jsa0SkWP1cVj8ybMnNC3dytba2ZKh66FXSvOQQYYyrjjwgRqWFMwT6cmLh92HPd09727iRWT3gZSq+ITPp8xOHJejcI0ICWQm6gOLVQHaTANqYt/9PnVUH8EuxnZvYWy9ipHiiTbErRLQlO5vuyBxCcg9/R3AdxoAVVT3E7xwP0+DHEhQ/hny1HGLh8Ge9x72fYS9nfdxmfUT+FuY5WwhPhuI31mJ+mQYtY20U1IsHPN4EO87aYxix5DneGZNgNlCNCCjl101ZPA9l34N+Dle8VkmTcpxFdaqjuwClxvE9vXZEajgydAzwFP4mfg3prXDS+/r2tTLK+BJFwoT/cH9Cj3/dnBp8s2Y9fYHUR9gKy0JoYQMF5EUEM45wbzn+DesPiQllwT4z0QH4f2KRLy50msCchDTH4Ul8fGCBbv+5Jvrg8H75xQbWLGk4oP7F+7s9nAwplA8rnM4mkTyr9OtKyd0ClYMEuDsKAU4agrXQoyVKomyIfLmUGCZa36WCbqqjkCNDzJ54/QQCw3t8epdiylErLebrhgSJStth2f925FQmdG2+K3Hlzz6WLki1SDMbIoecoH2lVYSVglArT69ekhVxtnrmDc3OPJpz9lMfX4Wvk4OscF15I/2o8xg6kBNpEX1GPXFwV22D+VUo5L4yOWRxf8hXp1Rh8RYM63GbFKlCadjnYl6ysDUeAILfJ4W1KSbQ23GYOCPZuVua2OUIQPNlFGU9lkhpv2HolhQyCABOhGuR8kwS91AauV/VL0FFOX8jbhImC06Shdm5tRIW5amLqRwt9xnFDCA/mla3FfR73F7/DWwxtsLBpltzBjwluEAR60b5UW++ZzDy1SKGNIsMthwZlMrIxpiU1omZ5VR+HLhf9+ELx2zQSPIMXIep7kuOAcILkam1zZOnZuJ1J/tTHzaIGMvrXuHDCkBxrqE9CD/T50lqZLZDlNxhw6eReBgIVsBsVarTHyMegsrTJvAhysE7l3rKt83qT+/+hUyG6Ol4UCE+xppL8f4CelNoem+OrDeCKlg79xwkIPA+SGzgZgNbDLnDPhJMFAL44T9m/m3DOqJkOiss10r9OF+EgqeedsdrG8kx6oPWPlBbO3E4PM68h8UXhdf+JvQuCDQjb83FOUOJIMUzyv5banHhi7Hnofd68/M7ZThNvSYFw6dBzMV1nFVKhGp61B3/kxyuERKR2LNUi5ZdiRsxcaUfqfyajhyVsdTxvMc0MTKg+qPvgG5IqIj73Z2zI2UXBVTpX2+PodEryLssmDbokvd2M3UCCY+zJSe/qYX8o0Yz/vWU3CRhS2sJJsDHWMKN49+HRc03885MT7c5qhpIFxRBrF0yn/t92RkBmWiwzocBvjnNDIE3NPOSDeaSinVo8ECDS+wWDf4JqA9aartGINtbNDcY3RCRe/xR2HFcixjMJdGcIqxE9b9Ck9GvZaLWCaqlvEmThMId7bE8MULNypTFB4QuzYf88vr20HgII6FA2cqZZZHz9SrQi+AErY/A6EVbiIZcuxK/Bpo5HKZLSPlQ8hVDM6Ic2NwS8pm5SD3bATy8P6rHVuz3WP9G1sZOH3MVeGKjkwCQ1jr+wCqnj451+osRbD1tIB+XF8esBkv3aS1edKfJ4U6HFu9FQJUgqRkxF+26EUCUnFG5YnKWkOG/tW135NHtWc5J0BDb06dSAJioux9AjdR3MueyprQpgrC+GUe6lrgD0WPVfl3KtCuDkzbX4SK/mctK52sYoAjfFo7FY/6JNPJkbvjAeqwfgbN4q5Sim5CisHtndJZT+VuxGGxWMAnWyfzixsaDpxYleYr1gLtRM6/l4/7s06X6JKMXEwxbKTEcfIXRwakbI1m36/RW0ouGh8yNFJXya6EJhbaGmwbjivMK01R9yfuKmnu0/I+LZJZXkxIzUVnzx2yNREW2VVRLfFxci5pCbeFnL/KGWcV6iIxauMoCvn/n6QMLIWf42CDaG4Zst1vuoLFu2FWzCDugpHYU6jqDE9Smk8OGy6DJquGVtBlaEaHZApkDWSxy2iexjYKcyWQNXCToL/DbeZhnX5kH3+Rcg+XHwN1eutWFs5ebj2UXuwRrOhsb2eUOLA7INwjiCRn2QUoXxqKy+HeJ6pDBwNRfbroaXSn/WUjmrtl7tPxs0cesnFRwGZGcremt3q3BeqRmt+CkHPINMXtRFVL8/g8u3JjTqn4h1SLqgjjqrr0b+SuMHZFm+CGkZ8NiSDFA9xE8z6Dx5/PkUpChmV7CdT9n8TA/9iT/o7DvpZ3plccbo3eYFBvOFbSq5vlNXMtVkurXxe9zJNglDp3V8BMjLVhyndwXhpLIGSjGvrDOtvZ+TfhjuEOwkEz9Gq9AT6mmxq+K6LGI21i+EdNuawiW8j6t0ycipHEW0xPkD/cRSMlObuM93ArUJklXhXDXmosEW8uo0n6mhds0nJXV3i6soURy7yHmkyXaCWkpe+zyPcEbtZmYBc2di9hwQDRm1YIT9WBLH//POeF0GZR5hadKmU8EfmhudKOSd26kwOy+sjSJaHB0nR0UBaP9wZiKZaayxn5gZjL5TGEcwV2NZPR2wwM72AJfuRe1heB3a9e/p80X1LZ82UPmAH72/klC/x18N0Ag8xw9MiP5+MFeOT4m7b8xJAzGSJz66i+mnv+s+DOjaIQgvJFX2MsA1b/f7P4iye213+oVikARZ4FV+Pk8AWOaFyG7SXMLG9kao+2ObJkPuap0UHdba514/y8v5JcAibNj8VUqtjuVq5ANbXPuJR61zGNEgHxhTBQh6vt8I1BfrF/8Agn1Qx3uwlUp2/wnO1xe0qgkQ4xLJ7YzBT306l2vX7guXIUGuE0v6PcLOYLjg7XUh/MfO1869vjnWS/RvrwKYtFrmHG2ekpe9AW7FMWVpXigRtpCbJxJRHQ9pCHuQXxeKySTqAvMHbByKKYWgfmwa1U/BQ1Cpw86BuxYL16w8zTBqI4tmAaMQgASAGGFnXi3Wf1IVE+VEIIzfJ5+L0Tvm7+4rmsDNwRnxVIln91lTsy2t2K8e4DtB4Y8oJ6/V4GEG6+TzUL7bh0DD9yGhuVaZPFxjH45FE8OzCpKwdxudiNOluO21/glqywQTwcScPwaP77I+UWKGL+TsoF8gWjQSAIryS0GseRrAk+e+zvJd2oP8fBKD/3th3uE3D04rFcjKcuAtaINmGIsfkeSC0BZE8LDRBuw8cMoIAKXvZnuasEblwDwzNSRb+uG6/n4gCG4dBWgrerTTeSpLGg0JFjeWd7235tCe9SZ1tZSjHRmRuAHbIqykFgHliB4cHJa6PWMcPlkRbSSx1dkIES3c6SljZ3tOtP9Ws6w11SbHd+Tbmq0NWQlYSI7hUqd+y5/xDAtmB0L089ZQfe/jdYdCDtgGN2cD9835rjyVl5AAkyBfaFeJxPSNzexeNFBsD2vJ5Jqt+lysXu1+wcKI/lIRSwVoAeRbvZOGS0F8UAF19NK4bQN9+/7S0Uap2k4MMXnFmE+ZG6qwxk8vr2UFYRbHJNtJyx9icikNBB9slGMuEreAikTl/dviNCW07xhTCzFrcOsBPJ3YdKfC42DPtsoWa61q3B+TWOptLCvdzy8DBAdpfprvsOyEYCF/ncMm/OP/5pRECfvDcPcn5CCIS57rV6xEEPHiYWP9CbEWSgLIrf8Q6wtlUVNK6QoBvNq7FaH+Y5ciFQDHKGMruNI4R3XUJ8Nk11pF+F8oWqWoY0y/gENlAarPQHo/oATDPIsiWtyEnoTHYt7A5QuhVRt53vBXjnxBH5Np3YI4RLsUrkuVc0TGC4FZXtZhpqtQY2JJmjeP3AwpQuWSf8pL5y/FLhf59kh3NrrfBCitxECQ0LYQyy860gylXk5eUDds6dq8dnwyx/oOmgmmXsMSlYUy10nz8rdux4oFIUJhao/WFVg4xOfM88vKAZu0T7kXTSHHyKuf9vgEQQWf5MOfbO/7aAcjsB23+4K1NDI6Dm0+GK98W//SiqZkmHMEKwP07NZYMkTEfMeZf+02gdEYMI9MeSeyGFIduXbOt9J+d0EQUJSK/moxo7iu3+1hCy5IfA2ohD2PLD5a80G4nL0IWxKYKfk7mQonxdbvdPFDSrbhZ9Lis53RCP9EovcukOTrYiTZMcl4M+Cm97dI8PbiQHQ08ownn9IEPMado6aJt7XxIy576QwAMpJN0vvjJbXRm9oBBQn++EZtC7RMxJCjrmPs0K09uMbw9uQM5yjhwMpx2jw64PJha/IxkJFdtQlWn+d/XiD/MYCr55a7GLgoIfR1xe/RR5xOWEyFI/PuZHzDd5OPChfCg+4k7BNon4MRvmYWQbXiWAbBiSblVUs/wc2nty0yPqbTGweXxlP6+J01fNF7L850Q0JLFLTHB2n315sh0hn9fzS0Yz4o7grFqxEzpOYNlhcPNYqWJ1Hc2l8dS8a5lHCFRBpwC7/XH8rDH2xa1PkMS3yuzEv5HmM28TJswsuqx1aGMZdH3eAlWQixXqFgqQBguUBgmzsMvffVY4NA3dgfwJMbSLQ4IsL94urNJn44G7d5UmvcknaopkC2ZTb4gE6RbZ9X2I7h96gxZxi84eSeRbuUsvmGVz9jmczvd25oltvr5vy4Xn2+vtP97XA6XxjBnApebPtyPwD6d7MQFJffessR4BiJgxzkS0BhedHhcELHGrfJ/7GwZlV0KBcT+UV29fsxe3+EkvxCAUJDDDPUhvkG4SeaN0VLSOQk9vAMOjjZiF4zHISNQlqVVFY2FPDz28bnEPYBBsAbyHHN9XAZKz2rLE8ftxgexY2TTOjL0WkaiQRlEa6WnPLCZ75ux27MEhWAdtRJ095F+OAE/r+0MqKoPJxvxncAkUjgwsIHsLM2KATR8xZNBTyjpelseGPsm2Bf1XiCQeaGCCzaPieEzmCLNXH6liljPB/wDNRwYIGWVS69HblumiurUZdYtaRzfy9f8HxZi5+jf/bM748BBFLXJb09SCmKDI8YKq9gevcuO4414hmFbs8A5E9aQKdETrKsy8awbaPExICbqCmOj+KwGbLS3eo3qze11zG6/OnzYIOX0S0vdVXkFAEzgo9m2xY7Pgz3AXcQciD7yX3qAXZbqbCFZ8DRzsW9hYaKdIabVCmnZo5L7YP3EfNtvOHS5WMiUXtsXNUXzE9PgRQp3T2JPsOa6L7ON1yUelFattladfifULOmLoGNGx97xUqcdpTqJ95UaeGSmGJYnH1GokqKa9hD45eiOhQEGY0EkhMuJSQ8eD1dZ+JUtseceMOxs6vMhdUPmJLXh3WMEzgvYTnChIzPqVzZ5DqZtmiFx98fHiD9lUHq0syjIgEyimbRNaVRt+tSgU4rDWYKrsU29H+68+99tzW0N83dBieZ8x8OaJxOVMILU1+B7azuEEH3uW5XIRvYE3NOEQwnyY2tiX/ksXAF+oozgCESFHvL0aVvBv+/4YzYxbflByFNKn3ezDXhlQRPQdAm6pWHwqXCoMR7UoWh/gqCe3h5DmI/E0V82fzRK4OqSNdQcqfKpAnGEMAUrxVaHoJh6y9BDui6t2uw2cCzzVhyWB4I8wR2+055h2vAUTdD3MWQqnRfEfulHXteV+IVhv1jF6hTenJFZdUTDDd+i/5aCHXmYxuo32+PltPRtvj3GSNIHsw2KlPxUGWmYAuAc85SFAvEOHjQZMCO+hhF7mQK8MpjAkvQ5z526ZnXPG307OX0PIp7EFHfis25pBsjiIYswYD/NqYW0V8PHyTik+PolqYuD7frwQeJK6Y3bweyrpo3IjbYZkiJiwo/QR+fkQ7iJH3e+ZwbPj5YtDmvPsJBcOJWNfq5LTwF9LrIYdUnyx8kwis5pwjydxd+C9fku7zdxQdqaeDrxxP+3uNv0kcuaw+WGrbeUGFry3wj9V4w/dwohPxpL5z0+lYcKd8VJmlZQ/JoLqwGYnGrum2p1AMDSbzFX/9PybOHvpdufGHvJZh2LC+0q17WZmcIl5DQv6R6yqNqGlxWk9BvbaCwL18I5qW9qMo7f8GAeAFxI14p2vWgo9I2IWEpugqJiv+K5P+bkiH9os3K/7nL0/2MGhdR9Dzv7wUd/s7nbC62lktNQpJ8wsqtWLJIuGbrxfwgfcckx/rJlDzR8kbQicUFC967S0XYPtx4hiCPMgLvzPQKuCVOozYYIktUgRZnQRZuK356E75mwur/Wd5MCv5jK2FvFKa/sEEtZ/qkQCyWoEcUN/UutmzBvZZIJFASJ0J291V48LbmzG/rk4NKnJBjZaKAen40kUXVu38pJz4WiPjyh11vVip51z+9FU9VNTswywPkWEQP1IcvHarpCFYod0LXHZTqUNK4zzjIrxsngxmiIvib9upUBK/tS0V4XixH6VaR+83FRvEm1Xz9oTQ63R7QaawGAGDzruaAwxXZyCxRNuMZKk7HTBodqSQOrrToPS+rOAoD7tqr+RsMhw5WySs9PMhAjuudPO0I8YUcoYrP7736Y8AcRTo4CeF7JlRwH4k9e2Sje5pg4gkntSzfSves5ptKI8uWV76yOwImF4Wo3o1FA8ACbowaxb5insEQlcbf/y/AEm+WyUZlTq8w4iZoczRw6wQUw1Dxpgq5os3H2XnhZ+F5EV/hY08Sdlm7oircpibiwAE8wryAZ+3EQlWDWV1VIZZssydG6Dk0egdMbbr50KbxMfCI15v1hs7/FqjD4JYqDCoMExt6GhU3iQX97UOlWOcznSzsIsIqJT2wXqHvCPy1dqPzd2fYy5a6Qm1ozg28D6CWDlNopQVxtGhQTbfn8X6cv7QCCxKDHOxBPJ9n6B7xrht1l5pOtRrmQyVVu/CMrD2tbcVoCZwYK6jc6ZS3RCp6sXxbFpi5UMHxNHuHJ8JHgxrK4jP95m0HhHj8bDsmr0142AbMwDcyMYQnDXpI0X7n/qnHIu8dQxkkXu7pDfB5+8hzvtdBe74S8qVcJWobYzcMzowEFoSahYBXBA8Bweypr1FY8ZHVxHySRwjj8mjnOjwJFk+Yq6+nbiUTW8rmmaWbsJTW7NTFMITRlfGOUooGISAqnRPgs+6lRPjse7ZBhmKEPHB0DWvt3bwFKktgj/nVTMk3d0o3YQ9n/YBMB5QAfkpH1dwztl+E0cOy6UbxmFPzV71Trf9B9Sm1cjQt/Cjt3eVpmsUErAiKcNbGN8VFZqavAvaQZPa3as7QjyOZ8soDJd8Wy8ZJvd1pwea8nXN3/ExETAgMQL0ODhtzafO+M37iaxkvRNpqFxpjikkF9VjKl9LIs0Ty27yG5xtstTEE5RlqLt5C68T70pQcYVClCkq6pBw+9yC9v6ZwxJcsqX8Et3aT7PmwKPD1/2barfkPIRdXmrRstd3I97/moOrJcdxqBnNjb512yGcErFd2CrFHm6oVOCsFReJv+PJIyJSTU+DAyrOaG+UIDUMpF7POVIrPnDkBX9Qbo+FfNUWoe91fO4b7BB1FoELDponHXgOtTvlgXFTHmpfyr2PNoW9unNZ6sb2sISY0j7ASb+3APJFHBeo8WI0p911t0ZxABl+tKtJYeF7nbiKpKCRQiAl9KCyHMiWyWGfWr8fqepu0qH4JNTBwdUPDRNVsXarEuomy0NPRTUBbAKjgYxx4r9tbm3n62L3/3ShypacU+G3PEh46FAb9MQi2pBC/IfEbHODteXsjS7EM2ui/E272bfcr7sa9zx9ceO/btrquF2aLlP8VLFM8DkdXeHFHCPmNHqATniS8iT20TfO74CWDoRUj1ujVUYcnk5j5x2Fk8JeNkw+g7Naj6WRmWHyfIztKjtAtDqD5rQ+tsfH0KcaTrUKFwCDPWc4egIO75en1yYyDgzsX/Rk5AkLbYUNY3QBUJ/dq9N5RA4WUdk21cqoKrXI4eU4Cusg5NchukzGhepjRvVBJW5txt6Qhz23QrctDJlOVavKeC0qndztUaWCkvyPHqHJCYv3CBQ/l8uocvm5WV3Vvh55RlB6K3pxp7XAX3T9WNLYvR2jobMl2lqvLrIQkixRQka4HeJbWcVEPB2HINhbQVEm/v5G8ScEkzXsM9lkrp66iAYsWQ29Av8z63TOFEDoELy1V/xX8/KGvoyAlNdg9pEkUcGqDvYERLYm2zrUNA5Fv3bnVQJSOIVzdFi/Atdv4qzIYgSiYn89dGBQfZ9DW9R5m+VrBUyURZqBXHisvmEEY0s9CQp+fyoxHVO4rH6BF7/bz2mBlcVGQ6yVtPXfhWqvktKSSrUk+X94XBcD3TeUIkc9zOLlx5c2thaE7Zvj2cemo/xjUXtaVptUXl427J2AK15MpGy3kE3gkLD9xfgqh4NkL13JpT4FTHjpt/R34+in52RTCsu+XdAxm5aFdcS9Bk9Ht4fvaAsEWn/Tjp5yH1l7kkKBQT0Cir4/DYM/uKIdNxuum82xdiBl/1xk4Qa17WQo7faWy/WQs2bU4wfAj877aigE972sXgdYQqn3b25QqbEe50aTFzQIEEiRyneT1a/jRTH2pZ26NRqQ8qvd+o5Nenqn1qkuf0HQYN+yw8nnD+vsO8R5PSTV69JVKsP8Xm68mOtsvD2MQrimIMEbpxEozmHvG8N0QY9LAxRIGBcJ3deIZgpuRJPKWTYTpLNNxoarv+QJ+gwDPg5KJmXCNdvS8YuB0iitAZ8LkV8C3mo9fmfS1EbbUN5aYDSD3Ms+O3NAbWKr7ryoBFzvS+ywN9VS51Azc0W6wx8L7BwXkuSlC5Gjz1NhNVUG2FbG1517fyCj2CaANn2BBDQrDNdb2OVS7kblsIk8VTyjF8Zpq6rhpzkZ0Cw1Z9/khx8acqCuz2r4q0v3n9eCXv4EHlvb+Dlj9wRFq2PZafsRXxMBxmSrREqUO8uWgTU8eozCtZ+/jmU4js0ABx9F/KRXIqc965OHGO45VkrSadrUpFD6JRQdGHYe38ifddDUvOTdJU8YwUa58nQOjZgaeo/CMCmuHZxEjx9zMOvQmG2LUM+FdwdFxTeJBYLuiboGyTjY0Ckc2RXB6ZLvsOJsVK64A48VJqv5D+Ac7lDFxYNJGj4yE3Aj6ZKTmVRAAAA8B8AAM25pmuQrBNOpu4gt2+PRTgzn+k0y0ScpjY47jPSlKrAMWauRVSAhv5kyTPbt/oBmu6tZOtkfQ+SfMtPlL+iz9QIcrXkY/HxYZr1D4dS3boJV8RGBcFdKyYpLoDM/RbaHtfb625HGkvcaOSapbghnmLnYGFYlZ1xx4LqIdcqNRDUvFu9C4p96LxVvJvqITHpRdhgGgW9zby/GzQ950ncVzmnq344bPkr19h5tfxZXPwtMPAxXymCofOKvX6zcCNSeDiug0WXFTk6W3D3NaMoYOLHSgzDHdIoFYx8RUMqJZcz+L1SkKcGePdFJwQEf4gcuCRztZZgdMnqSoQvxBfptjehZmZm7wngGXy/wrCbcQXuJq5NVHfHzCW9yDcgP7IwedoZ1efqrMxDfoBFIBlSTJr18orsmmnsGKseQL3gQLRlpVAHMw7YMWSKTNRHlFDupO0f7jdjAo6q+KUmalQJUdssRgegTQIgjiFzqAktm5zxckOS1k2dbuysvCLUD7gOyvpkZ1knpSopdNuYEG19yEnwefcBCoRKMpi31AYDk6cMzHpC6ZTX5uG30RTW6Xw/avGG3C8qBaUDJIPWE0TW9RS1NDBjdPp0ocIfgT4yOgGT/d2tFvkBuByAzJTL3LiMnlPxHKOvUThEPMPPcA3vr2nQJZPpeGUSMiP52PMn228QeggxO9SUTKWfuHvgayMJevzoThyUychjA0lCzD1rAjRfybuJyH+bwrs8lhwRqj50OSse5nrO+xIemXg3t7+CZPfYb0+0zTpzBlyfU1VYKJQTnt/fIvHMNDDlw5xvlEvEGBPw4o/iRhKrOv/XOlIil3tPRQ4brRYgBLUNHsAnesrPn5meSzvpqbgOetlJx1NrjyH3mV+HbwpbpmdoMbyW7XcpgPGXTqf+7yeT8AhAYvBPO1plHMrYhXUocdeucLOEexLA3jUi+3l5d+JIwIJB9BovqHI6XDQVZo5SUqF3cs535R4bjeIGYQez/T8h8V29he01OLmrKikATKv0ekKLS0/nSLE+PYlQiaKQZZqXcCTMyVix49pG94xGpem7H23YAgpxN4QIOXeKtkolssfHkaEsEHjmiKd/gX9pc9lSIrt/hvxeuOAlfaek1ohJIornSsi5dDapZCk2B2XSwmXxlgPDobt9eKH3Q6mxP27Y/jzi9wQaP53BTq7HyTTC3Mhi9gpqofJ5LkvMlui02xs9hmZ8oynsMcQZ7S5bEj8G4n0KrOn7CP3FZucP60cnRuK4dZOmMb0hH8/VvQKQR1OUlTxzU+XuaSRXj7SyZk4RkXLwfOZI3Lkl9eP9A287lzsRcgJfk7ZwcV+Ke5TynKsCzI7Lo3uP94z0ZMU/K5mRm0Pv0ZO180eoXkHl8T6uePBpIM/NPAj7tl9wOVIqN45zhLGyy7NmeXYJ9fGPRJkpNrVkTPCQI2O4jwkyrhlsg78sEmXpey/c32Qn0hNQLqXS4Qd/Yz9ShD88NkkdyEmctgICC9mJ34ZANSAMc2en4Qlai6PBPpnsHEFJLbinpr1g0YZKo7/EPiShkD14a4/RzDiprZ5c4ew7QcJC2NQgSfhexKBtFNxDVUH33inVt8d4j2gSGA2lCFgGdjHXvX3LTXyC9knlZJpZY8pHW8afPFr6G8wfZMbggNIPeFGwmV4QScR1We+YlrvvFaustcz0P3ox0HE7llDrj0BRT1IZfro23VaHNqzHb18b86h5BJNN7edIdRixoOXpzA8Ht6HL0DjMYxypw9yDUqtE+GMAeb/Oiu3tCxDJi6EKL0Kbkc4mmR9YAvTjDyP3Qr5WpfhpVtOikxS62AKGhyFAty8z3n7/4soB5FG9g+lEq2TI+vllcqgsL+OYvJFrnaqthIyacEG8aUaWZlcBE+82u1YRYvfzn0GHndhmavJcssZJIckfhPb4B6/RgGgoz2NRdielDQQQyBfuUQtzxSgQ/mhGl099FlBXNsAZxP5FZlJoRfV6KXhN3jWj5hIc+IwF7xieE9WFUtumlCXSO8J/BsWmlbtyeAsCgz8qBSlIpZ6cFdIUqIahYc4ajjdpGR9NtPfnGpw09FLDPX+0Cmb3accKKgA1lqKdXbs3xcG36zZc9NyVIpAj4SOZrBD+onbIpzcunRCj9AJE+HSYqXUNMvGm+JSEfvlhmIgEJ22Ni0lUS0FM/vcz377ux7MzQiE4VF0EF++yeW7Ch2/tU9SKHNzNlYo4LK1ryj8lyutX/k9MOJeXPQ5SnihMWu9HP8qwRuSgAtmrqYyxmohRi2211YbBG1gxSFEunI//W2DoEbb/SAD9Qp0g/QaTGAFXvdPblV61aYZggr6qtICuw2joGYEsqRkMxCnbEFzv/JcMW91Ca2S1NZlvyK/bowicMV1KMcZ0r7tXBFF3mgchGMt2ddbpAw3pTqSaReB9CywzQgWS6/EAHgafCHhS+wxVc9OjeOSjxsgoveT5ruBPogr1aJ0VhSIdLkiMtkcjoqb+aiJ67Vre957pCR6VaD/cRENjGJkjQcXtgNguZK1kaBYXK0OL5RSR/SfHx5DlJ3RIgS8otbbvvHhUfzBKlSFXmUPS2nnxKoiJvswZzPYQwk53lWt70BYPbTYgEoXahuVw0sJ/YUaCrQLBq5yNgWe4YrlMA3yc0YU24ImDsA9r/zzWYYztlyUsH02uWEH6uNNBJyreZGyUhpmDcULJFv6RXQCcO205vXu4i+m06vL4OcQv9q9KPtOl29V4ete3cS5Sybi48dpccr1oeLFWTgsM3pf+tmMaimhUwIHhhabw33RlcpeGZRGq4KDGrvZUhGUfxP1hUS85vnJTdOS12CeAVsVjZbYXMea3vDmI65kn531EV+/UGzdLbCh9qJmEnAwdLuqb4hrQcPfzEYW3bdsnTZiMs9kt7OwEr47B7rmPJqN/Z+I8tzgRXe5xF2TjN1Bam1Twm11BUJAY/9YIdrzkPGa+SBPzsTRgY+pjjKg6Ws7CF0r/75gGB13qzyvARVB9z3lliYKduhlwQDvOJJ+rGq04D3ifhgZ3cYKsA6NFfQC7T5eZwfo6JwHknbLYkTbnJ+7C8AKzhuvq2slsT/gWBE462KZnpSd0CahGdxoXLQN+Bu1ZGLIxwIzY1Z62bsMx40u9Djlk9jJxcxR9M+HYROVqRvZ8vVJvGALIJIi2240PHWrSkfwI8Pek/mGw/MHLsL/ExGXMIPu4QFQw+XI0KSmY9TLDD81TJtZxqFvYnQ8u8HHI1pz9O59GCpUim97MZhgE6nHk4ewTejef85baR6lppLeh5x0f8NTX3mSlIWlRSDD0xdQaDEwarVFXGK4ptPG1p8yHUnwZuBstRha5NUf56x4PEnuGCcOehwbA9ANcam94sF7hf7le4i8OXgXtfFeAuUAnaye+d+jGsLYDvgE6/Vy+936HJDwmgDKRZ32rb/O4KaJZGikjo34y/xj7vOq8FAWwjbcpWMRMCctFhxVs1Sty6wTkpW83a3kjJhis//TYDIrlBDg/lH1QCduU+sKCQffb3z6zH+XgJdrYg7EcRj7PGCP0rfjWG/DBJrrrNdt8uidm5z3YBF27eiaL6PvtQZu24EJffUeQf73eKudDpPBKWHqk9dLa2cAYZ/x0/zp/hV1UREqzgmA/dV9mV7cE0RtWnyuAte7xxgIribqu6J7yXrmSO5LK1KzrR+TUhd4vrwK1DVbByCGIhsWYLz7/3w5SQLUsVUuEFXkWGjXdUo0e1J8cbe1viPJ4aquETq5t1HjsRozN1NmWPhzGRUMwTxzXxFlilWfnLiM/cpqU5WsShfwmF2T0AiEOnJOf2WRWG1TYKTPMy/oRzsOavdje9F0ip4I6CmaktqkuwRjIoMORHRxVNoFHMMrzRBQozGAcX6j+9z6bsNaA2Q24qUd54GMbZsYIeumrs6QBs5eee2bzHfKbhlj4RfwCTTRa6WN7sQsylhYW7xYwoyHA3RIDcvw5iuwdaXs2c8MHrtRb0d+Ks93prq0U/gmrsFuB7Cyp1LALICi/Z5aKNTLr39OCGmk2c3Up7eQTSFbn7xXGA98x2K6DdE5CR55MYwNzuFIcCHI4oK4yAyMKsxE52WK2d6iW1Azo5es5sfzqc87DZ7wSBzL0MKBY9pWO2GNBwyNSfGxbaBaNzZb7GSkQGY47nFaa1KU/aeEzQGN8WwS8NiM6gQteEiUvUWev2rVWpzm2/rwTNEL+GwmIARuMR5sEdkV3ctObj2xqa1pFxtSo0xSGGwHZlulEoCa7GFqDqaWI9WDz/Z3n/4koNTgEZ7vN0P+X3mivp689V5K6upp52c4J5q0eY+qovDs7sUPaR0G3SQrrfT1DKNYYrtUkJN7pBoHmeKFiJUQ+O/ACEyXd+52W5CTtkrY2Sd5DKILubERpOr5Nn4UjJyap52DcWPl0NIbMrIx6FiyZh1s6Nm25zroE3kbyU07BEI5GiAk+0LHdf12Ott0PMFFKzElEqJ1kH05OKvgVmhAL/+NdQAmiqn6XeWhSGyT9ZyLZ8FybJr14w2SzDA7nx+MeZGkwp31+GUdghOvWWev7k51g566hpeVvg2oecJ8J/TgOGI6kp9mqt62AImsSmLB+pyq2iQxrXVdrYvy6+D3E+RYQ3il1QdtHtxCu5gSt4sR6dXuGFGOPqiYSSgDDMSPaHOsSthLb/nx5e2rGIWeroCz7C8olQ3BRURQU/IjQ36Hbwux0+GVdRa2vQhI5otFZ6OQsCqqDEZ18ypIgyAUBiCINxwcDJCKRbBpHKpTqWS5QZBh5cGusb0beC1TZUj6/QkjGC4+wWBwdRa96oaWppUxXHLH1EDnrWj+8fPtOHU05hgCsQ18OpXOYBmlYyBisUwZiQq3Nzc917L5dZDYc8IZO4fipFdPhEUNGIyu2mDMvQgLH4L6ApWlvm6bWe2pju4Iwwgy54+jj3PPXlY+t6DGAkxhXQZaalH03RKdWu/jY4GSMGnTdZGzYuJ/rn6N5XGdvK5+4xHyXaFMiMIEMC0RvKFtc/vnFduS/QlGAcjjezzgpTEPgVPoAN/I/b8YtvgNUmew3PH66JKtGJ11O+dVRGp7v6zk3gd4qGBKEMXnRpGbD6K2GoDn3RBgFlGfqh0Ivy0kxOpnXdP+9SnUsxyhizGNngC/Z9SN6c8PrXMBF3lfeOG4f9pksEGrUqFal8yAOZQw/d53OnAjzkWHhEIquaoHnE/BCHp/fniMQtSdijKj8Q2wAO9dJ/wTr3IaGHReQ11+foka/UXEX2VB/KC75Q/t0dyINGwFmSrUBaypbExxzaiNp6g1s3YdDYJSOAcEGjF6xteWGOhX4NgivEnG7U+pr6g8KpyOXD6Agw0yrltnUclVB/zyGlwd69Sbav9c+HmhbalCaoGActgQW/o2bPpg0He/A8vdXVnO42yc9M09BojXf++Zy7KsqtlU0oan9gACgCbYSv0d+0NlsGBs65pnZ9V6aOLIF+/0nrCagJmnPVXzJzKURxU70sEZAeO8FqiayT+magvc/wXXTwmmxgZ9eR2e/SSH68w1v+y+xHaqCWBw3s5HNoBBTLh++MsLGr05tnYOX2k1qkJcE+BIYiqzS1yKOR/o1JKc+gBOg63oWz0lOixQu6YCpW/N7EuPWlOi08NtDT6eoj3uXVoOEQ1iaL4T65x+YoURzUWOdwhc6jlndlSM6PTzMgKGL/028dzPJHAIEqluaCVmPkyV4yV/fEUxRBWuTgtexXv2xCYmCLKAfGqSou08T3qz1VgiwBcnqgkIz+SBY0iwJ20j6wtlCo7rj5/C4L7LVDXXaFCPct+9vQ9fmJr0wABQLiTdRL+vUEypd3jFXLOf51ZKqoJnWi7nWiCHYTNbICwcvFJ3ziucmAiSv0pQKFOVKe9CPzDoTID+iJgseyhidkvhWaCbDSSMZYCLeJ0zV9Ez3C595DLG9PgXyzy9prgHz7IDC34xiKRbuUTp4z1z77/VJhYfMTo4MpjKlWhWSRFwLbP4mbGK0gdSp45KbArShhusMqW3orBkfnxF41AMxFy5Fi8cxR6mG9f8D3F+MdMVLDsVOLnH2a0bbShqWfhXhJyIcBiz1G3uVEywK5VTQuzGwNwvgINNy1eRO9DiE5gx2im3qeM+3Z0lBW5dZsX75xwccZI3ZiJMakyeCR6MgsQed4LuZstyVHAIsZ29iVWqyLJnADwRfOhryb0V6kKg+cVGzBaX7C/DgxFVkXrlPb5J1eEEpPY8SX0iqoKMdcYmIhfMnHzJWuCF/Fq95Rj/UEct/WHdxZggbXTbr3hR1WINzHN8zT5Fh/F1X8TNAPvBDrNmTPqDLbAoS3i8ISUu3tyiv1OwzgU0pwY/xgamz2g0poJvXRABlYirMYj6NEgX1C8pOCprW3UVg3hibFDM4qD4BZtC2Dvx+rqLPaLznOPG/jD1naBo4Y8qz/hOX4jIzHdpAemaqOw6UKUh3eXZlXnnvxeYiTtxH9VGHHwohE378VqGJc+LrYDfRlIB4ZySUP2btYsU+CU9yG0ZKKbDOtK5BMX1x8UVQZtkkKHaaQWYUAvWWoSLbKo5HXPnlt7Qev+5i+u8VfdO7D50Ckikbf9fDO8/U8Hkv7iQPFTxhSNCImGhC+c9VfsIv8uI2kTy62ftrjee6XXdehJVQX7unrZDKviZr7o2LiuZfOpADnM5z5wp9orgj5fmX7ex0DZ8joNxaGk+NQ2xdNbmq97O9uhUebRJFCFqBYACs5OKvf8yl58QKtQvpYsf58jlYemMLE63o4Uhk/66C5ZGmtbv6gjW6q+NAR7yY4CP+3ac9UsL/px7yPXk8jVYkYeWrwT3bZnW/8fYDjtiIexNAq79eUoyXsNNTouRHRZhBADG7LE4g90ePFTFRbnqkYlFUEWQ9QfuyfqWaIm6S6zYAYF6WWrqzscXz2N/tbFAcaYSrPAE5ww/BqI0/2qli0xN87f6LOyVJ9QtQLRXxIRLNhh2jqjtMh8hRC7zGQXHpIHrtHhHhr2mzdpQ9StF3w47x/5iFFm9hRnGFXfBQQlEVWrvLhCd/2AMJO6+KoUtvCUwUIg3/2zCEby3M6JOvKkp9wjXu3bzirZ28i86GjIBHQo+Plje0zn0QS4fwhRr1WLX37RnOtPOwQHalqqnW4R+7Tv11IyNvEd53tmnDpjKQZMS9SczV5HV1xMUltMXBdGcj/wnHfzd1RR7OqEtS0Z/ZezbNGS1MwaEDyKYP4z8lsYrybtbpXSnPZrNPwJJOr+BkCWS/83KM9AZ0BIYY0UanS/dwGW97DaSPUC9q+dMgiTc/4xL104UpD7C1y32t7nF6kFyb0GM0EQtwIH9vzPgZvITb5d0nzJ5irn3XBR4voX0dRI5V5DCS4L3efw7bwda5PEFR+BvnMJBjLcez3eVEtnfvGVlPxtuj5pftjN5WG1Hpkhkn7+WhQ+yErnEyhmt6Um4i5a+PDgDvAZY3Ppf/1JwbHxTWm6pVbLB6rWpfgsF8bZrDe90RF5DPjssOASIrmbTGmODi5HylRts4lmkO/zMwie/k3SKs5S3BSimEz+XqP6L2sLSefVmo/r0DfqJtPYqQyLnqJHy1RfKU0gRj2IAHBaY1cFa/C9njWl/vJVkaG8dqLYI8lgqxFlblugbzoDgb1gVS+2nGQ+xoMRwBTkx308/Hs4C5mGfOMpPnT4mBUoKLpBtvT/dAyyGefSPO+d1q8USHR8ij/8zNqDcEExyMKmc3yy6meJbKoHh2UbhPZ40boxqXVPcbUUIpfbQGvFt58A2lW9gvIRPnNJ9a5POGU2XQH087Ftyfq0eyER0sS7KBxooZVUqnlrGkG+tkSUlK6KyaL6sscEZsviwXkLmz6gYkOfv324lRAgUiUOCoKdAYGn5xQC/JyJgsoI/oG5XIvVpw0mFlEMAKm8tS/A1WpnV/fRcviczwxTv6HwrVkhxWU+Pr5kbnW7GbNQTvLwFdjDRBow273hkNCuzTtb0YHPb92pONcGJx6g17VXCoaYhBWxU/Bei3YyXkO17fmyPyJTjN9wU5Go1+APrxdXgoXlfWkx+mMB+Ex8m8Fg1T428IvRwdickwZKPdxg9qZLi76+VrhSGbCjOF0AsBZMGQgu315h9fk1qEKfPFG0UW0ejS9DCq+m1U6MszEDwU16VRlX2YqWyHsJlnh75ICcVw1nQzW/rjLLJpiHPlK7Wfs6z+cYBhNtrVzMAk+B86CC1Nwnw/qbJc0JgMW4rhDYUQcpDHZjVvlhgkHNymQv614IBeqmoiutYZvvFN4WIeTN3zF4Xoa6mbKEPag55u+vqkwdNEyY9j3shw8iaCx2oxvyqfBWy9RMrUE4ArkfRpH/7bpn0GFZGipPJu2X1JUYc8KRDQClb6W9rju0V7HSj8WmfKfTPxviNuZXpaC/zMyR/V1cnXUuuaIKgDHIrYgNjvZMl0Kv1kCOT9rIYXbOIuHMCvJEX8jO9mLpt7XpgQVcckpWjfEKuYGkzW+XhzQjnSemm4FySJXbhcIzMZaKZbWPHxRHDtqVCRi9up5iqeNAd1tqj6YF9FuCPOIrwzw7Etc1zJqkqw0Qj5jOPmq3ALfPnmpLUYAsKuPznjAapFcqqAllbwxzwQ/CcSAteHFJIrFse5BIE4d7rjcaDLO19YCS5DDThM3A6Nr9Duj/RqLDxzCvxHiP1dlQUFsBi/wDYCLO9oUsALiacGEdxcNxZXLigagCqUyd8mPKM/ylMbGVvlspRcqPEyRsl2EhxzAiAStxIPIDhhivAqVoCz6RV6aAHr9YJFMZEluCRtW/sI+e/A8szeo89HOxvoPijLd/UMXZWkZdGEpCzF9xviomBhh39XgzA7tGW3AhUch5J9IaDUNPvucKmouJ5KR/3MRjjEWNZ36pP2u6mqYo0WP0DEY88ZXMuxrSA2znwS+zQkvcc8dosQlVXFbEC/vpAKCsWiQ+FwqXHOfYsoRQsr4lrN11Bz/MpRbCkdfYnoQuGxG6ewZnN5y5n+9G5HPgGvZMxuYj2TamcRvCyn9OhG1Ce6sOU/T0wawWSu8WKi7PgZtgWxUJ8PhKhQ2MBe6juXtLfavv+yQ2Syr9SUBZRXRe0X92UD0TmwqG2uTRPP/PX78nHGMKpRXD/Rj5n0lJagAR3DBYfYC+hkEiDVhjds6LYBsB+WbbOePlWouqa+9IHUVgzrGQB8D473LmHClr8xf7UzhjdsTd00zYFJIJkExTjCHOh8yXwBNlB3k3aSmnAPXla6pumUq5XWZyyRNQZIOPBvyxBs7yVTPZgOuRjR62SnYuyevtgC0mC21K84BvrrgYN7QVPD6oEqKK/ZHRH3voms9dwDj5slGXVm98Cuqw/UTCukbBHaWHSgRO3E3EhQ2aUOl3wMeX3WUtw6vvlzaq138hQU7T3sMMuyGmSKZ1hTMuJ9vP+O7w+8E3bbBZA9Ic5tdEh8K5MXV0EJ1KNwyPETB1ltTpDRMC8+xScvFsKEzifm7JRPEBcZpdf5NGVIvyAVOd+gzRKbuyy4QMhiqNGbx/K+gUdLLyhHplgEE1uZudZ1jBdhCu4y+pFezy7GQ9Ra2vp2oMTJ/LIT9Vq7/zBzhDaNp36tPSsL49pXYHXp1SUl+F+FpS4HvLUwv+im6P/mUYLjLTbAONkn9SNExJPgFLBHggvr38rsBSt6LwEkt2tjv5EY8CPuxzmdFXaAh7rLGglligRc6WwqwxSVDywGB8esYV7K81Ec58Ps0j9ZxAYUDzHiMVXlqXcON8zaGqv/ALDqzPqi0txToAi6AY+RoZZCNGDNvSt7KGhN5mtdbQx99b9P+obIwe65UVqKgvGAztHEeREh/HCqVAtPYxMCqDsuSnbP0IUPThAe3+BJ5GWGpecYoiddaBsrnq9tAEkEhu9M9+JE727qptw4452n4trVFmD+Dl4t1iXCOJAp4JtTL/j9a83enyiumO3u+9m4HNgGmSnuxf8IeCDYBo2UJRz/g3HXDUnHnDyFcA3k+5l36K8i5+LdxApNKysqaRjGbHZ3Q+881ii2jFhdjLNP9OkFrKsnYTe6uPnO9IkmB9YPvQfNWTyxqt93g4ZRP95A9Hta/rAUtfkSTqKSWqZfPUrh3+WpFa1lStwHCq7QbQIx7c0Umz70bELyf5Bfwidi3n7qIdJf3XTq6+srh9NQQPXCqVVA9i+E5Oc+4PCZEWFw0xYfdXqfmTp0vm6UxYxhrSD4mPqYK0Kx48hfyg9uglLZaJJH35aVyYBbLk3/DX88KprhND/nTZ2RNhkGdaFw7Q9YgBKP/Bq0bZaXhFSEADyIHNNca3FiYQWTP13wxIYgz/BJV8v1WT2YrXGL9aqf5KEhDYypBoZ6+wwzFUVLNl1aN/4VaY7ZLMcc6+37LfAyHY7zw+noRMua5qLdSnfXn5ksblrmEH7TzgR8Fm1Yxkm88Luaygk1ufrjGmtsRCdoVMecrE2ZZBa+zxYtdAO3/Dqm5QcmBFI9bhetet0azoWve8YxRR2M1+CMDV9HeOkguvVd3ZMtgvoV7NHCmnxEIiw0kasYCVBcHCtsFhB7flR7RpcgTY9psMTh0w9Vy2lzF7tQdtXgXvVmW/WZe6Y+UY4/gNCkPXUnDA/Nr9h4xqfP5LTY7ZtqAgoF7zIH08vHJ6BE/Yr0To8xW6PSoXL4mQ1WEZRffjS0VCh/tO0CgBjOgibenAQTJc1nnIDc3Lfgg++d1wZWK6VIe6QpTuOhB/bR29VrGo6W9jpru57gt64ppVSAs311AYL0LVo593jwmfWQaLrFPqCdQWdw+HQx7mFpqeAIhHlYCw52E8g3CjD81uUpqtzSblSbQ1a7DoP9z6Nn1ld5U8Puu5ab1eLO6qS5mmNtA9Ov9vNU91sUGHHDudwKd5er5s+bqi9uuRSt/Yxyh9pYi59ekODi8RfK9/OH+Q44vugAAAAA');
