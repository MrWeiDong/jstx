$(function () {
    var datenow = new Date();
    var $nowMonth = datenow.getMonth() + 1;  //当前月  
    var $year = datenow.getFullYear(); //年
    var $day=datenow.getDate();

    var date1 = new Date($year, $nowMonth, 0);//获取当前月的第一天的日期
    var $lastDate1 = date1.getDate();

    GetCalendar($year, $nowMonth,$day);

  // GetCalendar(2019,6,27);

    $("#prev").on("click", function () { 
        $day=parseInt($day)-7;
        if($day<0)  //小于第一天
        {
            $nowMonth=$nowMonth-1;
            $day=$lastDate1+$day;
        }
        GetCalendar($year, $nowMonth,$day);
    });
    $("#next").on("click", function () {
        $day=parseInt($day)+7;
        if($day>$lastDate1)  //大于最后一天
        {
            $nowMonth=$nowMonth+1;
            $day=$day - $lastDate1;
        }
        GetCalendar($year, $nowMonth,$day);
    });
});

function Getweek(year, month, day)
{
   
    // var date0 = new Date(year, month, day);
    var date0 = new Date(year+"-"+month+"-"+day);
    
    var week0 = date0.getDay();
    console.log(year+"-"+month+"-"+day);
    console.log(week0);

    switch(week0) {
        case 1:
            return "周一";
            break;
        case 2:
            return "周二";
            break;
        case 3:
            return "周三";
            break;
        case 4:
            return "周四";
            break;
        case 5:
            return "周五";
            break;
        case 6:
            return "周六";
            break;
           
        case 0:
            return "周日";
            break;
        default:
            break;
    }  
   
}

function GetCalendar(year,month,day){
    var date = new Date(year, month, 0);
    var $lastDate = date.getDate();
    // var $preMonth = parseInt(month) - 1;
    // var $nextMonth = parseInt(month)+ 1;
    // var nowDate = new Date();
    // var peryear = year;
    // // 获取当天日期
    // var todayDate = new Date();        
    // var today = todayDate.getDate();
    // var nowYear = todayDate.getFullYear();
    // var nowMonth = todayDate.getMonth()+1;

 

   // var preDays = new Date(nowYear, $preMonth, 0).getDate();  //上个月最大数

    var $html = "";
   

    $html += "<tr><th width='12.5%' class='calender_cate'>时间/日期</th>";
    var $weekhtml = "";
    $weekhtml = year + "." + month + "." + day + " - "
   
    for (var i = 0; i < 7; i++) {
        
        if (day > $lastDate){    //日期大于本月最大数
            month =parseInt(month) + 1;
            day=day-$lastDate; 
        }
  
        console.log(year+"-"+month+"-"+day);
        var week = Getweek(year,month,day);  //周几

        $html += "<th width='12.5%'>" + month + "." + day + "(" + week + ")</th>";
        day = day+1;
    }
    $html += "</tr>";

  
    $weekhtml += year + "." + month + "." + day;

    
    $("#wp-calendar").find("thead").html($html);
    $("#now-week").html($weekhtml);
   
}