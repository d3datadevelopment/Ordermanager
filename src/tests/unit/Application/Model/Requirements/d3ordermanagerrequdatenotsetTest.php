<?php ?><?php /** This Software is the property of D³ Data Development and is protected by copyright law - it is NOT Freeware.  Any unauthorized use of this software without a valid license key is a violation of the license agreement and will be prosecuted by civil and criminal law.  Inhaber: Thomas Dartsch Alle Rechte vorbehalten  @package Auftragsmanager @version 5.1.0.0 SourceGuardian (01.09.2022) @author  Daniel Seifert support@shopmodule.com @copyright (C) 2022, D3 Data Development @see https://www.d3data.de */ ?><?php
if(!function_exists('sg_load')){$__v=phpversion();$__x=explode('.',$__v);$__v2=$__x[0].'.'.(int)$__x[1];$__u=strtolower(substr(php_uname(),0,3));$__ts=(@constant('PHP_ZTS') || @constant('ZEND_THREAD_SAFE')?'ts':'');$__f=$__f0='ixed.'.$__v2.$__ts.'.'.$__u;$__ff=$__ff0='ixed.'.$__v2.'.'.(int)$__x[2].$__ts.'.'.$__u;$__ed=@ini_get('extension_dir');$__e=$__e0=@realpath($__ed);$__dl=function_exists('dl') && function_exists('file_exists') && @ini_get('enable_dl') && !@ini_get('safe_mode');if($__dl && $__e && version_compare($__v,'5.2.5','<') && function_exists('getcwd') && function_exists('dirname')){$__d=$__d0=getcwd();if(@$__d[1]==':') {$__d=str_replace('\\','/',substr($__d,2));$__e=str_replace('\\','/',substr($__e,2));}$__e.=($__h=str_repeat('/..',substr_count($__e,'/')));$__f='/ixed/'.$__f0;$__ff='/ixed/'.$__ff0;while(!file_exists($__e.$__d.$__ff) && !file_exists($__e.$__d.$__f) && strlen($__d)>1){$__d=dirname($__d);}if(file_exists($__e.$__d.$__ff)) dl($__h.$__d.$__ff); else if(file_exists($__e.$__d.$__f)) dl($__h.$__d.$__f);}if(!function_exists('sg_load') && $__dl && $__e0){if(file_exists($__e0.'/'.$__ff0)) dl($__ff0); else if(file_exists($__e0.'/'.$__f0)) dl($__f0);}if(!function_exists('sg_load')){$__ixedurl='https://www.sourceguardian.com/loaders/download.php?php_v='.urlencode($__v).'&php_ts='.($__ts?'1':'0').'&php_is='.@constant('PHP_INT_SIZE').'&os_s='.urlencode(php_uname('s')).'&os_r='.urlencode(php_uname('r')).'&os_m='.urlencode(php_uname('m'));$__sapi=php_sapi_name();if(!$__e0) $__e0=$__ed;if(function_exists('php_ini_loaded_file')) $__ini=php_ini_loaded_file(); else $__ini='php.ini';if((substr($__sapi,0,3)=='cgi')||($__sapi=='cli')||($__sapi=='embed')){$__msg="\nPHP script '".__FILE__."' is protected by SourceGuardian and requires a SourceGuardian loader '".$__f0."' to be installed.\n\n1) Download the required loader '".$__f0."' from the SourceGuardian site: ".$__ixedurl."\n2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="\n3) Edit ".$__ini." and add 'extension=".$__f0."' directive";}}$__msg.="\n\n";}else{$__msg="<html><body>PHP script '".__FILE__."' is protected by <a href=\"https://www.sourceguardian.com/\">SourceGuardian</a> and requires a SourceGuardian loader '".$__f0."' to be installed.<br><br>1) <a href=\"".$__ixedurl."\" target=\"_blank\">Click here</a> to download the required '".$__f0."' loader from the SourceGuardian site<br>2) Install the loader to ";if(isset($__d0)){$__msg.=$__d0.DIRECTORY_SEPARATOR.'ixed';}else{$__msg.=$__e0;if(!$__dl){$__msg.="<br>3) Edit ".$__ini." and add 'extension=".$__f0."' directive<br>4) Restart the web server";}}$__msg.="</body></html>";}die($__msg);exit();}}return sg_load('7A3737B3BF126D47AAQAAAAXAAAABHAAAACABAAAAAAAAAD/Zmm9wELvp4LwCXAiMO1ZGnAt1bwuWSg8JPYHCfVAAZYx0gYX2xIbe5j6Zf92CqMy1U/DQq439NumbxpXxF18jQqXWecGw8Va9ly+WbdLfUnSP0n+q1vZ7N20DVcIG5PcrDmbNzOdBx02Mg+C8GRP1QgAAABYHgAAsOVfRNJWGsHRcSZSGkTcRcOkZyb8sY+RoEz2g8gLOfgqrWBP6+5LUo32aGcEYFDu4Rv2ft4MgWphitfgi/ZCYclwh2yO7QYMx4U9EPNZ2tA3mmRqTs15RBDAElS661rrsx+emTP3m8xHO0NL1ytiG/AgWn5A5/NPCtUCmJmovyubXSxOUtclBrdGNR+jt7kovUzTklrvMhU8TlVZmkHVgyV8ibG3ds2AAhv5NQUUByHWTIFOmY3cN1hGVrZdt/HDFFR2KgIpFCBsqL9CdHesshRbXkrlXpvmqmcm5xdGSCdbX3x9WaoDqH+XXgUVIqBO7QsKOwKBKTIRl16ItVudiUuzZpVzlCv156bmvjgTUwW5zM2MR5rw7GCLx99ji6QLt72YYinCMcvInauZntKXLaU4YZbCbnPsU4Er1goivASMhL1NcXu40aeN0BaSrOeoAfcoG5aLFJu3UR/+D7+k9WRdQe2iuAB6Qp0Kl40c85YcyPCqavbj8B2d1UfE6FLfbbjsBao9t4GJaYXlH2caqy1EstTjTCSr/MttS7KvIknWuusj6m98MGmUl0WE9MtUpascVMbKm7aeaw+vwxHDqY/cVsBIk4TMvCSaF1NPFzy9H92TlCBiC2DP+pl0toMQcq+55PGCGdlQ1zpQ3wHBq/V+hngywaMVcRFlQFvcfHqr1CFpDqRKuVK8IfiZft5AEPpvkQai3YOBZvIuX1SxFHcB9zM2TF/EgwCu1x3DlQpYHC3ChvuW7D1GzLMbwzvGVvjDgZvtRchJI0mVO/vOm3a+JgZ4tBN7HJpMDTx2klR8BBCFXJj1Rd3L3NbLukxdS6ZYUJGATg8wwDBBcmrC+p5HeX71OIAjDfgGEZepMZ3cKCUeeDJ8iUhWASkyoYyj2SU27v40+mUqbWpGiVC941thfeIyJ1qpK7Xr/OwE8vprmVROQBSEnWCquzUSlFLMCp/0/FSv2SO/s83B0Q+047KUcJEwjT9L5ocJhFNoTTScTUEWoG0yjGmsJ69yKx7JT2AZ82NHO6orxA9LcqmyhE3ZveJsoLiaw2uBzdViZIo18ocJFdQOxu2E6hpK5fFA2gBKpklSim/NJjGYsT957x4dNRtkkhI8pkDsrQxd3+am9PB3iOBFdU0+vfZzIztsxecsgsmz/N+8josnyT4rtx+saH3Z3yb0Ua8Mbz9ZPx4TlC5O48Q8fWGtpRBhqp+OvZ9o5fBscJvYRWdJ+8DdAGX6iBfMBJSzlcXQd8zSfGD0AyCfNuc+swG9rslm/QyTMM/X+Gl37ikuBbveCOAKYQU9y8ahHg07calxvxFpwRYPBfFEywMR3PcmwLvEpypdP5h70kiePgBL22iZb6cueFX5Kthat64BS7PEo/7nw5CAskODlXOdqmdd60XyxSwBAMMwc3axBs4QQeQlQcw2BGJUk7/uVZDLLAOR0bc7M27j6Ad1nQypgj0ngjy0+HV89BCxrnu7brMkPUoeXbDfXlGdklgpmzWqrGbTjjKpEylauO98ihjVaHiuftagbV8znq7CpC1sVj3WqCbF1Rd+ydUAWtO6p5Ae+eCWYunZ73LM+R/JFcylabAsEOS2GkuwuhkOXKhzx1K8X84n6Gkh9ga7Qv9zESbb+tsydIWXpEMU5+V78HkYoz6Zfn9DnZGoIVpQAn7pAZK37g/QECURdpNiDHVNY0/LJGm+x0TnwzUhQ7e1zRSWH8Q3yoWVAvrUp5f93zDth9ON1gDFNwWbWiddlm4oCUUzS5qSYA6gg7NvisrYquu05WO4Ii92D/zBDE1l6Fe0PfqywMZWTo7o8ctj3PQl+WwfwMVK37xr6REjxSic/cEYkM2ltbV7NrfDmT0D9D58Rsh++TbQ8SZy2oTD3trTDAN7v4EbFRGaxjGqIOBW2sIeYDiG61GXr9HrJ7V8pjvbDFns9yVvqfZgLDbvH+6NJMVH+3wnwgMV9dUutYXcJ+1sWjgLTdflfm1soUZYejbUtfXZnW52+5x0n3BJiOsU5eFBjLVtL/hwSnDa8bWnUEVG6M6O9mbP+58leyUJx+tjV0UsuO6DqZiZj35qank3fbxoJt+rJCxmfpo3xqgz/ULiUXhQhoNqh+PMOFT+3c3f9eSC1e6DM1yl3IxIxwM5xk8Yic+yM76grb4u9Ib/9mrQRU9Y0OEKlIF3UMe515fpVKFhmPBdxK18v6yCatjYnqOvc3Gqo7BmmrFB2/FXtzrfxeDhlMJWagSokwgkDeqc0NaNqXuOOPSQ+tsQGtaaRDjX1IRGoCm4v7RYTQOaIhv8UTqj+kovmhO65zSOKkhWHI4Ar6HHfB9ZZAmywgW1Nv8ruOgJRGAa6RsCc+lpOnB/4/Gmg6AMmt7ZN5BYGKWhOuSAUUBShib8y6UZMwlQB+Vmz+jThFbztM52hrVsWZSYdOerp5S/TLYjrdtOrbnwuQTneKRFSPpU4nH8F1y+sb4CAqVPenhSg/Yh2fPSoNPGHr4/oJK8oD+9IQ7RaFnl+HGqzE7gbVzTjUF90Lh8072mdfe/E1YnRKnF9r/RBCsHRWAibToSskFlCBDZsR1NIuPPItJ7rrDesAZg9+xzNWuYVDaPjThZ2yvsU3WaYC3eoa4bsx+6L9NQEEuqcLKplxcupgmR9Fms/dcU2A9QsWYs3+193/jY9zOUCW7stGQ6f//DZ0XbXSMuQXlVZsgP/q7h1XiTR13AAIrdYAl1/qJoRjnHUX0F5OiaboutJN2CHm9j6Fd4koP9NF0e5ancSOOyU5589cjd1aL4C8QGN07E5goFkfLGrosYMnKnR3fpONpx5QoozQ51B47W+B4Mw4KAaX2AyYO9Q7iIx8OA77qJ4PY7JJDNxuZG0fHA0gAyik1fCNcHq9OBDM3cEr/aA/oJ4bzkfc/FyIORWqT6gk45QMxCnephxBOp1EfqAv+fDG1xKZaBRINrCW1xSLvBstVSI4Ckg8OByHA4XHYBmPZbgRNExuHajKNBHCh+Clzl2bcb/arnQXMB5nL4XsZUhg12EFPH/GM9x2c44OxZNNjEijYhRZzmS9yMwj5TIqS2zEX1iXpPYvGGSWbau91AfQ01BuJ2jiLsSsU/2eZVUhyRnqFJej1zuY1JzJzNQLGNxaEE+VK/Lru62ToE0Im7P9XqdVoMLExoc274up/HXqdlUmch8pBeP1qbg3Ii8FPUovjiFBNLAElKst7ssk1QjdLQgmElZB7t6k9KnSfmHJBa+LIw2nZ7g/w9yO0M/V1RMbUP2de6O44Ja9r2fTBPgpj/Ka/v3pjUrQ6Y1RZNZW6/Cr/K3zVhPda+iEff14dCFMgNZJOlTLZb2VhY83oFsxnnlgLs06Zn20fLApaXbJpVLU5irM1qcPRkuhTSfNWihUnNOKfattQMuZMSrgvDBXizAm+S3sIHVMl1HfXKF5qj82n+ESAyU78UFINfv1VtHY+WTrl2C0gegJt2XC+NXc1BHckeKWZD6Fk0CG2xWMIP7Wj/f8ZFtbsE7M/HJKQwRxAg8ucinfvbYih8La9zRlBofLuPxzP928qqGRy+6eUviQkwA/gs04p84squq9NVdf0h2mX4463N3so+gVIFQQeKc3iftOG/OXRzUciXfUUNIZWQURAerrvJ/egL7ca3+QJL0c2uY6/BGyo0Uzz0KLtf/c75Po8Vwp+5vNNOU7D/vwN/d4PyV0HjUi3RJw0PcGogyFwMe8AmQdLwD2jJgEom4WRYf/v4R040Mudh0XlEJZX+A5DaOPMssMKUvZeXjQKkaWsr9BIw52O56VuCg2GqEWtpo//gY46s1xyH3YTdet8we8yhvaQ6DT/2Z14e/y1IeWroiUy7JUCmN8pe8qkLXr4ap1f6/+daLAY7sbBIGnrcHWY4f5huJPwkQjcbv4b33XG6oORKoX6s1unP3Z1F8CWmgQWfNB6qkximNJrz3vaMYIX9ZCFGpWBeAVfrU4xeZDaBVPfnhMHriyugye7gzS+bgNitlhl9KQb+/vD5lLOcZYbH6yTf7yEXiyk/AIbP18c6o7DDpmuzG173VoWpgnyYXNGMM87g9es7JgBr+1ZBc/DTJRnYBGlcB9TIBF+JEak/zYrgIdA4ClnzXgc+lT+FQZljPw/HIFpMeBLSRH64LO1WXZik46wLcJ6nx+r2uLZxFFdSTUEg9h8uB3NQbBuypGJL9sp8THUZqu/hK9um2y4AwjmYvY98VqW1bj6l1TXEGmAnrVS6KswBZTSrN2tWWBFvk54jRwfxRem9TXmHCMKjuqI4hgEhWiawvol6obMtrF10LU6kv9D+QJyWgsRA/jZPSgHikaeZJOoAtGsSaGXnRZtOpdL+OGga2L6sPAvK8sNDWx2iRyRiK3Tb/Ti8WR5mnseJnuVuR8EID0/vpaxmfWWLI4Feaaulko9Fo64fx4crraWVWfv5731+Kz78hWBVVZGDCq1MLHluBI5u9L/llUmhZBgBiT3PMWrRINTTzrjrflaONCPTjahl0nYmWwc9A3CqvPq3uVF49ECmiYfauaSeK/fPAaWq9JQs/eS5YkKzepBUr2VBOZYh34eOGFlwEVfZxsD5buFyOQ41hGFkuNZBorK261/IDX+vWY2/3+I7T4yWCw/TkFzohsow+kG7hj8rRGn98A1n3SpRxR15tgZhppYRZ0hlss3E5LUCODAHBI3JKkeqPmv7cANOSiQwKsvYz/W5TNV4pyc9RyNvzNmLDb3eHcySD5n/N0Ukyj2DUUxUikjgI7sgyd7LD9iC3ilo7lh+noNX32H49p9jGS6FqD64CvIopc81vkHKqsaos8N89w7TO5LxedGok3hQfM5vHgEyGMLwWd2i8tKH8r/J3sNr97jAhiPbozHteN8BlCL4p+G3RKjFyyHWzT6yJsLkbYXZViROoagxRU28OZfRErYxcdLNSW2ZDDM4z0F2bZzMVoGuVvoE8Rp7t0m4HAaZzja6D/E6X0wNskMLP0Aly0dS7i+CXPCQJAg8UCwibPgb9TaR29+QF0tDpsg5M8OJX1RZg7hGvQpOujGtv/sHxSnJh1knPh40AqHaXMM37onf/5GI9KFdLB6NUSYCsi/batIDLi6mW/5hGet9+mfXqlk450BLUJeu20KBH6wMwWE2OTZCezHmSyuoo/G28Q2EgEHtyyX4j5WMiNxqWysIQ0rdEp1Oy0SzxkiLj9piWS0c2bRt5RXohKMUkUQXv7WKNSg/XuNBecNF8s7J3tngzF37JNKZ0yULDmVwVKlQvJ3g+2HxZq+88I46qvZ8mUFoEAovZbWjBbPuSKBJ5juRc4AgB8HnzeaY688MnUncsytzhpJHX4ta7h8bsG1b+B1imI6fXgzpRkcQ7ZMyOMtWgX+5aKaXWPXaN1ZRIFkjfm+ovS2NDmjh6PUCN6V3y8AceTrXIW29XLyUR3icbHBjF+Q9XXvUtdjAfWk++b2HbyLb39wYRYqnq3TMkJnf5OpmiOQ3gPesF5b79WfOXpvjkPHIV5jJSlg0vyQZWnRRBeU4r7JaqJmtpx3NGVdBwIBzSaAwIKVWLbuyjdkCirt7jDhxpf++nQkyxjrPnc69stvRjah4n2bavQI7L5FSPZ8fuaAXPai1F/Hgs7nhDbiGkPWtL5OKuN21CsMUunMLR9GkzuoKysJ9Txleb1U78NTWEgxrmxoAi9vtEtZk6U/hinY67E9nN56Z4P/YgPTzhZnvEk59MT5hF3ojI23eUrLIhIMiJBNlwWrqsvWdx2FYi8rg4lFZZ7BXYb0rP+gJCAp3fwJ1hjazph7EqV99INGvT6J9NmYMkB1tTZyPVIbpWwU8TsfsWQh7DgdYY2aiob+0myNaoBv4wMhdsh9ukcGFb9C8dx96a2MSREYeGoqwcX4eL7/1f/+63HSvZEVAgY1/hW6zjVuywmfOOeHP9GGWgqFLp3unXM+cNchaTV7iXBvi7bDQVOP/p40RXZp/F0PKtDahzIzyuiU0fDWgeGBqUEoAlYGXxbKLMOzEiPjmBH6qkVwvEfGmVPuV2J8AszCCGq8ULnPoN4dT99IYc1bLjV267iI7/w0DBvtjpRFpX6ZTkN3tEJopp/wfOnDA115BZY6AV78fFFsGquW1mz1mUNTsy6iwTt7OWniW0Kc+nV9+qBarOsXPIM3TyKcAV9ubTDqzDK3KsND4ZTGCbPTPbHqmnDuCQjgUgjcsE8xKOh9umZyuD4gnnLd9NR03kEJ6U8SBvuqpNcq047gVueythnXhsjRJTjdV2Ggnk1FQ5hY7Q0f+t4Eajm/64+8jXSIzsgGHRHlDc8rxZcjhW2CDvWKwpPsJqnIrlcxqlKQ48p9D/37BZP04U7Z8gXuc9wZAgEZG1+SMiczCkBn1BrFhjGXl/ytduKW3IuljUnh2Nn/rBPNvfKVyHJmkEasdsQ0aj502RSaOPhsCKzhfahTDWU5Q6WUBgw92/cd5j/15T2UK4wdfcSNBOYfO9b5+xGLWMEc7xnyawLLEJ7jEA6Tz945bTK6JnVBHt7FDA2MySrTN6WJmAwDsTjuh0DLZP9h+44fwHiJsta0BZNK3vLkSSrsX7Stc9qGiIHr+dsQ53jrYEA0TWnqtOePQkiSwoLAdW2th5qLL85M0i/blNSg3qqAlEiTVb/j9UX96SenXVR8w7Mr0FNHeQNk/2yopEjs72NaT86wSpLUUGiwzvpKkCr+HmjuwbHtzpkWPJbtrTY0MKODallNiGHiSNeFhVPlac57MfonGtMPUiE5BXyEKR/RJ9FmP8IB/w9v53FDP+PcRNwolkBehgzD1uWT/5gUY8Fm7HLXlWklhPKA17VO2GUGMom6WHhG689TI90unuwMDalMzJ2DPIa+KqhKtok52WDb+4rTH5gpfmG4qC9T1ZEOLP6bdDV8Tmm3V6eHERPgLODo4ntPCEmr4Vb2Xq9X4aAX7IKYq3bUAfPuRSVaaxj4zuLVd9dMctiQpSjWjCSMfvVo/yNlnyDImXgLGQfHNEkI3D4jliiWRDQxcQEM9+zey5v3uQ5S8tN78lAcAv1LjIOgLuLAvj9HhvyOTPlLSQhsKN5Gg57pBkPqFFts/C2LwR9Yi6cUBucs0O9n4+SZ82MzmZAyfBRyp4q3TYsnEQzOLX0nspi9HOufo9wLvEGUR2R1xzTjvnhPKaxsX+DANcbq1pv0v0NIk3IwIiEILyHVJDCDcriHx7ATspR8FTN2VaIU8bQWliTKE+Ec/zzSijzbdaeY7MfJHMJkBmug03KmlISBW3PK62k8MCMlxPkBdfo95ng8rJiBA6RHwYkh686sEMFxDS5hIwCXtj0v08a2uyWc5uw6eHjeZEQ6negTZOoiL27zE2A0xDRhX3zAJ2lZO32gnsvQBjYNmRvekc2uJ4iiH3IxOWKJFnl+emAalb2qWLvYkAehbJLBvAqdYa2+J3TlDejdgrZ4B4iNYZJ7E+tUYFkJhnaNuRHfYJwL6idXqngQc3u/VrMOnjnN3Jn6QNa1XD2vhTWeBUmG6wKQfXoVCvnuKI6Ms/debYqnCWF3FLw6DxdcKfIFpodUWyZ1dP+OG7aL0WgyaZJ7fLIjZ+L8GdT/QQJXv34iIE2stG2tOV5aV+76akKPchI+8yh84Lp3O48TtKxpd1/RTCCTy9A36H/KE3OecxOaZ2d3okCbebtDSQ83lfer4XOUkiG4ytx+rWSJSG5i2JIDvHbGV0s7KOXuLfsGh3IaECgxJJtwqFBIYk9yEbeBwwsBXFOVYHWgzOuzuLPZIc7j565FBzRpXddjK+L85sd/f6TvYROA/2Ntfk4SFWPSGDLJtZGuSHdok4J01XOfvWQXyjiONWoT8q/fDedPj/4tgZ3r/Z/ooatlFl4begjJXyJaugR28T+Ez6Pnuai/mHzm5oNnfkZ0nQHsmARDTBQsDY8kDCRDztroThpnPahY502HD4TXLo1axxfFEA3QxI6aTAMb8JynfdEnwzPZHh3EO6FqQFYHUCSnXKTWTbAYHBAeyLezhr/6UnkrPmpMH1fGSGdF9kIK29GGwltVB7Y+CTmrumT4Q7Q2c6PBPJTnmaErfBDHzWuW3ZVKuJOZ6p+jhiBd0/VObXckuey3yiDs4kwU2yiqfHryzB2b5voTMgwhjXZqq2/pf0jfOwGRhCzJoPCVODcueP7IYJL6JUjgAXRcYswqhIl1aradadBqrfJNDn7D2//STFAO3R2TJhY0r2KTxbjFYOHm8Ayc0u97YDNDFYjAhIwPEQT7NdMe8uQhJI+0kWBJPq/fnzIUZlqIAtTqvyloUamiOSjb/Nrrsrg3yC0hAGoYdXXEFwKs6kjI1EMulT8L9md2ywT7GX8PznYIPBSTTBZmgm7KfnR4YQ7fyvVG9FLCDv8BduQBpWuRxGPAPV84MlPT3Y+0SHTMd2u6Xs2l6Ds/8HJTwLToYEXbLTN9uEOS6XR4CL3CQOKDEVkxPuU1nfb+Q2OoiF3cR4bppFVM77DYfnLlktNcGTd1XseVbok5uu5DtkkwoQ0e5Uw4Q0FPc117112r8Yq2C/gxcwKrm6IPrjM9VyKQOLtAOkswSlVEtnGTZrhRJ4zGg/l3mg06oOuSGvgGoCj2xkyRYQ1jmiT2KY1O3Jwnl/y17eKJ6uZolSEO8sxZBTp/sgxmvk+UwqU3m89tEpEFU2eVY8U/7zbmXGK41hZGMBmg28Hp/CdVfQ81PBsAo4YiqVEONv87I3UEG7SQcXum6xRp8ZCzYHHEPkk94tfvmAaIuPriiGzG6RcdZjDALm74uGFlhOyAiM+tbmIloQWO+jq5uaqm+X4VQ8yCL97VxrCqs7HQIwVgfr4kRPw+2Mq6Fo0PVAoqz2l940UuSWWULtPS00RDeWxNw16md7el0Dzy9tVAd/XZR9+PxIp55gRXYQ0xJPkT1IO4HRwQPCao9g/Ey3eqYcl+UsDdSSNzIGK+A+yym7fSRGMU1QZLPaaFTHO0SHjBip7+Ifx97Sk2xqGBkf1dk3PCkT5e0f5dWyjCe+7IznZHSA+yAWonvBabPxDVdZ5pP5b+O2kwqeX/LLyeNwKP3WXu2Dnx7Mbf5ItXn09QUy6PwjNkZXAw0eeZh5jNCKxkQomsP/10HnebaWmNegyXdEILk1fhjPbMk2jYFCNP4WYjE+XWzaNY5YsOP1KZGnhM+dwyC81FkOHCOXvLJ6zUoR4+PeNLqZGC0n32SRtp4HFLUH4RZ57vyLsglpzVPU8Mnh/NxHVF/3kFz/u6MKnxq9DlgnPUCnYsYbkTI9+k+777Q9BhlxO2uqIEwNXy3i/RfWVacmWQZ8b0fz0CuMc/NgluIMdpIRBlp621iCH/r7XNwMzcRMs/GY9ry+gOFbEUr9HSPCePfoyYVvAHkt4G+T9TEHyctmE+0+o1GFgipYD4JnqUAc+OwxR2kMlQbNPl5elD7jMuOHgg4BKRrZy3ogL+jD5YqABVXCwGSEUhMpJGip84bO00qWYF6+fBjqCfvEw2fpoAgKOslyzKp2fF5j5NJ/XjuJPIsQ14Vn/sDuKfiCuleXGELWZ6onTvyYmieUe4qDes3WsuU+kkarvlI93SkM+BHTAPFI6g3vz7pe9dWk7r0pCJHqPUqZEbDXhPMWpHju4HP77B3cW4BfMUSjC9JggTwwyeYMCxIQuaE7Qf8GLrfJpSxrBkcA+TFzjvEI2wlwDqmits6gEsYCFOMyK+Bkmb+2CifQO8GaIfDz59ps00a4JHYlhnB0veR5ITaEmqMM9vKrI5qFm7Qlym3Kp7nDbsZwT5CHi2QaF084IaX45hUwiJvbDeSslL2PXgDbsxqbrHjCoJ0B8kvriXo8cSjYGza/vs32Qr2FpjCW0P0Mah6OpmhxD2JgSNYzWF30oaxLPn/06kPPImxz7cDnUyI7IqOSn2P2N0SaiRWzpWNeU3D2+EPJK35N6jN0Z5Y5NolI1a7OFVTik1zLvqBCg28YyLaIpdJpNCGSSzOR6yR7ZMeKIC5MHO81sbE6j7ulLRwc1demwWqICyJFil7Ny3/GapWrETdXAv6S7EYDq1+EquGxJTagq+3BuWjpxf/e1GHLR14yQ6yuO3g0wko+2kyb0UaS1uRzjR8A6zFajU6RQyDlYRkWv1maVGL3/ksZwYVYfFI2v5ZVaFLq1m5xSwGoYkIpOzXFcomVPz2DVlfStigVYDx1Tu6pANa4t64Xyo4xXyqj2rYXXoJCNtreO9sgzv3xYEQrspIwZ3znWwys5IKvOq1pb0lpL1Rdrw8pHMtLlpaQnGX3zTB2fnHDMjeELTbzH+4OPZKvP4rIEnxsfzUkvphNo0tME8iQajpmdXFmOBYHFb9QoGCSbGbJoHJu7YUnROhenH5jF4lQaCESWo5m9VY0JZ6CAyRy1EAAAAwHgAAQYidtARMkcVbyZHeUmNbH9FndvVCedDAu/hqEBjEGZv/mD32Qa2JRjnlvR+7ukxdSxenW7g35TMbMWK1dXSyuuttjn6zyxfE/C9gH42if59Nl/obEwFdw8Jqso5d/MHqDFAWMu8L2vZ3mw1rr3DozzcQBP/vnaDgh35Jcu7CSOw3wje618cN1dL2JXvJuLB3a6I5vyCaXNnh02IVi0pRGXSo1+cBqlBlVAhW0PMZr/EMxOSWqKyPIK7nLwWLscXOXj1OuW5GLeQnVxgzGrpMERvEFbfNvAOscSMTytbjsZJx2k6nMViSYIQGfIbQN9Rjvsw6BqqqVtnN619vxK49FGhTZ+IjKs85mqaVN427TY72zbXaMAU+z88wMmYt9IhK5FwZugHc/FlqiucqXQGO016t4pKjwyZIFwc027XISFomWnzcOiDJNP5ArwRs1weB8AFjRW9bLh7/0JzbE6aG4QWyic4Wdrcd+nGL37JEAEwVUnsuxz3bsS27lwzWw8RoYSp2Imd0RHCeHKczDegYS9cW8IbDNudp2usTUNDnwp5mpWwGD8dJMyGhOv8hzolUxeU4GC+ieNm7hJ2Ajw7yvTOkMe1KhaaPJPB4QdcR+TnDfaWEtIFXgr89ck6mUXwsOjknFnd1FkREpLEdTYyfdD9EJtnWwy5s+i2oKho+x7MySvMS/qJbgISLArwtEJx/6FJOOWo7YAPdxqxUGyG7iKWXUDw1uzxQWbr8ArcufAXlzFpFC2iOjTUmjrdZ2oVIjoO0cJz7nxaUugi8/qoXUMqAxRtMz81WX0qKz/DFGrLDFNwVs5R/Z+XSa6dEoWBLgAnULfXwCkUmO0K+PThSLnGMHW8Bf+rAledilvisYgQu/qAZCykyCf9eRQ9tYhc8/d9s5OugKrRTL02HA6AgvD0LegxkmSgZkSCis8tV4C8NhyVu3RDZTMKfuP8G057RMI+AvUqp5IxKFGZ+tWVvxKZnbDDuhJXGfDnF/Ct4q6om8Lq47orm7JEnzODRuX7JhBPwaKm4RcLe2wAir0cfBQljlNXL0VNzCrAsNtJjBtP43OlBkLQVBAMuxFrjD6V3Ik1+EFH7DwT1uSLHirNtWCSR5h5nWqwsQ7PqFjhPG70aXStPZ0y5yH+6p2l1pBgwcCawEguGH0dFLA0kWqaqEZU0YMl2LaTDK9GsT/GWk0Ew5g+NA+WxWPttaHQrL8nFQ0kg+244UVDUj57jO6DMcotmMD6DDLTwMJE1UelOz+3gaZNX/k03szKMW574a5V2SyxRHxMgOJRl7aNPQ/KUGykMfcdqnXj0G2LWxioeo24JUWRaF64qec1ksdcSPJwRDB4QLtYE7AhLlm3L7/fuJwSck0vCfowIVyAqj6dE37+9ys4nrokep4+hGhBlLYUHjA2p6kGm+iXwE5NtzLNmUE+291Y3z6UHRK6qSp2hTNWdaZ0ExWyV7jYk6rAllRrfEULV83U0Xa9nDncrhVr33tOX0IM524wSsmMbAKutd6MO8fy2TWv47V5VF/bw2F//1BLak2S1MirloFizuVFbRLow2yIPc9ErIouXbjathD//uP5GmYEb3BPSsmIATfbe3No6JwmyHoxeN40qQNA/7baZW2S+/EsHdseT/tsxHWJF0OeY5WYs4OnGnh/wXoLPgeRsZPv6MfSTRg3+Gdp8fcPWwe3HFcA1QdCkvheMYWSFxeLbq0Q/4Ekay7E7DaVtbHq/8FYqiblzc2mx9LoSsGvh175vBZOmvkPXS151j9kroNdHGq0N0hlFkIAgACPkFIvNDdSBpoFsXzcvFfnsfL5cTD0KmSW5GpNST166X+glGkWzXkqKzAchfhiNBC5N5y2bqmMQLjaKTW+pGonLke+gDHcLaj2kruxxzM3NpHLEB3uD1LI+qYnavpDpXsLh6FLZmL5nF5FdYlIgFvpeuO8oDkvGFz48PlS4YCdvgdHbh8SXp9jJBqPIo7JIChYEXLqhzMhXUCcR9RHhZ/2wdb59+C23jV7+pplXYhlNJjAvuj15PHRJXcAvFzK6kvxa2gLoS9mcNBQ6FrXvbTzHDzOBDO8hgD1d1/qddEjWeXYnyEfMhc1GLEkjf41RP4+6oFKlbdue1iT6iYPGtltTrvZrqI7AK6GJP4JmB9unYF+4G5ToPmt3l3d5fSFv+qQdD23acAI4SB7QJmg24NAIRoa//V6p9/BD6Nyp0kwM9p+jMsNycOwDKNItDuAW/dRkwsu3fEwX4e1XOxuPUQcgfJQiVwF/s+4s85Tg/bE4dkr7UA4N5uXYUMBHh42VoTpETZ06rS/+MWWVLwuxHP/LmRRe+oMh+Py6HOeR6fFzairoHmCQ/Vj1I3as/gZxvjZH/mk4CNrE2P5V5TSkN1/GS8rJn6yIcuHVegGXpzQfwTQgKtxVnAYaq/5mWgEOCyn5woGvCCg9afq+M0ndy3BWP/Fk59O2cDzBx2JRQRVrR5FKYrmrjcYOAwUI04ooFUFqKYxCuKPURXGnCBkOa2jemw2hmt6lNurWjI8xaZus8v3DD65oUQvjBjGZVFT62KGwiumvjS0Mj0LNLG7dkwats5FdBaux8FN59m6MKJnJpgeuO1R+NH78oYSnCY9tW0sbMvfn7HQjgbz+ate5iIfsJ3aQLrcn/wvPoqua5vgCAEFF3DrNSsM7IZEtSjoGKeJ2vo9sJCNQgQ0OvWEICXowgl21izAcvjEPTQEoFJl1ZejTif0w8g0AYHe7PVGyNGVtbNSLGaadrBYTMQz2w+GO9XtCvN1jccofpJnBVC3UmlvV10V+/vfjslFXkqo2gcxcYJsXgGF19mH1vlPRUoTInBuL/geduWXjKRGlmuM11qQicmXVdYvHEQpwLm1hrjD7TCsOkabD4qwnHpui3sdmT1m72kFGcZy/mSqJts0tCJQRRHYPUUoBhfBfl3SUJmDUwIJsYmWWvqVE0OO+GiY6YAGEyQbAD4/KYH5ZmdvIlvtCt2ZLniPOQnsYe0HLsnW60ufmyx8BUG55p4KAPIiphYNGkm0tEKBfkQ5tqaZ/DVLHL5JuxgobcTKOveo5cILQ1/07Vhy8iwC2STdfdu6ap6TpvVxjdNIBJ+DOgFNbM8Iwnffw6txnpQYLLkw2NDUGKR2JcxrOEv5gBUez1ga5U+WkTIGakUEXqfUXucPBq5fEx5ZSTwNkhZONn/ecC8COYcTsWCBwOV8oBlJBRD3gkPPAhak5SAM6vdOGNZdQGtpP85OiJj+xgsemkuBrZ+LLcfPy+WIP6uS/A5vEUTy9BhK1m+lsB3sdleHzlmWMSa5JoxnUU3dPqg96bNhGHOZvu/Zql34Tbtz6kBvFkTvx7gqzNQM62DdQkzo9/+Iuu8A639il9fpp1Vle9XnmjKSFAGzEGB3M9KxgFI6plFuOxK1COZ6G6a1Z+EO6xeYHF9pY1G+989Uaqrp/JJyTMlwuzH2abXTRPB6ORFMhcbzA0/9OILYpzsC6CGirmtoGGAXAV7zYjLcZWYA3WCsL3rQIlZVG7U+6oVMWCPGj8mKZ4zW0njADw0AYFszToQy4q72U/R3rVbU0H94STcAva5ZBqtX/4HFszPGYZibqgjg3lRUzo/t725mxGJGexlOwo7jLwcBJr1CE0eVuLeSZpUQF7z3xmcnJBaaUuqtcWNWpQcBQngmMxaGISPaQtfT4YNMZcGVF016Q/dtT/y2YDHlsYQa+0Sw/druQ62ouDvj4M7Kyn/qYyS0DYCwMTeQpc+Td7CbHmOV8SlMLDDPP65uKW0IxdCmc/BmlUuqkOiFIH2/5SSPN+rSTlgVHevA0fdI5NctvkIOLiHW+grVBpZv9XqJiLUF5ZsKPIlBEs+9J+pXwgDarE9qm7rGtaohV8WDI2RqcpLk2GQBxH2N5pJxFMZ7Uy4gzAvP/uQDIsyfr/9egD5WzIksaeX2HBGWHA+CkiTlSECLtSlCB0066eczZ574w0gfkfNvO1iRdYPYROWT73O89A2vsC2i5ysde+JrXUFi8IOvWNJ4m5lDrKQcJafVeZUZO5+sSdNi90pCs6GH4+IENpkFje6Wul4yJD5BhOICP4o9hScwbgaUncgK0Xsr+9M0FuCB0ld6WBvVwmnXEsUaT3uJYglATCogJYu+kjoE7RUNbah0F/SrCikZuSqyn/2HyipwVsYDtgInaSdy9JbA4zZs0ntPHgmZWRT44RDmrUOrtcsn7/Ad5+scO74BzOUSpHRAxB1njPwKgivbedgH9teazbsxnN3XnRFfkn8IzqiSrD6xJhmuJpu71rC2f+NK+qz96I0Y05DJM3w1IQINVDTbk/vXz1/B5iCr/q1+m2CXBl64vgeEahsLw3xazz9nR8q2vv57FiDGiNl0JzJOpFS9t3F/SA7fZXRmgLb+PIoEz5aj36lnbZPnasWgGet5B70ZbvsK4bvAOmCqVpmVAf9eOYdWRt26nzNpkF18Srs4x9vpT1OM24jmwHiuH8b505U3KYxvXuZgWBCKQ+V4pz/QMo27qB1kiOAzCWfcCdtnSj69iVzA3EpTyUbuHYypXU5NAxq0IRNqUno9D5yIvwkoDvUhdM0xgudWGv6XXrZCt7QtCJfT+wh8QXAy2VE1jMdMX3/h/emAR0dXDTProL+WHC+LhwoySsaiEF+RGq3VMt9SV40sb8jhqDOK/19e9tJzjyTxncTBxvdX2didyxjLW5u6TFVwKoo2qQ04SMLcxhyQV0HpW2v4b+yF68+1KMzBV0QC51I57EFVFHdH16bYaLCyIL+w6qqxeDVvN/73su6xCTN7bA3x+PLKUa3G2WG9q7lzlI54P21KsukQAb7XtjdIISMEkxFkU1Ej5MwvWLcIdJWvRS7m2leGBjOg1kWbI4VF4w/vb3R0feqPxPmECliDw1h/khKMpZ41UoFIMseHUknOthEmNKkjSTEX8OAOGBEfYdDr6WkVg82jrgT8TuYRSkvN9Ryaltg5cbOQjGBOJLeB6jrqbG6Sp/3RNrc9jBS1CoNzXEgLZRAnEqlJv0D9xmw8VdOwoiDujKCaZgnsVR5d1Weje47CG4/0C4tbgRyItNDU8+9SUZmG5Whz7DuGxv0SWql9u6NS5VKqnm2u3/E0IZCbauYyLVaOe8cV6tKKGCVd1af1wZskBBZDS1t4Xfp375sLwjJRxh3Y4JksJTcZzXMK+1ySRgVozheTnu47VXgXgGiCmztTLysGSkHJe0nEQjp0VqlYHzbJe0AHf2rA7p1uW1SSAgjK4bVutgqoaeynpBVMFFnu45eB4DZ2+sthse5Qz+p0FC8lQS+gICMWLi17ypc/5jMRLfj9Mlt6bwa6ddxWZqTOicj2KYTzN3t9V6NYyd6DaxOVyzSeJole0Z5WM3nCMWk0SFH7eAxgHo9xFku/pDMiQ60zrCmWC6hyzgWU2T11fQYvQ84fdFiKfHVO6CbebfYzFWeXWaA07EcxgtpSkNx1lb2GbXUkALIFOWzyt8HC01rLq4MSBtXlIOtai5pS9FKtvYjBKMotRtS5DjI+aXDVdNO6MglJLYfj0ksXTmiJl96pFHJt5fWp2+5o+r7z36BR2xIfrQ/RbyoJqOz+Wr42pTuttbhFj8lJfp0OysiJOnsUQTdRDMekJTwZ3bmhynW9oBA+XLKhh/1yMTAc0SQ/msJvMPYzYI5wRQZ4GWtpGfPW4+RRNUixp1EklK1eyyGByj3Kj14vT2KT4hR7Nw2ybESOe6/+D82KMgweqK9Miv3TQtYcCqCuNPEMRqh0AFD8MAvcdzED89r9klQy/dgGdJPGzzgFeRx0iQj9pRcg6ipwpemQt3ktRmt/xtWKF7byThPOBRNint9pkVTDU+xFC+A/fk9e+ZfodY4Ve4vn3vqfYjE+S3sq7+WIt5x620hdw4Vu/bzEos52dhoHK8l5w/3KYVa6h80LZAKk+cAuOlJY1nKTrri0EP9oq6X10nxKhR65XW8oQn6Pt635/NMsII5wFH9Ktec962C0E10frI58ZXTbkdBrY9eI5aXdVAacumoZ5zAPf6ni9L+yEUBaMkc9RSzmRIPIvIp8n6B+PrruSGvruimnkPgjRXQgiXnZxd3qZK3EPRIxkZFYSxK/LGCmYIpkcHn0utbl3UKCgHps2qig1RXaYGG6HfX7ioLXfdsGcqOsaaW7/oG6BDFvuZezH66cx9POAUxcmLlj5SwCBqM3j75OHf8r69Q8DTgkyTEYgiw+a5UhBJdA5ft4kkEIVpovgs3IOQ59KGcMet/2E17PIdK+LgOUTpbcbKQrFwhgt8a5YGrsAr3Nwzax4I8VF6qBwy/rUJn7gGKxbMggGR/p/Jh0KpbU1HccxdDTyaLz23SR3S16P3EwK7HyD8Vyz0f8PwmAgyOt5Vq7NViqvOi64JeQBTSqm2J7gJsbqlepVkUAp7Vt7x49W8nPceA800mU1zsJVsuNTYreydGB9PQKLqikiaQ8dpOElYKJ2lAHDMT97/3xa1Z2LImxc8XD1bGjD3zNSeEU6DZ7w9iZV9kYX8VgMStLZXNYibPNg6NjIUp3HQN5YZPS/sub7t8R/XHyTJK21PsO39EKDJsy1qlcbwa06EthWYDETyNtPAXJODYpxMrKJXB953iJzxQ3K0TSWvo6q8mhG+HJ6lBGV29/v0bdWqRoRK+zTaME2cQ9DCX+dNoIhT42d+t89zE9Zm1P4SJ0N36E5i3BZik3tAfdsjZQzNCfP4T9nIF7iK30hew6d+YbvThFew19KBIuvTZZ0ury57Z9DR4DeDETD5l02Fsa51fC0lT4E6r7BHlZHHtFqLKIuN6ytmDTnZvO/2nSCAnlTj7DNYFnZgvGeJURAVn75Q4/M7sN6b+sjhX2hJK/AfakqkW5qu7X7bJIDUKpazWzoPmAgJ1uhxrOnsMYcna9tLHCdnNLp7ObF8Fd0iB5BF9nhQ/1Ef0EpQMO5klJbVPU3fOwv1SXiJNcx2V4HILxRWPDGA9SWsuV3H3PGNzKR/TM17NML7lcyTl++OAN+k0Eb0oqFpOLWyOGX9omp5vWBIjBTVjuJDbBidL40c9IbhcXZ+cTQQlng+K2e/ajG2KBhUxq7UfufI9hxBabyqI00Qd44C1kY2do0n2P7U5aw8KXxwKfZvPd+zAfbwWYWgGgskb9DDqJ8f5jCVICBpowsWFekDX6hvkYrGbtcUaRDF7W1chGKQ8wySz6s+sLW8OijRPh5YD6nOil3Al9ZwTEuKVlpgInfDOzTpQJ7w/qemU/+Nl85iHNCcoPu9v3Hh5Q/yN+FoHTxIs6SXtsFgM3NBtjLboPzyi32rwadKTZJP23B08lFPNaOg9ZvHas5EpDrN4RV4cso54AKYDFGRRlrE/cdqvUxRnZ2fb9Y9SBD5IVZU0YIVg/stPuzMQEeeMX0/1u9IytSI+N5RsiX972PVZE7OUsqbEbAdo6XmkZ7PWtKGVTIpKn99QVDfHXp+PwvdLj7A5l4xvs+HWSMnwlUJocs6SNSpWpa9KmA7DFLaNjcI9Q2FqTucV2wAYgGmdzkqrG2XA4M8/72nN8YcF9v1JYpYHpEFJNYQyhRn3pbvvDq6si+AewBT1ZqNF+QXg4dY6iSTjkozLj2bGNea0k1F31Qfgz3b91z0h2QuVMIHaIeONDNVmFLxSmSqhRwEGe8GYcvHOENqRfw+NIUoCjim9bWRhO87sIdO11K8EnCSOPUu1dVA2EBfrxTmDaGKr2zlJZg09Z0cIYXeikskxHFJtBizO1I1ZhvarEtsTEDTD5f5cz0HZKb3jPQBcCwFxOaxPv9gBxUEXJohqphVRC39fnChVXYMStyKpDABY1o7z8diITR/hCxCgvf1Pm7mlfsaAget8km6Fr1rjG8TvLPPvnDI26Hv/HTbWosx39VMZgtmmEhJcLkM00ggE8LTNgFOFaM1CXbSgTzE5+19Vw8PkQXG5aT/cR+4kss9M2WO0DvOagNfdaz0xd3NfuclEkj0BSZoTSUvwJHt0Ikogb9A8gbvPE4f5qZVjOl9IB3FZZ+TXGP8/LRxH0yZMHb4f5gRFZUuio6Ibt4wdNPL43SWukVvC8DphEB2ZxXbFzPtf43TOdABp56ilqVpX84PdAtaubxUY66Cq7koeifsCX6bMCrUn2K3flcPntKjnAdLnMAf4dGFL8SZtUvdjroJRo3sFuuse+eiKaWP7gTjtlONW7hF31iWv6bOF2TxVfodaEC6abGUsSKN3m0icKZQAHb1k0sasfQ4sGJwZ35UftWCNpC0Agi+ntx09VjcJGz78ztKAqZO7+GdRcPfOzLb5FqRpQY3KHoAzYUQOwQP/axxrhfTUDVm6XkCudB708jRuNgq9vx02mOxbrKmivAabCX27b5HfITouFVZzvFSGSbGdx3E3po0LOpFqWejGQVJsEHM0sBRCJMHANDAZNz/1me2o7aLTwEUSJdFKEMo8pZtNELSXFJJkhw3vW1gT+XdP1kX2N0ycShNF/RBjySOkeKkFIRgOKf976FSMd1eH5a9SP3yZuPRLL7taj8MMsFWie4W4o8N8q66B+tL9sQrWAdt9eVc+I7ssRbfa6k8APHtztlZY3QjxRJoy6bSrMYLEazBwyFaltzVD0pj+EeohBzWoVtxvUXXuloxRQ5FoO5LNKqQd0W0OvbJlqY+QOjGni7pUp8DlXroTQg9eRP7g9gJ5fvLubGELNEVKzH2dbjALcEQjZJMjmCFt56UcKf+XZwovzoC+zz41jX6fOAlTn8Sj0nHqTaUlvoRy3a4SOZl4IYwwFCYzgtpJsDt40AotacT/hhYKTRisi5cgu4hJZqD527CqTFC1HiUOMRlQG1cYy17zUPuHh8wRgk4YhHNdY03GzNUirYl1KL1k1BXIQb/jOvEW5Rddxs1k3FgVbCIA7LVlSw+rM+MbTFuTX62UGsf9W/PE/yUBMI7i8URXa5fF4GnU1Nt+2VZc4/oqEyBXm0UhKtuTFHDCe36HNlLAGFZtmtHISUVeeztrh7OmyryfvMrMRapursHhOXU2zZ43tOaVxtSojb5Zl7DB82Lk4Pa9F05x1BhaiDxAmJkOmTQ4vdwNm/uMPZjXBt7fPrE5QEYyaW20GxSUSBmyQ64BIzG+D8ZS1zNel0gXiMPzmSZ9611jsbB1tnwL4Ybw3nwLkB4ljiv82Ffqo6eSkdGYakakXq67toGRZuU67C+Tv7V/fxfTQd/9gafNWCcVA4YQ6byfSvO/5Qo8A1CeWNzb55E/tT/kALUl8B4bzmw7z4iNPogHxqH8yqmzqHBrhZUQ0+LNw/vI8rIUHmgux/nFK7xpfGu76Qz0Xq4t5TIOJjbEX4P/KLG9SWRgRb3+/MVZcEcSQjhxfwDPhZhHJ38esg9OadgEedJc7m5LVEap5Gyi7T2IvkHuEAqfc11GVWCAtrjeoDEXF+ucpX5UuEOVTvXr4CA7vgq8YGMEX9oRTYBaITG9dFbOp5JXKBGyrvFgE0YVWBDJ6cstuo7+OEKgVbBwvvjj5GS5ITUt9GeXw8im4Ug3Wmo10R3eN8r5bdR9qBBcrgjMwS8oBZuKWseMHSHRbkVQCiMAjIwe3JCDyjDF+mTk76qp5SZS/rk0/SB+LV3twMifrwSOSv5pa8eNsNdJ2W6pNZoRUaJvbztzcUkoYqDySw6iYSIrAiLyVPlx+IZ5TzTIrWBYACvaJBe7uv1nAssV+QdFvCmm2Ufg/GGornQ5ycrBtqoNABUkEW7e8+X1G8h1lpMLwFwydMjR0iGjWMMgqajm76JYeOAuFw+qFC1py8MDVqcI/Qt8HNH56HE/Z1NY693Vbz/kOQBqmIeXWcc+mibNA8Ouz1KcD0dk0mYiEu1pcoVlVnlo3ahG8LGR/6N16zL774XV9hZrCsHK4OS8rX+2qDH557NHihvprzUGTadJCMnM3Ff22Uykr1GGCscYUsoYta7SveclfkczcmXRzISig+iVgk+s1L8ak3KeoJG6bCUirPFm0CCwd31QQoKJp2x8MGUrMOjX8GD2Uzni1ZRD6eo6ByzjWk1atqRwj+F5EVrFV+V3n4NwhBvvuc013DzUORMEKbr/yPeG1D4LuETdXiyDFQSVXjx10KkA7X7lKRQQHA6mUPgBMszTo5ZLItJqdKsUCWC475LkyN15ZSWwC+30QvSA4SN9EWeiL6XnGZyXmYBAZg3i/ZcE4vG9Cq47v32M7BFP2SPc648zar6wRrLllH68/LuuVCrpQOhyfNcpjDozQdnbOxFedd6ytOzMtJfY5NLveWzjImO2RMtWWz7VJKrCcnOtwBf3xFguSeE930LUsycs/mAAAAAA==');
