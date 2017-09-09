 <?php
/**
 * @Author: Lheyue
 * @Date:   2017-03-12 13:43:42
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-09 16:26:26
 */

    require'./demonModle.class.php';
    $infomation = new demonModle;
    $data_range=$infomation->get_date_range($msg);//返回一个存有处理后日期信息的数组
    $flags=$infomation->display_range($data_range);//flags存有输入的的日期信息和用来控制回显的flag_show

?>

<!DOCTYPE html>
<html>
<head>
    <title>sy4</title>
    <link rel="stylesheet" href="css/style.css" >

     <script src="./Chart/js/Chart.js" type="text/javascript" charset="utf-8"></script>
</head>
<body class="body_style">
<div class="div_head">
</div>
<div class="div_body">
    <div class="div_left">
        <div class="div_sort" >
                <br />
              <h2 class="h2_sort">请输入查询区间:</h2>
               <form name="select" action="" method="post">
                      <input class="input_sort" type="text" name="year_rear" value= '<?php if($flags[1]) echo $data_range['year_rear']; ?>' />年
                    <input class="input_sort" type="text" name="month_rear" value= '<?php if($flags[1]) echo $data_range['month_rear']; ?>' />月
                    <input class="input_sort" type="text" name="day_rear" value= '<?php if($flags[1]) echo $data_range['day_rear']; ?>' />日<br />
                    <input class="input_sort" type="text" name="year_top" value= '<?php if($flags[1]) echo $data_range['year_top']; ?>' />年
                    <input class="input_sort" type="text" name="month_top" value= '<?php if($flags[1]) echo $data_range['month_top']; ?>'  />月
                    <input class="input_sort" type="text" name="day_top" value= '<?php if($flags[1]) echo $data_range['day_top']; ?>' />日


                    <br /><br />


                    <div class="submit_type" >
                        <input type="submit" class='button_sort' value="提交" />&nbsp
                    </div>

                </form>
                <br /><br /><br /><br /><br />
                <div class="display_time_rear" >
                    <span class="text1">被选择的区间为：</span><br />
                    <p class='text2' >
      <?php
          echo $flags['0'];//显示日期范围信息

          $sql="select * from tempt;";

          $res=$infomation->get_data_in_range($sql);

          // var_dump($res);

          // $ch='demon';
          $infomation->display_msg($res,$data_range,'demon',$flags[1]);//找到符合条件的信息
          // $ch='change';
          //var_dump($arr);//取出来了
          $infomation_string=new demonModle;
          $string_xy=$infomation_string->display_msg($res,$data_range,'change',$flags[1]);//用来记录chart.js的坐标信息和最大最小值
          //var_dump($string_xy);
         /*echo "x:".$string_xy['string_x'];
          echo "<br />";
          echo "y:".$string_xy['string_y'];*/

               $infomation->display_range($data_range);//日期范围信息
              echo "<br />";echo "<br />";echo "<br />";
             // echo "<p class='msg'>";
                if($string_xy['max']!=-99999999999)
                {
                  echo "最大温度的日期为". $string_xy['max_msg']." ,温度为".$string_xy['max'].' ';
                  echo "<br />";
                  echo "最低温度的日期为".$string_xy['min_msg']." ,温度为".$string_xy['min'];
                 // echo $string_xy['string_x'];
                  // echo $string_xy['string_y'];
                 // echo "</p>";
                }
      ?>
                    </p>
                </div>
        </div>
    </div>

    <div class="div_right">
      <?php


      ?>
     <canvas id="myChart" class="my_chart" height="530" width="800"></canvas>
        <script type="text/javascript">
             var ctx  = document.getElementById("myChart").getContext('2d');
            var options = {scaleFontSize: 13, scaleFontColor: "#ffa45e"};//动画效果?

            var ctx = new Chart(document.getElementById("myChart").getContext("2d"));
            var options = {scaleFontSize: 13, scaleFontColor: "#ffa45e"};

            // 线型图
            var LineChart = {
                labels: [<?php echo $string_xy['string_x']; ?>],
                // labels: ["Ruby", "jQuery", "Java", "ASP.Net", "PHP"],
                datasets: [{
                    fillColor: "rgba(252,147,65,0.5)",
                    strokeColor: "rgba(255,255,255,1)",
                    pointColor: "rgba(173,173,173,1)",
                    pointStrokeColor: "#fff",

                   data: [<?php echo $string_xy['string_y']; ?>]
                    // data: [221, 20, 30, 40, -111]
                    }]
            };
            var myLineChart = ctx.Line(LineChart, options);


        </script>

    </div>
    </div>
  <div class="div_clear">

  </div>
</body>
</html>

