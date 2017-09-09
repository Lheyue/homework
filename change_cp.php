
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>线形图</title>
    <link rel="stylesheet" href="./css/change_style.css">
     <script src="./Chart/js/Chart.js" type="text/javascript" charset="utf-8"></script>
     <script src="./Chart/js/jquery.js" type="text/javascript" charset="utf-8"></script>
</head>
 <body>
    <div class="div_head">
    </div>
    <div class="div_body">
        <div class="div_left" >
                <br />
              <h2 class="h2_sort">请输入查询区间:</h2>
               <form name="select" action="" method="post">
                    <input class="input_sort" type="text" name="year_rear" value= '<?php echo $_POST['year_rear']; ?>' />年
                    <input class="input_sort" type="text" name="month_rear" value= '<?php echo $_POST['month_rear']; ?>' />月
                    <input class="input_sort" type="text" name="day_rear" value= '<?php echo $_POST['day_rear']; ?>' />日<br />
                    <input class="input_sort" type="text" name="year_top" value= '<?php echo $_POST['year_top']; ?>' />年
                    <input class="input_sort" type="text" name="month_top" value= '<?php echo $_POST['month_top']; ?>'  />月
                    <input class="input_sort" type="text" name="day_top" value= '<?php echo $_POST['day_top']; ?>' />日




                    <div class="submit_type" >
                        <input type="submit" class='button_sort' value="提交" />&nbsp
                    </div>

                </form>
                <br />

        <?php
                $year_top=$_POST['year_top'];
                $month_top=$_POST['month_top'];
                $day_top=$_POST['day_top'];
                $year_rear=$_POST['year_rear'];
                $month_rear=$_POST['month_rear'];
                $day_rear=$_POST['day_rear'];



                 if(strlen($month_rear)<2)
               {
                $month_rear='0'.$month_rear;
               }
               if(strlen($day_rear)<2)
               {
                $day_rear='0'.$day_rear;
               }
                if(strlen($month_top)<2)
               {
                $month_top='0'.$month_top;
               }
               if(strlen($day_top)<2)
               {
                $day_top='0'.$day_top;
               }


               $rear_time=$year_rear.$month_rear.$day_rear;
               $top_time=$year_top.$month_top.$day_top;
              // echo $rear_time.'<br />';
              // echo $top_time;

 ?>
                <br /><br /><br /><br />
                <div class="display_time_rear" >
                    <span class="text1">被选择的区间为：</span><br />
                    <p class='text2' >
            <?php        if($year_rear&&$year_top)
                     {
                          echo $year_rear."年".$month_rear."月".$day_rear."日" ;
                          echo "至";
                          echo $year_top."年".$month_top."月".$day_top."日";
                         // echo $_POST['sort_by'];
                          $flag_show=1;




                    }
                    else
                        {
                            echo "未输入有效区间，请重新检查输入";
                            $flag_show=null;
                        }
                    ?>
                    </p>
                </div>
        </div>

<?php
/**
 * @Author: Lheyue
 * @Date:   2017-03-26 17:51:01
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-04-02 12:14:54
 */
        require("./include/config.php");
        $link=mysqli_connect(hostname,username,password,database)or die("连接数据库失败！");
        mysqli_set_charset($link,'utf8');
        $sql="select * from tempt;";

        $res=mysqli_query($link,$sql);
         $graph_date=array();//确认初始化没放在循环里T_T
         $min=99999999999;
         $max=-99999999999;
         $max_msg='';
         $min_msg='';

         while($list=mysqli_fetch_assoc($res))
            {



            $data=$list['date'];
            $year=substr($data,0,4);
            $data=str_replace($year.'-','',$data);//str_replace把字符串3中的1替换成2
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

                if($rear_time<=$true_time&&$top_time>=$true_time&&$flag_show)
               {
                   //echo "{$list['date']}";
                   //echo "{$list['temperature']}";
                    //$graph_date[$list['date']]=$list['temperature'];
                    $string_x.=',"'.$list['date'].'"';//把数据连接成字符串，用来调chart.js
                    $string_y.=','.$list['temperature'];//不用引号，用了出错
                        if($list['temperature']>$max)
                        {
                            $max=$list['temperature'];
                            $max_msg=$list['date'];
                        }
                        if($list['temperature']<$min)
                        {
                            $min=$list['temperature'];
                            $min_msg=$list['date'];
                        }

                //*/

               }

            }
            //var_dump($graph_date);
            $string_x=substr($string_x,1);//去掉第一个字符
            $string_y=substr($string_y,1);//去掉第一个字符
            //echo $string_x;

            //echo $string_y;

?>

<!-------------------------------------------------------------------------------------->

    <div class="div_right">
            <p class='msg'>
            <?php  echo "<br />";
                          echo "最大温度的日期为". $max_msg." ,温度为".$max.' ';

                          echo "最低温度的日期为".$min_msg." ,温度为".$min;
            ?>
            </p>
        <canvas id="myChart" height="530" width="900"></canvas>
        <script type="text/javascript">
             var ctx  = document.getElementById("myChart").getContext('2d');
            var options = {scaleFontSize: 13, scaleFontColor: "#ffa45e"};//动画效果?

            var ctx = new Chart(document.getElementById("myChart").getContext("2d"));
            var options = {scaleFontSize: 13, scaleFontColor: "#ffa45e"};

            // 线型图
            var LineChart = {
                labels: [<?php echo $string_x; ?>],
                //labels: ["Ruby", "jQuery", "Java", "ASP.Net", "PHP"],
                datasets: [{
                    fillColor: "rgba(252,147,65,0.5)",
                    strokeColor: "rgba(255,255,255,1)",
                    pointColor: "rgba(173,173,173,1)",
                    pointStrokeColor: "#fff",
                   data: [<?php echo $string_y; ?>]
                    //data: [221, 20, 30, 40, -111]
                    }]
            };
            var myLineChart = ctx.Line(LineChart, options);


        </script>
    </div>
    </div>


    </body>
</html>
