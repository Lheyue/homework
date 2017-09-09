<?php
/**
 * @Author: Lheyue
 * @Date:   2017-05-02 14:45:46
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-09 14:28:58
 */
require'./demonModle.class.php';
class specificModle extends demonModle{

    function get_temp_range($temp_msg)
    {
        if($temp_msg&&$temp_msg['rear']<=$temp_msg['top'])
        {
            return $temp_msg;
        }
    }
    function display_msg($res,$data_range,$temp_range,$flag_show)
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
                    if($temp_range['rear']<=$v['temperature']&&$temp_range['top']>=$v['temperature'])
                      $color='blue';
                    else
                    $color=null;
                    $arri=array(
                        $i=>array(
                              'date'=>$v['date'],
                              'temperature'=>$v['temperature'],
                              'color'=>$color
                          ),
                     );
                    $i++;
              $arr=array_merge($arr, $arri);//追加数组
               }

              }
              return $arr;


    }

}