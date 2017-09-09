 <?php
/**
 * @Author: Lheyue
 * @Date:   2017-03-12 13:43:42
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-12 14:48:20
 */


    require'./text_6Model.class.php';
    $infomation = new text_6Model($msg);
    $data_range=$infomation->get_date_range($msg);//返回一个存有处理后日期信息的数组
    $flags=$infomation->display_range($data_range);//flags存有输入的的日期信息和用来控制回显的flag_show


?>

<!DOCTYPE html>
<html>
<head>
    <title>sy6</title>
    <link rel="stylesheet" href="css/style.css" >
    <script type="text/javascript" src="chart/js/Chart.min.js"></script>
    <style type="text/css">

    </style>
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
                    <span class="text1">被选择的日期区间为：</span><br />
                    <p class='text2' >
                <?php

                     echo $flags['0'];//显示日期范围信息
                ?>
                    </p>
                </div>
        </div>
    </div>

    <div class="div_right">

        <?php
          $sql="select * from tempt;";
          $res=$infomation->get_data_in_range($sql);
           //var_dump($res);
          $arr=$infomation->display_msg($res,$data_range,'demon',$flags[1]);//找到符合条件的信息
           // var_dump($arr);
           $count=$infomation->count_temp($arr);
           // var_dump($count);
        ?>
        <div class='notes'>
            <div><div class='element' style="background:#cdecff"></div>-2000~-1000</div>
            <div><div class='element' style="background:#beefd2"></div>-1000~0</div>
            <div><div class='element' style="background:#ffddfb"></div>0~500</div>
            <div><div class='element' style="background:#fff5bc"></div>500~1000</div>
            <div><div class='element' style="background:#fcc79e"></div>1000~2000</div>
            <div><div class='element' style="background:gray"></div>else</div>
        </div>
        <canvas id="canvas" height="450" width="600"></canvas>
        <script type="text/javascript">
            var ctx = new Chart(document.getElementById("canvas").getContext("2d"));
            var options = {scaleFontSize: 13, scaleFontColor: "#ffa45e"};
             var pieChart = [
                    {value: <?php echo $count['-2000~-1000']; ?>, color: "#cdecff"},
                    {value:  <?php  echo $count['-1000~0']; ?>, color: "#beefd2"},
                    {value: <?php  echo $count['0~500']; ?>, color: "#ffddfb"},
                    {value: <?php  echo $count['500~1000']; ?>, color: "#fff5bc"},
                    {value: <?php  echo $count['1000~2000']; ?>, color: "#fcc79e"},
                    {value: <?php  echo $count['else']; ?>, color: "gray"},
                ];
            var myPieChart = ctx.Pie(pieChart);
            </script>

    </div>
    </div>
  <div class="div_clear">

  </div>
</body>
</html>

