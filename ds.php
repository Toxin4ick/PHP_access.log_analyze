<?php
//считываем файл
$text=fgets(STDIN);
//задаем шаблон регулярного выражения
$pattern='#(([0-9]{1,3}\.){3}[0-9]{1,3}).{1,}GET ([0-9a-z/\_\.\-]{1,})#i';
//вытаскиваем данные в массив matches
preg_match_all($pattern,$text,$matches);
$ip=array_count_values($matches[1]);
$adr=array_count_values($matches[3]);
//сортируем по убыванию
arsort($ip);
arsort($adr);
//выделяем десятку
$ip_10=array_slice($ip,0,10);
$adr_10=array_slice($adr,0,10);
 
echo "10 самых активных пользователей по ip адресу";
echo "IP Количество\n";
foreach($ip_10 as $key=>$value)
{
    echo $key.' '.$value;
}
 
echo "10 самых посещаемых страниц\n";
echo "Страница Количество\n";
foreach($adr_10 as $key=>$value)
{
    echo $key.' '.$value;
}