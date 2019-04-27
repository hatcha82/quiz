<?php

    include_once("db_function.php");

    function shorten_string($String, $MaxLen, $ShortenStr) {

        $StringLen = strlen($String); // 원래 문자열의 길이를 구함 
        $EffectLen = $MaxLen - strlen($ShortenStr);
    // 최대문자열의 길이에서 말줄임표문자열의 길이를 뺀다 
        if ($StringLen < $MaxLen)
            return $String;
    // 원래문자열의 길이가 최대문자열의 길이보다 작으면 그냥 리턴한다.
        for ($i = 0; $i <= $EffectLen; $i++) {
            $LastStr = substr($String, $i, 1);
            if (ord($LastStr) > 127)
                $i++;
    // 2바이트문자라고 생각되면 $i를 1을 더 증가시켜 
    // 결국은 2가 증가하게 된다. 
    // 다음에 오는 1바이트는 당연 지금 바이트의 문자에 귀속되는 문자이다. 
        }
        $RetStr = substr($String, 0, $i);
    // 위에서 구한 문자열의 길이만큼으로 자른다. 
        return $RetStr .= $ShortenStr;
    // 여기에 말줄임문자를 붙여서 리턴해준다. 
    }

?>