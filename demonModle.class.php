<?php
/**
 * @Author: Lheyue
 * @Date:   2017-04-08 20:00:51
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-30 20:40:53
 */
         require'./MySQLDB.class.php';

  class demonModle
    {
        protected $link=null;
        public  $flag_show;
        function get_date_range($msg)//得到用户输入的区间信息，并进行标准化（加0）
            {
                $msg=array(//不可以放在类里，只能放在类的函数里。
                'year_top' => $_POST['year_top'],
                'month_top' => $_POST['month_top'],
                'day_top' => $_POST['day_top'],
                'year_rear' => $_POST['year_rear'],
                'month_rear' => $_POST['month_rear'],
                'day_rear' => $_POST['day_rear']
                );

                $year_top = $msg['year_top'];
                $month_top = $msg['month_top'];
                $day_top = $msg['day_top'];
                $year_rear = $msg['year_rear'];
                $month_rear = $msg['month_rear'];
                $day_rear = $msg['day_rear'];
                if(strlen("{$msg['month_rear']}")<2)//补回0方便判断范围
               {
                $month_rear='0'.$msg['month_rear'];
               }

               if(strlen("{$msg['day_rear']}")<2)
               {
                $day_rear='0'.$msg['day_rear'];
               }
                if(strlen("{$msg['month_top']}")<2)
               {
                $month_top='0'.$msg['month_top'];
               }
               if(strlen("{$msg['day_top']}")<2)
               {
                $day_top='0'.$msg['day_top'];
               }


               $rear_time=$year_rear.$month_rear.$day_rear;
               $top_time=$year_top.$month_top.$day_top;

               $result = array(
                        'rear_time' => $rear_time,
                        'top_time' => $top_time,
                        'day_rear' => $day_rear,
                        'month_rear' => $month_rear,
                        'year_rear' =>$year_rear,
                        'day_top' =>$day_top,
                        'month_top' =>$month_top,
                        'year_top' =>$year_top,
                    );
               return $result;

            }
            function display_range($data_range)//显示选择的日期范围
            {
               if($data_range['year_rear']&&$data_range['year_top'])
                     {
                          $ranges = $data_range['year_rear']."年".$data_range['month_rear']."月".$data_range['day_rear']."日"."至".$data_range['year_top']."年".$data_range['month_top']."月".$data_range['day_top']."日";
                         // echo $_POST['sort_by'];
                          $this->flag_show=1;
                    }
                    else
                        {
                            $ranges="未输入有效区间，请重新检查输入";
                            $this->flag_show=null;
                        }
                        $arr=array($ranges,$this->flag_show);
                        //echo "flag_show=".$this->flag_show;
                        //var_dump($arr);
                        return $arr;
            }
            function get_data_in_range($sql)//得到数据库操作的结果
            {
                $config=array(
                    'host'=>'localhost',
                    'port'=>'3306',
                    'user'=>'root',
                    'pass' => '',
                    'charset' => 'utf8',
                    'dbname' => 'trdb'
                  );
                $this->link=MySQLDB::GetInstance($config);//单例函数,应该是利用构造方法连接数据库。

                return $this->link->GetRows($sql);
            }

            function display_msg($res,$data_range,$c,$flag_show)//右边显示
            {
                $arr=array();
                $i=0;
                $min=99999999999999999;
                $max=-99999999999;
                $max_msg='';//最大温度的日期信息
                $min_msg='';
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
                  if($c=='demon')
                  {
                    $arri=array(
                        $i=>array(
                              'date'=>$v['date'],
                              'temperature'=>$v['temperature']
                          ),
                     );
                    $i++;
                    $arr=array_merge($arr, $arri);//追加数组
                  }
                    //change.php用到的代码
                    if($c=='change')
                    {
                     $string_x.=',"'.$v['date'].'"';//把数据连接成字符串，用来调chart.js
                     $string_y.=','.$v['temperature'];//不用引号，用了出错
                        if($v['temperature']>$max)
                        {
                            $max=$v['temperature'];
                            $max_msg=$v['date'];
                        }
                        if($v['temperature']<$min)
                        {
                            $min=$v['temperature'];
                            $min_msg=$v['date'];
                        }
                    }
               }
              }

               if($c=='change')
               {
                        $string_x=substr($string_x,1);//去掉第一个字符
                        $string_y=substr($string_y,1);//去掉第一个字符
                           $arr=array(
                              'string_x' => $string_x,
                              'string_y' => $string_y,
                              'max'=> $max,
                              'min' => $min,
                              'max_msg' => $max_msg,
                              'min_msg' => $min_msg,
                            );
                }
              return $arr;
            }

    }

 ?>