<?php
/**
 * Created by PhpStorm.
 * User: mihailnilov
 * Date: 08.05.2020
 * Time: 17:17
 */

namespace App\Services;


class Service
{
    static public function generateCode($code, $i){
        if (empty($code)) return 'A';
        $len_string = strlen($code);
        if (ord(substr($code, $i, 1)) !== 0 && ord(substr($code, $i, 1)) !== 122) {    //Проверка последнего символа в коде
            $new_code = substr($code, 0, $i);
            $char_code = ord(substr($code, $i, 1)) + 1;
            if ($char_code >= 91 && $char_code <= 96) {        //Проверка на символы при переборе UTF-8
                $char_code = 97;
            }
            $new_code .= chr($char_code);
            $last_string = ($i + 1) * -1;
            $repeat_char = str_repeat("A", $last_string);    //Обнуляем все последующий символы после измененного
            $new_code .= $repeat_char;
            return $new_code;
        } elseif ($len_string == $i * -1) {                    //Добавление нового символа если все символы в коде являются последними, добавляем новый символ в начале кода
            $code = 'A' . str_repeat("A", $len_string);        //Обнуляем все последующий символы после измененного
            return $code;
        } elseif (ord(substr($code, $i, 1)) === 122) {
            return SELF::generate_code($code, --$i);     // Запуск рекурсивного метода в случае если последний символ является последним символом в UTF-8
        }
    }
}