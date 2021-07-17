<?php 
namespace Analyze;

class Analyze
{
    public function accessAnalyze(array $parameters, $file)
    {
        settype($parameters["u"], 'float'); //Меняем тип данных элементов массива.
        settype($parameters["t"], 'float');
        $countLines = 0;// Общее количество запросов.
        $countFail = 0;// Количество запросов с отказом.
        $availabilitylevel = 0;// текущий уровень доступности.
        $timeStart;// начало интервала, когда уровень доступности опустился ниже заданного.
        $minAvailabilityLevel = 100;// минимальный уровень доступности зафиксированный во время интервала.
        $pattern = '#.+:(\d{2}:\d{2}:\d{2}).+" ([0-9]{3}) \d (\S+)#i';// регулярное выражения которое находит: время, код, время обработки запроса.
        if ($file) { //Проверяем что файл нашли.
            while (($buffer = fgets($file)) !== false) {//Двигаемся по каждой строке файла
                $countLines++;//считаем каждую строку.
                preg_match($pattern, $buffer, $matches);//находим нужные нам выражения
                settype($matches[2], 'float');//меняем тип данных кода
                settype($matches[3], 'float');//меняем тип данных времени обработки запроса.
                if (!empty($matches)) {//Если массив в котором мы искали выражение не пустой

                    if (($matches[2] >= 500 and $matches[2] < 600) || $matches[3] > $parameters["t"]) { //Если код строки в диапозоне от 500 до 600 или время обработки больше заданного, то повышаем количестов запросов с отказом.
                        $countFail++;
                    }
                    $availabilitylevel = (($countLines - $countFail) / $countLines) * 100;//высчитываем уровень доступности
                    if ($availabilitylevel < $parameters["u"] and empty($timeStart)) {//Если Уровень доступности меньше заданного, тогда записываем время начала.
                        $timeStart = $matches[1];
                    }
                    if ($minAvailabilityLevel > $availabilitylevel) {//Находим минимальный уровень доступности на интервале.
                        $minAvailabilityLevel = $availabilitylevel;
                    }
                    if ($availabilitylevel >= $parameters["u"] and !empty($timeStart)) {//Когда уровень достпуности снова станет больше и равен заданному выполняем код
                        $timeEnd = $matches[1];//Время окончания интервала.
                        echo "$timeStart  $timeEnd  " . round($minAvailabilityLevel, 1) . "\n";//Выводим начало интервала, его конец и минимальный уровень достпности.
                        $timeStart = 0;//Сбрасываем время начала.
                        $timeEnd = 0;//Сбрасываем время конца.
                        $minAvailabilityLevel = $availabilitylevel;//Минимальный уровень снова становится равен текущему.
                    }

                }
            }
            if ($availabilitylevel < $parameters["u"] and !empty($timeStart)) {//Если после анализа всех строк, уровень достпуности не повысился выше заданного, то выполняем код
                $timeEnd = $matches[1];//Время окончания интервала.
                echo "$timeStart  $timeEnd  " . round($availabilitylevel, 1) . "\n";//Выводим начало интервала, его конец и уровень достпности который был на момент обработки последнего запроса.
            }
        }
    }
}