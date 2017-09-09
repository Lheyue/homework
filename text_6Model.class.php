<?php
/**
 * @Author: Lheyue
 * @Date:   2017-05-12 13:39:21
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-12 14:18:56
 */
require'demonModle.class.php';
class text_6Model extends demonModle
{
     function display_msg($res,$data_range,$c,$flag_show)
            {
                $arr=array();
                $i=0;
                foreach ($res as $k=>$v)//遍历数组res是要遍历的数组k是下标，v是k下标指向的值
              {
               $data=$v['date'];
               $year=substr($data,0,4);//从头取4位
               $data=str_replace($year.'-','',$data);//str_replace把字符串3中的1替换成2——删掉-
               $num_month=strpos($data,"-");//找到2在1第一次出现的位置
               $month=substr($data,0,$num_month);
               $data=str_replace($month.'-','',$data);
               $num_day=strpos($data,'-');
               $day=substr($data,0,$num_day);
               $data=str_replace($day.'-','',$data);
               $hour=$data;


               if(strlen($month)<2)
               {
                $month='0'.$month;
               }
               if(strlen($day)<2)
               {
                $day='0'.$day;
               }

               $true_time=$year.$month.$day;

                if($data_range['rear_time']<=$true_time&&$data_range['top_time']>=$true_time&&$flag_show)
               {

                    $arri=array(
                        $i=>array(
                              'temperature'=>$v['temperature']
                          ),
                     );
                    $i++;
                    $arr=array_merge($arr, $arri);//追加数组

               }
              }
              return $arr;
            }

        function count_temp($arr)
        {
            $blue=0;
            $green=0;
            $purple=0;
            $yellow=0;
            $orange=0;
            $gray=0;
             foreach($arr as $k=>$v)
            {
                if($v['temperature']>=-2000&&$v['temperature']<=-1000)
                    $blue++;
                else if($v['temperature']>=-1000&&$v['temperature']<=0)
                    $green++;
                else if($v['temperature']>=0&&$v['temperature']<=500)
                    $purple++;
                else if($v['temperature']>=500&&$v['temperature']<=1000)
                    $yellow++;
                else if($v['temperature']>=1000&&$v['temperature']<=2000)
                    $orange++;
                else
                    $gray++;
            }
            $count=array(
                    '-2000~-1000'=>$blue,
                    '-1000~0'=>$green,
                    '0~500'=>$purple,
                    '500~1000'=>$yellow,
                    '1000~2000'=>$orange,
                    'else'=>$gray
                );
            return $count;
        }
}