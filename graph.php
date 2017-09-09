
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>线形图</title>
    <link rel="stylesheet" href="">
     <script src="./Chart/js/Chart.js" type="text/javascript" charset="utf-8"></script>
     <script src="./Chart/js/jquery.js" type="text/javascript" charset="utf-8"></script>
</head>
 <body>
       <span style="font-size:18px;">
        <?php
//数据库配置
$dbconf= array(
        'host'=>'127.0.0.1',
        'user'=>'root',
        'password'=>'123456',//因为测试，我就不设置密码，实际开发中，必须建立新的用户并设置密码
        'dbName'=>'exercisedata',
        'charSet'=>'utf8',
        'port'=>'3306' );
function openDb($dbConf){
   $conn=mysqli_connect($dbConf['host'],$dbConf['user'],$dbConf['password'],$dbConf['dbName'],$dbConf['port']) or die('打开失败');
    //当然如上面不填写数据库也可通过mysqli_select($conn,$dbConf['dbName'])来选择数据库
    mysqli_set_charset($conn,$dbConf['charSet']);//设置编码
    return $conn;
}
$conn=openDb($dbconf);
//2query方法执行增、查、删、改
$sql='SELECT userName as `label`, score as `value` FROM exercisedata.users';
/*************数据查询***************************/
$rs=$conn->query($sql);

$data=array();//保存数据
while($tmp=mysqli_fetch_assoc($rs)){//每次从结果集中取出一行数据
    $data[]=$tmp;
}
//对数据进行相应的操作
 echo  json_encode($data);
 ?>
 </span>

<<script>
             window.onload=function()
{
     getdatafromDB();
}

var getdatafromDB = function(){
    $.ajax({
        url: "../php/index.php",
        type: "POST",
        dataType:"json",
         error: function(){
             alert('Error loading XML document');
         },
        success:function(data){
            console.info(data);
             bar(data);
        }
    });
}
function bar(Data)
{
    if(Data.length==null || Data.length == 0)
        return;
    var barData={};
    barData.labels=[];
    barData.datasets=[];
    var temData={};
    temData.data=[];
    temData.fillColor= "rgba(151,187,205,0.5)";
    temData.strokeColor = "rgba(151,187,205,0.8)";
    temData.highlightFill="rgba(151,187,205,0.75)",
    temData.highlightStroke= "rgba(151,187,205,1)";

    for(var i=0;i<Data.length;i++)
    {
        barData.labels.push(Data[i].label);
        temData.data.push(Data[i].value);
    }
    barData.datasets.push(temData); //封装一个规定格式的barData。
    console.info(barData);
    /     /// 动画效果
    var options = {
        scaleOverlay: false,
        scaleOverride: false,
        scaleSteps: null,
        scaleStepWidth: null,
        scaleStartValue: null,
        scaleLineColor: "rgba(0,0,0,.1)",
        scaleLineWidth: 1,
        scaleShowLabels: true,
        scaleLabel: "<%=value%>",
        scaleFontFamily: "'Arial'",
        scaleFontSize: 12,
        scaleFontStyle: "normal",
        scaleFontColor: "#666",
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        bezierCurve: true,
        pointDot: true,
        pointDotRadius: 3,
        pointDotStrokeWidth: 1,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        animation: true,
        animationSteps: 60,
        animationEasing: "easeOutQuart",
        onAnimationComplete: null
    }
    var ctx  = document.getElementById("myChart").getContext('2d');
    myChart = new Chart(ctx).Bar(barData,options, { //重点在这里
        responsive : true
    });
}
</script>







    </body>
</html>
<?php
/**
 * @Author: Lheyue
 * @Date:   2017-03-26 17:51:01
 * @Last Modified by:   Lheyue
 * @Last Modified time: 2017-03-28 11:03:56
 */
