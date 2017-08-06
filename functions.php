<?php

function debug($array) {
    echo '<pre>'. print_r($array, true) .'</pre>';
}


/**
* Function Clear get data.
*
* @param string $inputString
* @return string
* @author Yurii Radio <yurii.radio@gmail.com>
*/
function clearGetData($inputString) {
    $inputString = trim(strip_tags($inputString));
    //$inputString = htmlspecialchars($inputString, ENT_QUOTES);
    //$inputString = mysql_escape_string($inputString);
    // "space", "!", """, "$", "'", "*", "/", ":", "<", ">", "?", "\", "^", "`", "|", "~"
    $quotes = array("\x20", "\x21", "\x22", "\x24", "\x27", "\x2A", "\x2F", "\x3A", "\x3C", "\x3E", "\x3F", "\x5C", "\x5E", "\x60", "\x7C", "\x7E", "\t", "\n", "\r");

    $inputString = str_replace($quotes, '', $inputString);
    return $inputString;
}



//---------------------------------------------------------------------
// Добавление одного или нескольких календарных месяцев к TIMESTAMP
//---------------------------------------------------------------------
function add_month($time, $num=1) {
    $d=date('j',$time);  // день
    $m=date('n',$time);  // месяц
    $y=date('Y',$time);  // год

    // Прибавить месяц(ы)
    $m+=$num;
    if ($m>12) {
        $y+=floor($m/12);
        $m=($m%12);
    }

    // Это последний день месяца?
    if ($d==date('t',$time)) {
        $d=31;
    }
    // Открутить дату, пока она не станет корректной
    while(true) {
        if (checkdate($m,$d,$y)){
            break;
        }
        $d--;
    }
    // Вернуть новую дату в TIMESTAMP
    return mktime(0,0,0,$m,$d,$y);
}

