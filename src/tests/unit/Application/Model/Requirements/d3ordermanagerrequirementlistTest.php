<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.0.3.0 SourceGuardian (05.07.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3B7126E37AAQAAAAXAAAABHAAAACABAAAAAAAAAD/PUT9+ix9S8UWZ3D6dQiEgLBaW1mi6d0x7hnJwqDz8JtPgVw8zdxgVzFBL5qfasR2NppoR08cTCq/jW/aDjdrS1XjdTGCim0EbvuRWbaAlKo9csAJWvcxcebQTeVXpGw74ALdNFPXYdxpVHQItfzJ/QgAAAA4JwAAk7vcHfhaQeaVWnBsiLF5kE5E3pC3EgKzineE4DQ3qLauZT8E5giDobCPOLO+Y0mTDB8pCqMeiK/rehTc/h81/k0HtfQfmWneHYHGQSAfVosAvoHihnl71JUx9xzcBPIfWvSyXxGonAnj6Xyc1pzeIbVWvpXTgueh/91683l7M7H+TnaVja3bFLnSNIOy9QceDhl4W1HSRHaGwx50w+CeXiKL1Kpgsh8j2RXHwdzuhOo9w7nsUhgf0qdEEZSUP18YLbZYON8fcYr3CGL2CRCBfWd29uCFbuWTHigt/cTShPF6IHuBNBuzmxbF86XaG+JIxiX7NhuCKcrLZ6ZQK83wXu0HdjWnzUX1nJv4TVrKlLUNndfxwDQCGV5PQH864OKArmBuRQhPS+a4TixWQxuIz5ezWjFVcJUGH+Rmdq5lIwU72ZJUV9V6dzovcYMbjkuv+fcuvXfDHuerO2AedFG/HNQCqb8mdPJV47mcuvlmdv5dkVzevttvJgAYZfgMX+l0VNc5zS7/8buCBbOaPeVIDTuaSzV0ufP0PY3OgJAGIi5R/ej13woxlwfpGJLDQvlnCDzhXvgYW6381H0AQiizqz7uNWJVB6nW2YuD5iCYJwF7hbi/ttYijVeGLoQZvuIJaxtcEyGeQmuxHSwH1PXUV+6GI77W5C0iSMCPFLUixht9oU8cLQe39NLOib1EGlXf2OZo1rzoBOcPeLoWALJFXseJAkCY54ziir9pRuhUP9oMTdxCMmFOwyT3iwWFtpfu9SD+pVROUb1RDWG8MaAxUyI5ey/AnTNaCEQd9BQjWhVO4e8r7C3msvZFRJD6c0gcZEFg60MnBx+PgzkBo7PN6Wk4HvV+isbuVLTJwOa7Q74R9zMjrJzclLCAtKb4a8VnPyT6tBG2nLw2YpG1HQri22DPZXW20ine13BnBLvnX6sh8+EEYiAHaDu87mZVyd9AqCiEz8HUznVZk9U+Q0q89qDiYoXiLXx0gsxOb3POLDFm7TuD3MgUPAmfDrsEGML67284RmxwxUJWBEafCg0cPIlAgEhRE8w8TvpylZVUlJNaKaXup06xr2/pwHAw5UQbDQE4SthIffDeqgnYG5l03zjqfjWMk3lsYVS9jva5YuPK3p3AAtmKkjLF+Soq1WSi5H2NHAdN+yT5QNxRPECvfNlYPWu9vWjlVEp5Z59Z21dewshWMKWyNjcU3C5OByBEjRhzpJCcQ6WltCM3N/uKYKSmAgD+ATt4+GgsFBLdkTu+W3BGuCipsw/QjvINOIZRzHIMO17xmNf8cMY7mqr8aqNxYXZDtOem5g5VboWg5XEDGnjNiwPoShWQOf3AvvGK9AByEGCXy4Vk5UoIu9vUrbCqLkitBnyxFFzaZRxpdF4EO3kXTuc0X5bXYsrfh9ADlikvL0k39jcwv3FF7O4gauB0S6RrV/ysN2ifSivMx7cyIi0AGVeH6FcL7vNP0edeymOx0dViecvI7tmQU63P3KRl0J/9Nu+oGhIsa472t0ygzyGSFHTm00Z61vsONZfdBoJ0ADASao5q5Z6Y66L8+H3jeU7dbcjdvz0bZY+/yRbmQa4VlXH1KKdgesuK/1maP2RzpZ7Ogrz9DdUewtNGKnrXpdNHgiSZHESytcmku25zOvkDcgDFzspnAs4Vc7jybiSfW57gzs6aMu9Ywgk6ycOdQ2wU0AajNZ4WPV+ofcPtFJUfRWQV6zMlmPREawlnL7anxw/ARhFcccKuuA8y8JUtPI//QB+/Mw8KPJnby0+0/FAW06NoqnOo0sitJit3Z0AgUDv+Un6uiyPkxE5zwMHbprEh6bh5pJSjDimNrhBJ4LcqpZpcFWlBzVWMyt7+oVykrfsQEWFWy6SEMCs/i2jR+Y72dWc8rT4zR30gBzEAx2JolLdBnVe1k1RGuFfl2YdmI+TKF8ZfclASFDI4dB6pdPbYLpk4hAFJ0akCDHxKNQU1cEWOmbo9NeN2/rmuo4/lf50kUsnIgXkI7aJMXr0AQzV7bC9wnl6nuzU1VHc0XEnduefkRjsIKkLGfKPDUIEFz1N7xQc81RczT7TEtJNMeiepfL1vir8y3c9ZbuIhpS//xrFFIi24xRmVGH+7t1rxYkKmaX/i0WLnOm59o/4pueTUwqGE+yVVP9+PDSmjHqlOYRFbl4OkNgRRl90Mxmrb6xWRuzwadhLdvvAxaciTLby3QbjOHrHw8K2O71Wc3qEocLPq/mOhAZ3rx484GCVhzC/UZOJfc52Iw7jwT7qmEwdkU9TTaFheLIdoxUk5KdhyNmkW1pyF19C3q1ZBgkoPRbiAQ7aMxENFwyxfyGZ6zn73R/DyuC0A2HPxBkkPZ/RQdhzAxi8YtfEOppF9xvVtXFvhrol4MAvtW0uxPeONMsIpyGnLEWmaMF4j13wGxVLL5Nn523akrpzQiu+0a8NsWf4kNH5n5Z2PV7f1m48/X40HOjgzLPnp63EVJBcgF+meyrpZr0QV5HJWnf3ew8h81Fzz2syCVuldnkS7wxhQmWhRfNVMJhRU7Ph8bGA8O16R3KuKziPeKSFA5/Lyt6wBPzieQyhRdDFBcEnbzcYvkzcAmz3vzu9WLvPzpeJroS5622vjXUYhTqWfNH/6nMVtndGWAKbAaFDzZr2+2bS7ijGDMwXInfZDq9Owcx2V5y7SpaOLpnQ0t94kbeHkxHva/bnrA5Dg1pEQSwt75MEot28Cvisq+vYzCr/wUO/ytrEnKJSIEnO3O1jnrOJO1Ifio4EzABQK/Nc6OGnIBOlGwl45y5ajIv4EQbbesWelF5ftm2VTsrGuYw4HImWmeS+wJLZx8e3vGXb8JVxzI5o7yrny7HjlvTzCCSPDamTtgM23GIuib4YndWVfN5a7BDzzF3PcJMCfbf5fXmNYGtVqVsEuF289ONJNroN47Cm0BgEvpnBDOqpT/yUW9aqWT1AUb01RWXMWz0P00x8YcW02qvpTs7HEgFbqQe0KDlR9n7SPlNspMCgTB5/yQDf2+EQhJXVgNMqednGhYNK6p0D5i0tTKs946aviMXVaWA5HI7PazPsJ9H7XnWzlGH7nZU7WPF9FWRTSbP4AI+T96kZhGbfeKxy0hpqaQJU+ncYohPIAmIhk4oXOic1qX/vkYh/kFfg0XZO9nV1fEzoW+FIxfmck4Q6sJAxc4KItPdJtsseLliY1Nat5ovO+bFz3YCzR5wlzMlMR2E3H5VlsXsIF6MZ+TqXJb+5Yljo3q0FHL7PbNSvqlocAySc/d+M4md6ahELwb+xwy1ffT2boiQ9YEVd2URkG50WRMTPteTUvxD5jtUi+L8ZkqP96v/CMCAuTcECGvWkBU1Ef8EPg3le6+mN8P9YoowRP/pucnwit1UsgoBEcTyr/UfFBlk/vu46AxZKY9/5P31eumxmtY6HoY66FvZvmV8CD3WjjSAjh6JSM75Iun598jNOx5h6qh7igBJRJfBRyKEjz+IRohLuQbeWa0hlifqMzf5MJmYKECteoA4hq4WReclCpL/Wsy8wjB8rMh/N+duPTm9ow6SwWsgV2VgMK2XBNvGxrFOWcWbPHRv+iaBJledOi9wDwLCAZE9raF856clGR+Z8nvd93fcQ8d+ZIxJwDs5OCT48MB4Yy3DFBaPqaol5ZSfBwGGymJlFT63x4KGdnULYCXTQPDucXo5hZm0jCmeOx7tH3vYGYqttjKtA7byV++6enueAFYq0XfPoxLd/i8G9K3ZwhUOqz2RdBhDIpgSUfe5aWIHfDAGyFV39xfA7Mfn1sOiwKpbCRTDaguWTDee8YC1Lu2HZ2LyDDUXD0OAiLs1hGyvgtaDv/LlKiTNqUdSOCYDMgQdmW+x37H9LIPK6QGG9hGZyyhEr6da2ZeO8+ugoo7UWAcNrVN92nQO6+Y0B7yJr7CDOa4kABFhcxNgrVFaft9ENAA0cN7/j5gybaXxKmYvK1Cik4zX3/zFyAXb98ESLd7cCZWO+0Jd7aIj5fp/2DPRv6cGPTeT+DNYg3sfwBNxiZnrXJMHxeyCzL/VX9S0cuKF7epvvezVrn/tED2kNISBTLJch6NHoR3pK6EYERgtDiEvmo42GQfOYTmkUuFkvhxWPCotVyVYTn+hZsjYtWuUJnTjmB0XRzRt9wdf6KmfxNmf9cIwlUyC3Yw1MTatX4SVbHsDCEUo+Oc0kNAipayizIDQlBRluJXRbKGZtUf64fS72KruVEttEN2SHVOZTmfZ0t7d1N3Mh/vNd57qKCP6Yt6n5LsJ03KWRjtmP4YrZdNcinsVLXL4ojyjd3fl4f3jTa2xU1ltG1WTckjQh3qLPbXUF2x/dc0iYq2I9QL7kgf0lI/OHokv9VsJ1buSiq8P1sFqhXZcxrkasU5TOQFuZsopZ1lNE+DGH4zG9eql3KhT+jKM2OmdryTbDFTYPSMozvtuFMJUEE41oG4zbe4xxbXrZpD4tacvAzfX2ZqFgVbNaUSNWVI606+DzEEjGgvYIdVh8xqgkaaOxDRSWYgBtlVjMXMSEHkIW62p+2OGQ/+idO+lmUYu3zHmxmYYYMwvVmZnexSAsW5aZR9URx8JB+CZ2uKGTt+42aXdHdi7eNWgVVqXxpqe5Jp9aG97tQKmX/4zlfhFswZQJi0D9AzuWzpT7RJgSEZ5PWXS8KZxwxL/Hmr2riUeS9ATGQHMhpkbIZZunLNRdm5Mgm1KY2pD1I7FFSEf4N9UOQj6BW5yrAp5M9HlJOIjs6Oe6DnZpsvH0B7e8H4j1MUIcMShVeDFRfNOs/L95ynVvnuCRS/ekkm1bxszQXtiAJiIt/gH8Wb2ob/MPGDlPS++yfBXOaM9zUrq8gP4skEy/EXynNPhFZgG2lEKwLoXR9Aq6gFOL5wa1CPzs22vJ//AGULrq0xvmJihI4AHID8E/UokKELhK/i3SeneiNyWgAOzEj+dQ4Fl3FEeAqfRGboOY2QRjwz0pQ7ZJ6ou5g7AnhE2hFHJe65pMvHxl0YpxlY8eIF1I12mYoAJJJUvNlyz/IPSmMTWamvSx9AMqq5LZvK5jzp7lCY4qAmbih4q74CJqmK/lMq801MR6a7H/WbPLDASl1Eoab8FT2tyTSt1dJoeBe+cHV7B3tTRtRDaTWSSRqioqbzZhdAp/jtZhqi4ADhavUUrbdS/DPks/arO9nVTxtQa0hzUf3muv13e2vEPlvzjnyz7ILvTTLuhqZluyHq9X1wwDcIuBky8MllflG42+WR5VNc/ETbIpCGBVWdMOHFMNMZrDqS1hBeb9KTGnW7Vkvc8q4VFr7gKQHpYHEXj3495KUYNy5dZ0ItCHMsoxPm7FiNWcgiKDTyfwwHaXb/WR7EdTTXAwonYRsgzkMiHprASrQya1gGIqCuuDwrBTsyJXpFo6UUbZL0IUDX1U1DbSO4I3naeEDGdXOi0vBPubrWDWU3m7S6ERIc0m6m/YYJpp+oWKN6M4jNChOCg0BzpQJHjodLaQjriLgQOGtTA09YRAdZLGG2k0UmlQKweUi7L1foam2LLM0auO6PAGFyPELXMvTl4OLqfXDUm1vY3ItQQRiRGNG8bYVCHv6gnyg8UFs1scvISq3yDHOQnxMgEWXhXukrfwFjG3D8oeOIiFAmVdgzMd96PhM/8yHB0Xanezoaqnlzkc0X9qpdY+eecYyeu0wOEr4HBQYwkD1KCbOL/CSegrU6mbzWxxQgktO23sEIP81619EXELXd611+tqovWtjRibGuPbYtbaGo9NTYs0Xwqu/cykXdy1so0GLddMg3aqmCX1tVzDnsPflinEuWnrEufneltBmyI0VRt9QStdCSX/nNZijzP+Gg0cT6IFMhVIqtTECTX3US1i+cDOqbTmSyb2djjgpfI0Ot7LDIwU0T1vxgtfcM2tTd/ZNd56JgWTbhjikaJTssIacMrSD9jLQ7/8Tn5WJLJxXDVouJrnYnydsDHqYWUR/LXRagEQVzMSB5ypkO5Vk6wBZPu4MF8Dqa877cLbvl3VCg2aeiO2Iqa0KfQcfHfSMID9YoFLhfJzbke6ocGs8BZCPfzCDyfaMVdwaEFC/CKYU+FjxSavwBzN5cEZdZmHkIUMZiyoe2C+QDfKZuTtwNJhMqj+jBaoVF9tzQNjbaNpSTOPg1WvgGE01iBBadQ48niqWXfDPn2C+BSEXfw2RxtmpuoEVvnuA2IjtE3AaAWmWAaAYqKTJzY4W3L1sbW51Ox8POCOZ6itT30D5ID/E0sgnH6gZZV60uN6wosHFXIfBVCbkrRDrqivzdkh71sQQ9HYY+Fg9O6llJwW92DANQmyRj7wcNwfft83Yl3Zz9By4kqNlzehZC6aW3pz0SIz8Ntc7KJuBXokdAxA97P/WerA/lF1ACuG++WbCeaaZXYpXhrrOIN94fP3vnYXLrl4/lghbxywhInhpluiWneCtKYMsLWHH+gqZeRKLwXnLavwFsA3j6uWGphGt44kSKANwdl9SVMOnNG7GO6R1eWpp4hjiFYbWnmTZYS+zGcCdi+Jy0LQyZiIx7zbpjYsSXqBs37N2xPEG0rypV5vC/Xsp/SEh+8Vb/ChoEYagFcgYMs8+E6nN0V1yJLLpp82IvZ4IS073ojZvm/+74A0ak8wmcoVVyusmI7lirhtoo5CpNWgb7MLxAcnqK1eLBpo6ZRutizTdPBXa2UxcIWvbHweABktXUGgzaDeBRtZFti7+feaNMR++c1mGiLTT7KKPcnPB/5SNdYduPBpMndOrIT86cNwvD0yt9bGKyQv0Ck+ImUF0tlDY1eAfiM8YQ1Q/9PvNLsmwRZ/oXqlAuCzkqXEmCRqkiMBsEMZH0MfF3QRJWCD1XWSWWOa+KICLcSLRI0tuTCKEvL3iHCyUGOenSo+f2TyeVWbPuxdu2u0QDZi3docDKndTiY1Aq7BPNWw/U70R31KpXEqodcxa1RYu5shu6o9vBwPRrle1/J3u5GiJaJQvP/WShrcN0hbJ9tu9pLxza8R9X3OHXIEyTXXDKw1CmcSBg+5HjSpKQyEigtzwKYE5uEakT+2lQ6lWyY0RiTsQNe+neEzJV3U9iieR3J49IeJFxo9aY+U/VAXv9GXkUiXnfnyyjnw+JhoUmN7P6BP9QG2LYjYkdMciV4V3x5Aiw9xloqXh2mU+dx67YMQPyVVgr62cc4jk9WHq686+1KkASFSGs/4hbP2GxqCau/LyijUoX/7J7pRwhxUABzMHvLU5kUVgORvAqlK0ZejCixjTh9KnL0yo9bPSq5EcOcLaSS/TLg6QGScPa8gBxAoFPqeA9rYS+t2YPB6Hpf7qspCcAzWOgwpOwPx7uQRzf9KmZ3+5wvskoPwq3UWXcawihh3UXGYaG+6HOWchomLsV0Y4WUKSbumrZWahgkLlSVsjuFRqoxuqjK7gwhzaAdMzB179HSjNXpzTz9S1XbNniRRgFU5uc7wZPy2zTLnbYbd4aZlRhDKiK8Qq/lfFrz11mJ++/81yD2q5BmCLnQRmfljcMi6W7yNxSuxE621Gdf4M79PC/YjEuYdbVL2biM4OUAuIgjlCFJmMwNXrEerocLQ7zq+8g+B1dUj+5Gyi+9N+eEAA3rUDNxQtIoUo+vyM7nsi5c8W1jLDo3uYy3LolYx56uPHJ1o0sAu6wxSVIcL/fXtMztoCbrnfxNGiPeNRBDHNKlSAKIqM4aDHghp5qbYbwwJyYt8IfG1xrqH2KSbvvAv9qn8PeFKH/f8i+pK8/1eCTs5KxKViFlAGPuo+HnSC6B/6iUPjZmRzV2AhBIgl27IT1Xj4P8wcdBBAPqKUgOBzk8pekGEEUXvAs7JFxLNS8edYPpHY34WPQSZkonsQsT3VUvi4Ja1ByDdQSyUCcJWo3YJY53aMYuGUobeEVYxs2H7ahocoBXGb0Jd5WBhtdwc2Jow4uQMHdqlYqYFeUvWE8dOuEBAGL7fsAum3uqg/7F0WMRZUbdLtqZobRKYMiTO5hf2BOleKvIuh5iq9pqHmlM9wx07BdJ0fmLQ3b5ln1X6pw3UAJsLLqncwa6MKmpsGHCRBh0GM1NwJEqteU19JyxVXSr/kbnUjZKh1o464djeniF2g6iKfnTrTqYeQ2QcjmNowwesAxnlt3Q4TLn3j9Aj9aMn3JG+SBkb3WC0q9F5b+STYJjtWQwxYYOlXeaLZLE+E+Htk5R5vj+7YsOE/yha5O/VOxve/Zn5N0XLEt1RE+wwB8ODgrQPxMxmc0pgFAJMzHkf7g+QTma4og/7ARJ+vHFeC8U9uOIhwXxPbFZ9RURHyIrqFhLZDzTOiIUJ6MrGMSjyMwakQzx8MXls7Tt4w8K35xUtqEipcW5Fz4kQNZC6pDlLrr2aD4/Dn68jWRwFfkLdJ4OxFhoi+MaDXZhoUW7IS6xzc+l8kCH9NW5lKhBpi+TQvCWHo//edRVS5JQ22QBP6l4VswUXMRRNMMT4IfZKEmRigkm6WkvqV+nGFQ4BZFFNhkuxj5VZqPnNwIGoowT+CZfG5o6iTWkYxDV1ZItL2NguCv4kHKoMsNyZECFExEDjirguSQn9fIqdVec2LNXX6m0+P2qsVzKtmHIhMCCeeodD6wrnOq0fVZznOwViSXAHkhdOpN1bhcKniTp7F/O36sLB2Nu9pjWBYbcqwbOZrnyExxM0d8r6OPWMNujzw9YaE8cYLaPB/yadpInWt28DrV//DUscR2phISyxHMpnjpzaM0mVA6Ste5cup8q0Tb6z0DHeScRGIBqxVwkxirefO8js1XvWI+t+aInOLLF05MQdQ08OzRM1Tp9pCsVb9LCK+SGFgfhoMkKQC2exwOacDxXbDbmmDiQgG+a1XS0j8B/CsEB8gwG5TzlTMABeH0j22dDCE1xTi0wkK8A1odsVjGBD61NC7hVUDRKJkkV/H+3hy0yfTPuMK3sZa2jUIdAKP4o8EIz6w38wX9stI7IPyHTMiojjRHJBRr1o5aSIKar+xzaaYXQ0X5iGXArAPFRRQ7FOuqCfZl52wKJA2ym8G35MGyboOrxlmAkL63ralG9RtiUrhi2NAbxgP8DXaiwolmH7duvB7uTqIuCXCVOUPN7UztDRcT2qD9b0rpu6jGDSgAlnxfYE2oTsB/LsD2XpF1FTnyyDkFOTOvjkOlilNwzZczArH5cP480jQmCTqhUsH2OT8d55X75qaLnGG2QFRZArDht9T0PqCJptY4hXo/tejeFHMPxGmyeGUchtFy1IyH9hUA33i5nWlj2DWohu60+HPIav9B27I49G8j5UGFY2v8yYCnVhaMg5E2n5PjtTQKV7pqho6V4wF8i1uWNnTKVqRSHBzBay6dilV6fakjOUDmBH2ifNiJiYdmqD4L7YCdlxy/pZq8zuZ6TEn4M4uSKdAXjcX0XBUq29IzePh8GC0EAom5Hv4TBmAgo5zxB5j+yastGhZsUJuJOHV1ZPl6jPKYZMQg8ErjI73blKrq/ii7s9HvPzkJaGMLsiNl4Xalrbkw4pcw1koeZS6BRjyNsK+P8ErCGlVEvCBWKsaZTGeE/0jinw1zKYRwiLcATp/gpl/wrUEuHj0onuo6EMkN5vruaVFYc1k0gK+naJ3CD9vr0ni3877mV8kcrJciXHCDkXHgb3s7H69lmRycj6CaC9Lqm8hXkXGzPHnFfeoJ9UValNbaMMOxQ6Wfrb7YIdw3i/6bPgdrqxjgphQ9tgV6Yji9PyTT51Bcm1eFIqsZ/EYX1RemTDtS/u9zfWMpaC2gpl4moZ+A1m4t96JXQ+neMEySHWX7dLJ+kf8qW9GvsmXI03md0LkT9VgvPJz6Kby7ntdGfuxH9RqPRaDpUp7kzH+qiIGz7FJ1Xe4s18BTwPEtgXru89lsKASVbRMtWUH9KWs2YM1SW8k3uAiTCGJh910GvMu08akpduYz56D/lcbFJ3+YQWDvAkRkt3ehVgFF+rJpEga9xa1KUxEUjvE6YuusaDd+3MKa7KPwQE4+vGrvfEnngKUlBMH7PQqf470nR9qRPdi4XuAZExVNHrs99dK7T0FfuhdEHugua1HufTkyspfrfHrl/NMp3+RhHANzkwcgS9AWI9jA/d8zbraeZMWRmnet5kP9AiymMwKlL+q6K/jStCdFD/z2i5vE4G8mjmZQaJiWZLNd9/cgglQsLNNaaXxZuGf5fSPL8e0J/ZqOhDBgz2MNWDaOTdr8fZwpYwScNengY1/6+/wZbRwciNmG4bD3Qh7hG0+qmXijky1afM4+/Xq8VT/HgFutQtIEeFj4Z8GMGtr8XC9vrYB7dKb7u/L2KsEuraUjAN6JAEmH7Pj9GW7Iyd7V3Abyv23XzvD2vG6rgwk7Tl22EB4RNXSaSb9mgJZgPQPKveyNngX7OesjU5HYczcEt4CRW6wo7xDcyRPGipUHURIEHcSPRvoQpEr0gVUKJ78heBmc1SYya4OOi42RxXrq3zvhoO+mGdLtsaTSgAUz2kyrJ6rHrx+X24aTpTUu5hWv9FX4ZIdr3ZR9nw5TJTgnnSiwIfCq3JDMkjjZyJyW0C5E5Amv8r/ZwMBsABtJ4vOGcbX135/ZfuBKqpfQk+tOGplZoc5m+K8f+4mnODO4LpAuXESzQLLm+8hXmeIUQT9DEiRZlfOFjRzN0GZB2UbWtlmdySc2MOkN5VVQ2eaA9ixXncpa/Gcm+qSNOI+Vo0CflPQ5ivett2hYCVkk/Ohvs8IpVe30zCAxNsjICny0M+HKWqFf1CG4AVXFhjr/4Ft8KId10UkqQ2mrWF6HpcYk4Sab5IxQVi1aIAPboTB26UpMjix+GTmhYm/mKg+4vcGzAGwLRASuuUi8GG7+RQxqtPWJSYCcXrhoqE4IDTNmS5q/fsnaEXSoob1nBOqkJplAdgTP5MhPQ05heoJaJNPwe2syTBKV7XriKuRnAHopzM+6AQldAl9iiSmux9pl/mwGIbPMtqk92zZFxfWYjSRo63TAXS+o3fHMINXflwh3OVUKwKcGCRqSBB+aKaeUYjs4mjGqFzuPG8Kh3WvnyY38IJBJLECOMaq80Gs9X5ncinCvV5cHBnN8Itv2WOz9sIHLPu//TIomH/WJuUx0Ihp6aeV/GiF5RDjQIGny6Ck8ftSodbIQYJlVgmZ8bAfEcgxyqlKFUeniX5tYGeM/dCx55bYvxBTeGQ10kcn9m8kiGRDl0NeTFaPZucv9gDLzwP3LfBZxRcRwpqx4X+yl2rvFfT6S7AHCjL0vghNA16r2SkUu0J56a4GU+P9SbEQ6V1bZ04GucP5U5HZqBEleVIXMle3WvAe3LgwWMXyBm+BF+X8nYNSVnU9f7KqtH9mMGwjaXo3nUQnZLhoEQZ9ihfbbLA0Xd0MIj47G3ZdAKwnEDhaBYRFfQBYLZYVyz7meY3WNz6sxOMtTWcyqPV+PmN6ax10OP2st3c2Y325DrsjskMxgB33aWCz/ekDaqshfHrGYyF3v44adEa8ms0pilZOqdV9O36SvZSCgDCLUExC/9jsdZipO3WdkJ5XOXfQYc8D5vjNwLINiNL0dOeiuyH4HACeQHBlMF7rDs8nTNkAtUdT+QJycZUKpD2gyqgp3Z2aJNncpn6Ytrncdkf9JKCcnbRvhjXDza5q6xdikH9BUGyPDPdBu0BH47Jg2ImCagmmB7M9PDbQTOV3XG30Bf05COpop4nhjX/OUPNXKFx5Q+iDHOf0ktYaaN+G37UEAZZAKpNqvenxR5+z0CcAtS7svqWGwIF5s5ARm5Xu/ySDacRimJqVbDRr4yy58NQfCvc2PZksOxS7H9ZHjhME+uh7xZzhEWkBrtbzV+JF/661bRZ0N8spFWP8uSjHQbVWAVsJl+YjPuuQznZ/XQ7eO3bVqSJ3U81PBFpk0gQ67oEEdDTLlbjKKCY64lOQlksj0YrsIrcXVoHpjl/Z8DI+xEqH4HWx3l5vWSzYAWkCd8grOEyUfY6GxzmnQOKmE6XVUVHuld8zqnMWFFL+iPI0lvdjj2/Te41UOepin3YjD0eoifPUov8nN+LQ/r7Au/Pqc7BgPR6A5Wg9iUu6btLDC0S93u5ecGYIbs8j8qWxLeXxnXB/puaLpUDLuFc2W9tHsExCVgSqDSnyJcn9PaPWPFO0PfNVFPfEUMtodYGZiF+H9aDqmJJN3lx+h5uv8iM5kIuK25bdWMCQxtTIKOnSb7pJB6xhjEzNm63YkD8cCpc5M0nJBDLOzUYcAVlEwDvZOIuhMItiSiaCiAn0HdPfcr+KRkZvaTzvbU0FotNC50BXay2BWkf+pJYiV1EANOTLS96FevUaKPuUR0ZyzEcwN9NUjIIJVkjBXPS7iQJbVox9guSAax1mjkTiK/QXyJlmrq0HjmXu33bZw3xABdipbDGu0iJPPA+dfkypLhUYtN3Vcj8bcHEsxJbVaCeQF6fk5lpTST1psgKmeNE0AJbtdyAgCkFjcK74vETGldYkg7P+lWMC3TFMYV29wKujGNOGWclQilUJZW1lT+046IK4yfRullLYMVyML7OU+I0WQrG01MzPsrLvDzgD4ssoN2Wcf6M/zuv0ixQwrZMrsecHd9TJ8CwXG3wODtqVutN0W1JjrtyIp0HjnennmqB6NNWa5AmZEyL8Wrhr4WEepdv84ojPdAfbfvTxn9EE7SpkGecQrFwyKt5BAMYTkbqF52EzLQJZoBMuX0A1PQ0HAQny0fYp/dYZXO4wi19l3t8k+W/PantEfYfjdi2hxoHNt8xM17I/k7exvn/wpI4vp6MsuMi+gbgx4oSiPAtUwe6AC0TUoJv0dRmYVDgFWkLpzWrA3iuWIh+hK8FxJG0UuNdZlLAU/pdUFpMtMmc+3Q2elta2GxIMFNkmuAlb8TSuQgY/nujZ+qPJ72C6fkoyTicgG5bpIirjFxIOeiQM5JZ2I3H3bYIkZ+PFh/CEp4zH+sv6AXawX88NNjhyZsmFXGsDKodGJGqhlihPRYPYVvRBo5aSWATLAATEg036ZqGGgAZRrxEkaLUdaLgmKWDU0qDfngmXFeToYf2luFRd1u332Epor7A9HPhVJSGb5hzSCbmd4ykye8p90LVOkLYvKJrFm6UKYr+lPl2uwm6TBwUk5Z83UNo7BDI2sIZq/jsjijWQdi9hkl5eHkWIWvZ8XjFIc/r5tI57MG753BBCyj/OKBgLM3oBoL1581gM+rYBIChuOhYZN7a7Fie2coNvGeMl+OwZ7oSO/HwF3KD5zWMEmC6f4pVh3BKqnjhKXzyDboriiLDIUV89d51zvox0Qlspt20DaMgg2u+hvYoGfmtozdn1aYbriCpCrkKgFqWYLq1MsPhiDi5suFHnorXmyDiQrCYN4kmN41Ekus/lZ4JBwydTUap0lBM5Ilnv14TTQsw+XjclBYo7pJnILhPyP2OeSNPvNiwwWpnp4ZRQ6mLw7UfgLpf/8D9F0kxRAAAA6CYAAMhIm4DD9u4iCQs2DJzQRZEuUY9Kr53yeGpCC959ttzcVD4pNOHkzwvoE9KS0TJVWjrnnBM8bqTFzS6ssnanJh8P3IK0llDTvkIGDxwcrgT+C8vUZCpzezYReQvu9LiIPfV2/DQ8ZocVC3ST0PdV0SPovnIwD1r/rdDwp9v9LW1esVSFiIRJ7FvW1NBCOdeZftvHrdxuWqVV/Ydjzhad4q2L2/ffR7uNKi5EDPB4UUzCdgIHfjShc56Y3B3UcBJfYfBXvWJ6co009TkKisKRe7JKe5GYQmcdDeyIx7EATDwSSmn/9jQH/QpvGYbqjgZbjAI+63TFqpb9I22laZQIY7ICrM2PrvvXOr4/K1HiR0Ovm4iwWhzaIF/YNZ/atFr+O+YXPp2h65cMXE8q1tr3GDiaIeSk2WqbimC+yzrmegKN7A5/tRKfzr+5z11qnSwLdX9pubxLR39ac2tivLtj5mNMtO0cRcStzgQZFMOGomRbJTY7ijvEeX7cXGRpQXLOzzz4+1PprdaKW/VRUfex4kS29SSZeuLKDQpPo6SxX6rLF/OR+8cf1x6XgU9LHc7kq6nOLQEBspcz2QigSw3sgU3QJP1tC8+/hXUu73bKAXRojP4omoNsQomvn+8IGQMxMi3043ZGR+dkV1/5Xc0XlGHimhkP8330E+jihZEudkDLWugkaFLKGE2kN8Cu//1VQq99ZBJu99KJscaYhbFyZF7ek2FhJgA2PSx69YNiBsL5eEuvbVOg5DqGjU13FswatHMuMWv4BTV/0G0xzN6CEgwcPhTFIaXweHVlyCThtYvjyJPNAEnCYgM05G30hv0iRMZolinoq2R6ai2idtI3SIE0EB8ASvFIvqYUb3o6r3xrJkSJIgcUR3jpgSxZF2yietwjw68Fy/XA1Q2GvSuClbai9hH3iVVMXlbVISjGuOWAr3sA1n0E2/zwQpS1rq0MQhuc3bfBUKDMjgWAMhEVWa7dbpMjnKA1IGB1D4UpaFGtc5IQqrorhVU/+gIn66DSDjeqpk96mS1Y7D5J2QvV7QtlT/jfRX+n6xPQ18XD5SzheRVjvM3nOfn7SBh/wSN4JmKiaRYh+hMhng9Yp02+r3djSULXGDDDPRuB+XKm8HkJFw6/LLJgGniqltdxq3tKn+9PD1Zyc3Ee1OQQNF/AtMRAL/bxiDZ4ItfrtdL3bUv6aP2uTg8HfGwzpDLIFhuDsXMjjuQpdzJHLlpZw83mGHYEURwNRVI48xSbPO1VV1CLZqbEXQTyjEONGojj1pSTu7Lx5ZZwz2ZWKlqpLZXbLZVJQChUuPU+LhHidu6IpptL89UD86zH5AXyLDCCKNymEIIxV/gumpAVHJAxJUhJVeThnpC6cbLf5rryxON1VAC9j0te51GI1mLo1JzCMiUEtt0c7dqnCUWEGrgDOTWNki5IG71loS/xxVqN+TOaOfD3Osn4JALYFzz3QaCLeG/t3noYq2AV3LE2p68tR+dpNYSenxHMw8XO0SIip9z7JvGEw/IcthNaW27FVg5R8/wfkAzrGCVlkIPqlc2bL9Jc1A8xOmp49d8p+miVe+diCKh49yqLweh8TZ0Uf5bKi2QV9NG8dCCp71A3+CZBmWxB1Vi3slaO4LSwhQYmyhdWHfcM/Cu+R3hmUO7GREe+mEiSNfgZUO8UcCwc64NXYog9sNDzTzidwL2lHzTloN5YhPUdX/Ck2qifKP3IVgN7NL/RAMMsd1MbCSTw15YbO0gzVQHNYBC5ESDfBxbLagWocxoG7zMsl0KTfEtB/iEwrFYKDW1uh3rKV7GIa9NqtVekMZUQYc6wrZykTgpAwJI5PbT4zsdaLGKoOaJeTReC4pbWezWartdCeX36XLAITd0iajOt2PT9BpAh1dwmL2djRZSRceFl5o/GIZjtP71Dp2DmCDCihK9te/rwlQpRX+eTBeex/4ApsUgUEjKi/SBXhg1S95KQKUeW6ZSdYWateHscA+B8JRNMzc4tJrS0+FnUSGrtqetia+MBEFmN+dkMUH9XEgOWZH+zTHalaeqfeeZE7z0Nnrxqnggf0Ull2yoBuIRAImqWSwcBVUbMYdH7+cJhnCkXhRkpNpWcTZsSfsbP0w9i0+W/DmrSY0cNYqznIdGYJvfBfsR2UyPvgGYfy2O1jq1I0S159HAM5J2etK5vShRID84MnietE/96GcYRw7u4d6YNJLmCesYC4TBAypUUQVTVS75Ish4ZRAJoza7H38qOwRtQuGwSjdemcOqK8jmnXAtmxTpAJ960M99gqDocIqH+YnqjkFbrl9awA8dhV189SAbifkn9xW2uw+ZO60zqTu/bXS63HjuszK8B9O4nSFx7loKECPQTsR66toLTqlH7VBjDtCoE/0M2MrTf4kZ6Ij+mEZzq+N0dx1ce5POcHsUKfQZjmZGArZRGe/Hjn4ECvnj2cXEuEGheErBehxgjdkvOl4xE5AvQkgmFUxuz6yhQ9XawjLrPSGnTr/ZC3MYVH7/iw9z+Ox/zkVm/dfj5yHkBfOHRHtpx2fQoe4lhJ+CHX6zCWi1qvpsstemd6YQalI6mq2G/yjnLFmZOlUJZ/O7I63YUDYflxPLNVMa975YnS7qcYoZrvVa2FO/tmrCY/6yHf/WDXcGmrr4zaDFhv7Pfo6aRu+XpQFDA/XUb9JkslT+BIZUgHCgPVnOlrVwmHYMAZ33gYVTBnT+nJFA0vYngb8ENd8FQXQF/WZ1VWJL5yo+yERF4Y6UzZfS/rpR2Dx34ng8XALh0RETBYrCvjw+px7qsTBuQbQucwOVOks2PzC5Vrjrt/ex67x7zVkbvCbkpFaNFgn6BuhaN4FJ72nBa6ig3ww7w9DwtOl/EaJxTYK0L3MpFvp657bowdwi31LPjR8mXFJ17Ehx1p30DiaO1/u5aBJuGqQsEh9upYc3hoG96S04dNsH9U3vuLq7CwKxVB5san/KWqNbSYxcRrU4cD1Dtja2yr4nb4nT+S1k81rbYvB/559ytIzuozMTguvIPbz4KUzcMm9B3pttdK0pEr4nbKxO36ECKsdKhhRJ08+tlvQCb/N4fjcEphyNiCbAAOsD6QoE8elsafWZhlT9VorIoL1DWaF4jfevO7yCb+4xyjzZH5gRDsX+37I2OmGjaIGE9Tjky2SSXDzmm0DCkwSGqK6oZI6KyjQWJqofSVITqNQR18PDDVLgoz4iIpP7fdPLIKngpmGv3drayhNPWckXtTqv1EEooIlGGVAA8/0DejThAEC1U+ftNJ/JplJBdaCsLtGyQEXgk87XvQ63l8Bj0GSW9YIZ2zG42mBmIa3hL/+qgPEl1m0pJ/Ej7iha+04N/CjBvXZ922Hf/+UZh3RBsgoSCB5zMneGvkbrdOgBOQWfG86wA2RX2Wn0wLYNntjlOS0rnwUmzv3FzK1EbcPvOmtdLrlf9P/ylqJDm4YLC2Ul65/UBofwim1j/YhphvvBfEkCH5Bjn5vvNK7iijgseRKMVIOkjG6EP50dcgE+Cf6ktpf/XavL18RFQ+3zEi1azgOyVXUCdvrpfrPKIzUFPiLjG3kjAELUeOOlfj8/MwW6OOwwJfyNxFeADJxJO8zYSueXASgeKnRIwXhIADRkxJ/gfXOitR4Yw3ymM4ZwgcdXAWss0uiC26xJZiEWPJh6/z1w0jdSAWWDUqDE624L3H/tht1jrxccfS7U09ibGUVJnMUiaqNG4Sp89bAqWRGhalXsk3ZE52lceLKjeGoD1EHiufe3BUBuN2rQQtLU9AmHSCyy8hJG9r8bOvqMrv4bjeLI0NKr1QaWFlzm9DphU2cQzKp5GSbJRUpfpxGZvZv+79PDZaxXiisRWwn3N44JcbFzU/Yhd/Qt+/h8mQh/xzC+sGs+N0QN9y2hOOYreKxef0fqa9EI/kIb1j6xjlqu/4ddp60USWhMDlUFrRRqZ1sx3RAwQw3Q5mlyDRbju6RyviQBJPdUua6MiUwF8AfIepILyuRzrNaJSe0Ri1SGjfCDr3It/CcxJS/P5W06oagJeHcvgCN5++vSd9Qx2X04LC0AKOVIhx9iFCcnK73lid/N1dMA6wjiGIAn7YED40OWWd+PY/op/gvFOW93dKA+NX4z045sQ9/lcO5nLUtmhSnHwZcg8cjWoxK2rqQ+HdPOXc1pLCAI5Utq3yVMX2kcWlzDw0E7y/9ojZdPBfoncLOsgGUjSYgenfwvnEkoWr8gputSIN54K0E354lpZzdxoNZuLmXgDPHRvNL8tLVcXuKK1hqOi9dzY6V2CJSq6rocmz1BoUtpvJ9/jw0F3dAs+dYkHk3JiesBU0OPkCVIFL76EyqJeb2d0I0ruiBakW06dJRvcxFMJ4+yNNMtU9LX7V/OyJVw313vi5MPJQ2cWAktZf65vH9qqkancYTSlZe24HupRlz61QVS2lZvB50rovyxSc+S0oBHhFVGWr5OhprLzVaH6ddl+1N9yvEX5hHRKrcTYHPWtOpCfcXFXEXWkxUx7lZqOVQGxdbisofblJdLLpSsbTpl9bvbYISkcQnwk48unJvj6cuPRA0t0WWWE23nkcDw0WOEzpP6Ciu8iq14t8PHrIt2AG66gwwkF3rYMtmgXDQSg2bx6i0uWW7Dh70r3tmTWhdhvwaCvzMrf/ipM7vG3QEyuUL70H0UqNss7aGvgt7R10VCtr1jXTlIP/+e05PDwr4yjyZhvdw0BPQjX9ZnVJT5qedt53oYk8qbfrRUe3rhXJGS/5O4wv2t4N6BvizZpx1JZjgetJHOVNq0OX2+4aa/521iZUlefSG/dCDKYGjde5ZWBWSsHvUcZ5xEF81qIIzIWdHon2aNkvw4Y+vPRR9uvkdjmiAMZXY/RftKMjwKTxqnyY847et+ceEkmruV3+uNYenLbb/5PlDRyTfGgF+VxG2lQPThXIyrRPBVSLP8yw2lyku/6jeY3bM1qrNhMZRa59D6uTHK0Lthl2i9KUr76apxe3VlpRFvZ4WzMHG4c8hB9UFWy/pjuQ2uC88uFx6yllI8C673YT4ObVdyvd3/K0eihlUcemMkBiA/7fH7JAtbdit31mUeWb+IPWw9yfBFY61nMu7S3njY4rtHHsQQEkPOsnl17e6iyluINUz+aCcZmgG9LZegH8Xpw5lxdgskLvm3DtgugpnxAxqkjaA1pBPEqSbwNzxnhwv7n3XJun6rKOevHgD9xb/GvH4MSTTwNzakRnp0N+hMV1wQGNYoBfsUt8cPtfaw2WmY30t4DbVKrl9NBrikgqXuxatvFtzZbjTeLqk09zRDq2TWDRcp5PPK1h9hgOiasI3vX8yyE9Rf0uwzw3juwVabGZPXyQyKHVaMR95uzrDFkIjj2fLSEgi1/uqtGBCASQqX77aY5cmyOA/sUNtH9FRxeXYjoaCsg2rBy/+/x8clgbGsvHR79YtSVCW2ogQeCWODBYxMvHuUuG1YPRQmTqylJvcnFuyolkJB6mFJWYecMCQPrt8boawlgyXgr1wvEVkM0nhgcjvxbaAx35fHj7OnyQ8Sq7G51X6rkxzGnpcOGv155OMH0OM4FXGrBFR2JqPtZ9D1fsrWI5B9mmvAb9yA+bGGa8FLqAWdtrp5r7gT7TPwUuCk/W8nWv6CLJj+gvINFv2obIJ5yVYxI9eCK5mbPj2PpheB9pQTdKcWizjAyNLWKd+foB1kwzvxsopY9c+EAf1AQwdgmPAfTNdSH1i6pEm08LoP4XrCWa9Nw1EOECMPyxAmj22w6qS+wePPobeQBMXQN5FdvAC3Y6THFO+Z5wy4IlVIvwIY3OQCwrqja4qUO0XboXJ5HkYEDKCLiJjAK/BvU3lbb3UWz1IC6BbGYVlo8/OOYAX+b2d5b7HQFpMFZdxsQ1kuhHI+SK4+UScnsf5nI6WdaBOW1r6wAtEB6OG5PkWpCry9uhRxfRdv0k75xhBfrobr4HCOS49Wb+v9XjYOMOApLtQ6FcjaE7GwgVNhdNYfc90VyyYDggv7dz75kNdc7IQzqwOVuzP36hg53Yf92Oi+ihm5enJUmPesyXK6bjsm2Mt7favBUMTO78N5R0U9cg2zbGBg69e1wTeZCjXb4QVsGRqymGHjG4eOGxdx1AmVtAGA2YSAaPYecIvLS0/Bu4ryh6n596+ax/imaE4J9jQ02FcTuvqeCb6cUDMtad7ifv8WoEVUtBj4A7Z+vGwJvGe2nF2PtdPTqanxL0GsO11zxRx861PNulGYQCe0yfeo/iMjkPpE/7BMaJYD6w7Bn56e2h+4OqZ89m/aPPf/BNbbD0TpVzNC3RdNbMwSxhrNfd0VkxFOFBLP2iuAeb7vmb7r0H6J/IqzY+lzd6AeArR/BGQt/tP2VmPT6NV7HTd6AcUW7Hn5hUFxFGV/8IBrYB3+1naNg0DxQ4qMhHOL1scAXamOzqm6XQcjb94XMxlQPaMPF8a7sOEDriZYuF9/w6F+zi5b7RFSiRhXzxEBvXtU/9ZN19N6pMdInpyXqTaNh5Maomv8KDxiATwBWWthZ1GfSH81l+sqol/9jD8tUR1g9hyrz7nFbIpc4ymGEwyNw4KC0eA9C8hU8fEWk9WhCQ+r9ZWbylyEh8WcC8l86avNXIgXxuIld1THVkRVrgyoksxcnuQQ7WS9T7MTJAWJUmwTm6OOsi1TH2JE1jtbtdePeo/crbNK7FodWJeh4G7t+XLh62oUIdGtySWT6Y3k2kmsBkHa5xdKu2RkqNu8is5cA34NModVt7zlmhMGtxHeIb9KrQozYE/Glxrt2725hmrEEXy5ASdwZc5MY+JUTwlWXddZudBxosdnzz0ved/dfEZ8U1TLB8Y1788Yf1VEo7/UGNHP6RI5OBGIq2yX9MbP/QiaPNvGwCHTc6m30i4tEhf9XJ43HcLAbhBQog7AilXqXmLVWsw7NsYGy3vKiWPltaQ+Pzyz/8umTzcOaEv0MgIZgDFEOk6mVlcSyHvu1duH4bS1dfgfeP2OgGc223T2bhraxcm8hxyH10aV5TwOcVJi3I7BrTofPYFnm+vEzMQBCxrMeEiT21VxFORCgH2FVfOq+QwBMFpBL2wyfWhHUQkQerr0KxeGij7Zmu3d4+OQhCoZ2Bgm/JQ90PHM7X4/VksP6lLsN8htYvVXLYd5PEE/yZTGPFHdHcj/K617yr1GCRSeLUiw27rMz65+0E+ns498jUZu/Dx/M7/VDUTVP6bdi/AntFYKS0k4BFDNFbwq1N6tGrYI8VGpMjgEZwVuJxe/xqjj2DxrDAykc5j5JOLSkD49X0k6q2Q/8ouEBEqXsV+1JvbWzvRTgW5DZOKFXVThgsYqYjzIuHrYjJhDxyCPwm2KsnIi/P4ilD/X8Erbf5QCi/iXuu8Qt/WyTrz1ycrUyWDAFKY1zmL7PRMEJajVs2FCbzdmvoV3RQ7JR+46/AZUmUCwZtolQTAkM/2n3qPTAt9DES8nDeILVEJExqrGMi8mZLYLyI0lYXOfqcnJTkMSOfEKGQqujshwOOOkgTtWcqCuxvNMed0FSPxwKvbvXaPHJhGIZDcTy1KCXICExXZmso67vJHodhypOJDnAgDkKAM8y3gu2obP9vsqeDO3Rs+gixDbYxRpbEIA/jJ70fYDaSpBZUC9L1BzvqALWkmL5V5AD+21JEL8e8KAVX20qEZ+uok2XFWWfYrDgVXBjHixo+yXt82P3tBRzvWVOaCRLjHImxKSlQIGQAWlkm9CNpoJIzQSV8pih6YOTWo15xn7XU1ATb1BFfHIO8sHHWkNFXKBJGfCeQ3Oz45/7vY2BLj4/QKQznQViMQsJUM2azP/mfsOfzO7aBhcCpEg29Ai5DLi5xSH6wvCtG4gQqRGxOZXWRtRZiEjBIcuZR62LZlmg3Kz8Zle3rkmRKzZGETmAGr31PWnxFTeD7HRREf3C6ibvB3UpTSWbxwu/awDciAT1WCQ41piIuvlf0yqLrmMFn4P5t+4kUeVykozYvhVSjcdQKzDT67TW3Q9Vy4e7cF+TrbQEecpsveZuWIudCt8zCbbubroyiffswANM/Jwbu2+x7njLyF6j4tBpyKklco5Ds9ac+D30Bf6pv4v6fFofpR7R1gyUTMZsNsm8p5nsPtrTYIha4PTY5pQgzyB43JfLgm3QmTM5iDPjJSSVgW2UfwlqiU8RAIZhiX+QFtkHYOCUFaaA944tbdZAmN68rOU50jDMW9+V1TiEhQUZYQxTQOa0tPPH+slLxhtAIbIqU3Aha+GWHbxObTDXT0H3nMw54f7NU/u7svGOmATRHI9SsVe22dB4cGsHiRjvNF2HllPZAbwyopY1UdV4FDOeb7hRUmHuGG0Ccc0unyT6zx6AwmrHo001GHWEsnenRU/6s6e5eF5cetyn+xkmpcngoeL5t/6anPEFkFgsfoI0MB1iNEPNqlnn9y8QP6Bl8BphfSwh/QihZ4NH7dEXQOSgiwmurQ+5LyWUmxPHOXtr6rBYXmr/pS9YbLhA5eE7YS/orPeDp2hCLpqZ8nRLx2UxlV8w9WTKVHpL44bfhFvcTHg5NGEvBL8L0kiM/Mg08W8yBcYtIumvz9+uFdUN8g1ssDApX5sBJ1abbT42S8e3Gw1BhTJZvhqqzfhClXPNoOGMQ/RXFn35Op/QXwzf7Rz+Daa8L3ETRdPUfA1xcg6TF0aVe8oIpKUNEx4dIBOofDZVYEON/pIvhdbcFlWyu5Lyo9wtDtY2kyewony5dTC+p0dADgp/2zqhV9aFNHUnMXy2Oy9RqT1jSPd9TeZ+y2dH1lGw/Dwxtaei7qhwaL05WKSfiiJiHmviqk5JR5F11pZBzTvLIVmvG8IU2ftaojBFJuRPIHcaJ7uQ1k9aNO8RBf8x8mhx0DxSN+vpUHNqFCQAhbem3jPj156rd20Yr61uQNVmiQB/tkFqAtAP5OaK54WA0V4DIapmtHITe/3Lw+YIYcwWV9RgtujUPcAmzroToKHp9goqHp++yIK1D599JBdDSXHwJ+TM3yDABhxRqV4hi4bviKnrzDkESUY1OOl67dYuJ5ChUZDmZPJblg12RkEWeK5nlM0p4VVi0j7dMlRu6JuNRDmUYwb+Ep2M9Pk1FnrZLMMljTX0oD4B15tm0yv7i3FFIkBNQhsfftTKaBTn/sf1fs18M5L9Y7l65FR+4s5QvRJGscCqoA1jjQe45FK4hT18uSoog7Pq1VU9UeXAstVmTcyndvo8V48Z3ZEjoqjxobdBQ/TNcBaTdXusUQLl+8sMV7XSajG29YLBxqNqgC4Fmy8OeD31LBQ6LqJPTjVCoWs4Rc+ThRzFPeDnaWu9jKVLqQbtMcRD4sfx4ztFS/e2/Jd481ToePHSESH+xnTzJJ0WO279xwxL6N0xZ5pUMXg4WXNk66bWn3WwiSQNgkWUmYQALZUhRUSf7Zzwxf2JIv2Ckwg23wu8xh9W2xfip2oZRFVJYCt0GA86aE6YmuGbMbeF6QW5/18oXD3nu+GqiEEVWxUhCGX23x4lieKYsdllqZwwRq+xCGyYs/HjV3W2Vp3t7p/JCmyga66LzHq30JzYHkxcIEzxZDrhXo996UxSvJMR8qYJ6D4v694Igw1PrRdVYXm/RvmOFLSYWyQ5HA/TlJ1uTHPyxvmHydldPCqkMC5F8dzYprXcOnKw5uDUkQNE+X0o1NNm0sHlV1CE/USeTLn3+19Esa4y0lWgiVDmxEjPuy+g+PLOn0n65eNA7tmXJ4Q9glIP8rnIibAMSM1ASe+zVgg/AiKpSH3ABjT5iMMCPhoF+CJrupwbt16i1CUh8bILA8nCqs5KyJUK7esnoWF2q15yrhb0mdzbDOsgNcx0uuwO2+1XkKzpDM+R4agfOrwLvDmIzwE3jRFvywaAFnsd+lrAMSOYHv5W33RfNfD5qsxFloxj4neWIZWMyKdXeR4/7FxSOxXm/0wqo9DBSob6AdahW2At8AqK0PzscTm2gyXX44M4I8wR3NVqSax3gGWJPi/6PYanM8Wvs9LAlORZNvw0YhtLw1cRCwgskpLS72OpeZtGgq8RtJnecDjh5QmyADiCyQX7DeyaLiPMHw+2iTT0bumrtZjBFSSKUaEbyf53dZGIb48ZlFSOyKnyKCUAfNVElKt54RRbOHjqIirIk/Xzo3QiADjbC6mf5wYYIntZrArWAopDzdrzO+WaMb2DmdY59uZkvUDRrKi9ZJdiCQvM5XWGN1DOlZ+53VzMGyPF2jEjPXXUgewlrmwUQzPG/7/6J3LQ7SxjO6xzbbM23p7PFDNYjLFuULx+tqNwJPj3uMzWNgJOFVVlNKN4kAwKKc3WcppGiQpd8y3JRYoW81n8iAlqCdZ+f7slHT6XEuE0lXbuXEN7HNhoG6imEVG5zApdsjH3rxFdJRjxJNuv8rMAKtREcqwpXlZt+bgC0DPEYZXyVV0ZX2nNAYXdrzxgXM6XX5tKHmm7fhQOWvljM84qh4JWtqkmQvWtwetxTt4deqFTByqR2CDjM5UcBLsL8U/DaRds+/kuDURtudRY2+OR/CNLzBNobhhByKfQ24KgZslX6ftFqixXs8dX3aVZgaza9qlD8GqHkJEQbY85Fglit5OLk+/xz8UIB2nTjcqWQV+FMFrteZWfdP+1H2+3AQMO1TucgYKdKQB5zHth4Ta6IN4HQQK51E0QjtP7kYGOxemnBR4eiq4LrkfskOeJqgzYEVndSs646W9IHCXMi8/1VJ3MjHwI4syNRmZxOr/W1BTRWdml8aGEoky3DssIpeCeNmGzVKKbAGobPL1WAQivac7dKGTgDYfGwv438IWT1YyIiwiaLKjuuHpmoC2M58uxUf1aLigsFE7LsR5o0YQM9CXp7POkJoqKl21qIYM+JIHfYN4U0QJ+1051NhXRwkOhbCz6OCiYfaS9lUjR7nk4ZWD4vG5mZA74ir/fx1T5Y2PEu38RH7hT1IjBh7A8fHsu6Mhrpwk53nkzK/ULVZxc3fRy61/qdVe/4OVVuU9DFdSivFhfvyivWFG+7EO1OvllHyXJgY3KZEgZ61dn6JKaqwOZh4qxPnsh0tlMqW0FzDWkk9dOTslOq4ECzbdiABII5Z7Rwt0o6YAHX3LwzWD6P7nEHIKosOWvMwZoCUf2pMD7PA0rwFLdzbmeXhoThsaf3f1nn4NukHY30jV2CRPsszrvLePTL9rpZfPgq2zMiGw3VwtzNJXk8hsnjgbooJ8grBhUoSDpvVzZzxlcmzXIivuJytcrUBvUIAIK4Iz21mDCNWDeEXC3hwhTpdJyEctFnj2t+Ryc4qDt65u4GPH8E+sxJurreU0AS3/b0uvrLhvG6Gf10HsYq/oqK0hs2nhkv6+PvAScBJ9anaOaO8xLlQ42jDgn1KV6yKX5QifHxm3IoElxaSl1JcyX9MO9rWgVsSZF4lg438o+U43+ocsOViySUF0ICEYAgmSZu5gQy3FL0fPr71jdyrEL0DozCAwkzxKAZErM2fVdq+mTDcs/+2wJ+4/iHsuoyZsz26/iCpEub13kdWahdl2ClyCkKdGqtif4Mlsy65mExOAwtyp3wPWq1WXZCxRe0w4PvqBvNCfONfQYdlBsQ+K8sDJ5eGESatEK59s1u+k1isOCQuVwtBrEeMOxLLGF96l8Nns4SoBHJEyOXJITlyQoHIuDu2IXwHWeW97uARkSOMroPWncQyYwuo5eCoskyj9QW0hKSZTWd2to4rvpp6/Eyhv9QJU3Kg3d6tmWvZmgYIIn/QxP3iaGX4uFqNxkJAnrVJ+RIrcTJiDfoYQaTe6MKXye1kFVEVlipEMcILzWYlv2/Ki3cXoYAN3ooxmZjxqATkQLt09tYZcKDfOqCBf6fYHVa3JQWatn71mswUVX9tDpse+WArL+/AZIERbIqaZK5WrP+jyZ/8AStYS6pDZGd4W0zoNGGQy/TN2G4Bqwh1wXzu015+kE0AgkY+bDLSP5VgnLOkYnybSXwZlo2ggjUo+YZ9M/kMtGMkeE9z/rpAbbkOQvMI3GQR8BWGHWJZIWAVZ8mKtZlvSa4dIUK1OgBblneAOBZaWYiHj5Tj8xBSjkWAseiyvk+ZVN23SJZqLjTWtzyEJfRVgnK5bGF9VaQ9ZQ8uwxUlWk1nIQObWfURubzesQosCkE2JWvqsql3ukZIpfvymscXwH/XS5mahN/gecXuN6FmEcqwWmfIpRwonfbLoW7QfYmGqrKEvPm0YI8WRedod3UWJPNF1SPpc0e1F7/202gJKQTQvufudUDZ3+nEgwfH78BOXsxH1hpWAGDWtpwcydVtvxl15DyJ6yuBgrbFnJkgJysmpRG5EwHlF+aSVGqjh1FbfnhuvoF9uwKuARplkiyJbVsRhALsurelKBKN0RLve8sDXVnS2efi/Ke/VvyzJEFKSg9CZvCHIPJR+ILVFLEJvwx1hasyiXFlYp56W2xHTeFVTU72SHjlksgETiv7PA8MluapY6Jb6oTfH1cUcU8yafI2s7AObk7fO0uyANWvJVHdDM/Ggt8R57XPFNSLwFlvuGSKLOm1ffJS8FNJcNSPn/+H2eNADJ3harM5KfMdypYOfjIHImCeOa7lKJvYi2lsrzdLpCbnyznm/SQaN4gxQueTM1W7p/QU8/8/ssgCbGOSBtf2NIJrHPM1RYoD1LLubocJby2dqjriIBp6jQRrfiCiR0fw7uUa3ePn/yh+qIYZZgUy9p5pJE8fh2J9ONpLERRmXvW1EHb8qxkf5yFB3evt7esSxTebfciiWZLjhedx2qO9whAUleF/440XAF+/nLwgUaJHMjtxqfnT+T30xAKLYfVK+k6cn8xn1gk2nKEdhnCHYguhGrpgEr3TcIJlv+KgP2nfHkUpW3OqZiqPvSeJkQ6XSk5BK6m41jBi+3tMXp50LUDfjuCfxYsvpASIhg6Hvw5MRRP1v1IM1yXexEk5e9P2zAh/qUCzdXUJpVO2/XgYNV9ji7vmHU9xcPjzYXZ6MVaud9VrZgy2M9EjCElOZ1MFiCXYqG2gIhKAbiD1wt7tZXxjFbQWZMwNiDCrpjGZjgko/fjvqgX5xcBvpHPJaQpvrvZlq44coz8KCHnRUU1/CGZBqixQSa3KXqgpscRJOQo3B5XsYNnu5rQcYoR5JZZWuzvlvYPaZXz7TDU8fXlAmBQovh7lxB/1BX+lJpaBXRYa758v4rDgWV4LacyG94UGzcQs2yX0GZR6PZ8JbxrhgrZABqM+pd6WeQZrG+o8eebCbLGyGQN44nbHiVOyzxUGJy7IPIcA2QLr3M/jiLisB9ZMnrPpzvPqjd3qKWEP0VDBLiv/TRyBdc1DblEl5D3wAAAAA=');
