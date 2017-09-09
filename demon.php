 <?php
/**
 * @Author: Lheyue
 * @Date:   2017-03-12 13:43:42
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-09 16:25:26
 */


    require'./demonModle.class.php';
    $infomation = new demonModle($msg);
    $data_range=$infomation->get_date_range($msg);//返回一个存有处理后日期信息的数组
    $flags=$infomation->display_range($data_range);//flags存有输入的的日期信息和用来控制回显的flag_show

?>

<!DOCTYPE html>
<html>
<head>
    <title>sy3</title>
    <link rel="stylesheet" href="css/style.css" >
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
                 <p class="font_left">按照温度的

                        <select name="sort_by" class="select_sty">

                    <option value="asc">升序</option><!--value内的值尽量简单，能够节省空间,用12345也是可以的,减小对服务器的影响-->
                    <option value="desc">降序</option>
                    <option value="normal">无序</option>


                </select>
                    排列
                    </p>

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
                ?>
                    </p>
                </div>
        </div>
    </div>

    <div class="div_right">
   <?php
          if($_POST['sort_by']=='asc')
            $sql="select * from tempt order by temperature asc;";
        else if($_POST['sort_by']=='desc')
            $sql="select * from tempt order by temperature desc;";
          else if($_POST['sort_by']=='normal')
            $sql="select * from tempt;";


          // echo $record_sql;
          $res=$infomation->get_data_in_range($sql);
          // var_dump($res);
?>
        <table class='table_sork'>
          <tr >
            <td class='l_td'>
              <?php echo "date";  ?>
            </td>
            <td>
              <?php echo "temperature"; ?>
            </td>
          </tr>

  <?php

    $arr=$infomation->display_msg($res,$data_range,'demon',$flags[1]);//要显示在table中的信息
    // var_dump($arr);

          foreach($arr as $k=>$v)
              {

                echo "<tr>";
                    echo "<td>";
                echo "{$v['date']}";
                   echo "</td>";


                    echo "<td>";
                    echo "{$v['temperature']}";
                    echo "</td>";
                echo "</tr>";
               }
               echo "</table>";
?>

    </div>
    </div>
  <div class="div_clear">

  </div>
</body>
</html>

