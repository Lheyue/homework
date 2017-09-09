<!--
/**
 * @Author: Lheyue
 * @Date:   2017-03-04 15:08:17
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-05-30 19:36:35
 */-->

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>物联网信息处理</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" >
    <style type="text/css" >


    </style>
</head>

<body>
 <?php
        require("include/config.php");
        $link=mysqli_connect(hostname, username, password, database)or die("连接数据库失败");
        mysqli_set_charset($link,'utf8');

       function find_data($data,$str_locate,$length)//find_data这个函数是用来截取需要的字符串的，第一个参数是要截取的字符串，第二个参数是用来定位的字符串，第三个是控制要截取几位。
          {
            $num=strlen($str_locate);
            if($short_str=strstr($data,$str_locate))//strstr函数搜索字符串在另一字符串中的第一次出现.echo strstr("I love Shanghai!","love");结果为love Shanghai!
            {
                $str=substr($short_str,$num,$length);//str中第num个开始，取length个
                return $str;
            }

          }
        $file_name="1901.txt";
        $file_save_name="save.txt";


            $handle=fopen($file_name,"r")or die("打开数据文件失败");
            $handle_save=fopen($file_save_name,"w")or die("打开保存文件失败");
    if($handle)
    {
        while (!feof($handle))
        {
            $str=fgets($handle);//从 file 指向的文件中读取一行并返回长度最多为 length - 1 字节的字符串。碰到换行符（包括在返回值中）、EOF 或者已经读取了 length - 1 字节后停止（要看先碰到那一种情况）。如果没有指定 length，则默认为 1K，或者说 1024 字节。
           $date=find_data($str,"99999",10);//找到99999截取10位取到日期信息
           //echo $date;
           $tem_data=find_data($str,"N0000001N9",6);//找到N0000001N9截取6位取到温度信息
           //下面分别单独取到日期信息中的年月日和时间。
           $year=substr($date,0,4);
           $month=substr($date,4,2);
           $day=substr($date,6,2);
           $hour=substr($date,8,2);

           settype($year,"int");
           settype($month,"int");
           settype($day,"int");
           settype($hour,"int");
           settype($tem_data,"int");
          //类型强制转换，避免用到‘-’时自动变成减法运算
           settype($year,"string");
           settype($month,"string");
           settype($day,"string");
           settype($hour,"string");
           //把需要的信息按照格式拼接在一起。
           $final_date=$year.'-'.$month.'-'.$day.'-'.$hour;
           $data='('.$year.','.$month.','.$day.','.$hour.','.$tem_data.")\r\n";
          static $item_data='';
          //文件中用‘（）’把要保存的信息作出简单的分割
          $item_data=$item_data.",('".$final_date."',".$tem_data.')';//外部不能有引号,变量也不能有引号

          //写文件
          fwrite($handle_save,($data."\n"));
       // }
      }
        fclose($handle);
        fclose($handle_save);
    }
      $item_data=substr($item_data,1);//去掉,

      //session_start();
      //$_SESSION['flag']=1;

      //*
          $sql="insert into tempt (date,temperature) values $item_data;";
        //  if($_SESSION['flag'])
       // {
          mysqli_query($link,$sql);
          //echo "执行";
       // }
      //*/
     // echo $sql;
    if(mysqli_affected_rows($link))//判断是否影响函数的行数
                  {
                      echo "数据插入成功";
                    //  $_SESSION['flag']=0;
                  }
                  else{
                     echo "数据插入失败或已经插入过数据";
                  }

                  //echo $_SESSION['flag'];

   // echo $num;
   /*显示

           $sql="select * from tempt;";
           $res=mysqli_query($link,$sql);


            echo "<table >";
             echo "<tr>";
           ?>         <td class="l_td">
            <?php        echo "date";
                    echo "</td>";

                    echo "<td>";
                    echo "temperature";
                    echo "</td>";
                echo "</tr>";
           while($list=mysqli_fetch_assoc($res))
            {
                echo "<tr>";
                    echo "<td>";
                    echo "{$list['date']}";
                    echo "</td>";

                    echo "<td>";
                    echo "{$list['temperature']}";
                    echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            //*/
?>

</body>
</html>
