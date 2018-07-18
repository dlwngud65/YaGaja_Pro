<?php 

include '../../common_lib/createLink_db.php';
include './create_seat_state.php';

session_start();

 if(!empty($_SESSION['id'])){
    $id = $_SESSION['id'];
}else{
    $id = "?";
}

 if(!empty($_GET['fly'])){
    $fly = $_GET['fly'];
}else{
    $fly = "?";
} 

if(!empty($_GET['start_check'])){
    $start_check = $_GET['start_check'];
}else{
    $start_check = "?";
}
if(!empty($_GET['back_check'])){
    $back_check = $_GET['back_check'];
}else{
    $back_check = "?";
}
if(!empty($_GET['start'])){
    $start = $_GET['start'];
}else{
    $start = "?";
}
if(!empty($_GET['back'])){
    $back = $_GET['back'];
}else{
    $back = "?";
}

if(!empty($_GET['anum'])){
    $anum = $_GET['anum'];
}else{
    $anum = "?";
}
if(!empty($_GET['bnum'])){
    $bnum = $_GET['bnum'];
}else{
    $bnum = "?";
}
if(!empty($_GET['cnum'])){
    $cnum = $_GET['cnum'];
}else{
    $cnum = "?";
}

if(!empty($_GET['start_flight_ap_num'])){
    $start_flight_ap_num = $_GET['start_flight_ap_num'];
}else{
    $start_flight_ap_num = "?";
}

if(!empty($_GET['back_flight_ap_num'])){
    $back_flight_ap_num = $_GET['back_flight_ap_num'];
}else{
    $back_flight_ap_num = "?";
}

$rs_cnt = $anum + $bnum +$cnum;     //총 인원

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link type="text/css" rel="stylesheet" href="../css/ticket1.css?v=3">
<link type="text/css" rel="stylesheet" href="../../common_css/index_css3.css?v=2">
<link rel="stylesheet" href="//code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
<form name="reserve_form" method="post">
<script type="text/javascript">
var num = <?=json_encode($rs_cnt)?>;
var count = 0;
function flight_next_page(){	
	alert('좌석배치되었습니다. 즐거운 여행 되세요');
	location.href="reserve.php";   
}

$(document).ready(function() {
	   $("button").click(function(){		//버튼 클릭시
		
	      var id = $(this).attr("id");		//id값 //value값 //class값
	      var value = $(this).attr("value");	
	      
	      
	      if(document.getElementById(id).style.backgroundColor == "white" && (count >= 0 && count <= num)){		//선택좌석이고 카운트가 0~3
	      	if(count == num){		//카운트 3이면
	      		if(document.getElementById(id).style.backgroundColor == "white"){		//선택좌석취소, 카운트 --
	      			document.getElementById(id).style.backgroundColor = ""; 
	      			count--;	//카운트 0이면
	      		}
	      	}
	      	document.getElementById(id).style.backgroundColor = ""; //선택해제
	      	 $.ajax({
  	            type : "post",
  	            url : "reserve.php",
  	            data : {value : value},
  	            
  	            error : function(){alert('통신실패2!!');},
  	            success : function(data){document.getElementById(value).remove();}
  	            });
	      	if(count != 0){	//카운트가 0이 아니면 카운트 --;	==선택해제 시 카운트 감소
	      		count--;
	      	}
	      }else if(document.getElementById(id).style.backgroundColor != "white" && (count >= 0 && count <= num)){	//선택좌석아니고 0~3일떄
	      	if(count == num){return;} //3개까지만 선택하도록
	      	document.getElementById(id).style.backgroundColor = "white"; 	//좌석선택시 색상
	      	if(count != num){count++;} //카운트가 3아 아니면 카운트 ++; == 맨처음클릭시 선택하면서 카운트 증가
	      	$.ajax({
                type : "post",
                url : "reserve.php",
                data : {value : value},		//네임 : 전달할 데이터() --- 여기서 value = $i
                error : function(){alert('통신실패1!!');},
                success : function(data){
                      $("#no").append("<li style='list-style:none; display:inline;' id='"+value+"'><input type='hidden' value='"+value+"' name='choice_seat[]'> "+value+"</li>") //li 태그는 value값이 없다함
                      }
                });   
	  		}
	   });
	});	      


function input_check(url){
	
	reserve_form.action = url;
    reserve_form.submit();  
	
}
</script>

</head>
<body>
<header>
<?php include_once '../../common_lib/top_login2.php';?>
</header>
<nav id="top">
<?php include_once '../../common_lib/main_menu2.php';?>
</nav><br><br><br><br>
<h1 style="margin:0 auto; text-align: center">FLIGHT TICKETING</h1><br>
<div id="ticket_box3">
<p>
<br><hr id="hr1"><br><br>
&nbsp;1. 여정 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
2. 항공편 선택  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
3. 결과 조회  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
4. 좌석 확인  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<p>
<table width=550 border=0 height=18 cellspacing=5 cellpadding=0>
<tr>
<?php
   echo "
        <td width='25%' bgcolor= '#dddddd'></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='#dddddd' height=5></td>
        <td width='25%' bgcolor='gray' height=5></td>";
?>
</tr>
</table><br>
<hr id="hr1">
<div id="select_ticket"><span style='font-size:15pt;'><br><br>좌석 배치</span>
<div style="text-align:right;">
<span style='font-size:12pt;'>예매불가 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt;background:#2478FF'>
<span style='font-size:12pt;'>예매가능 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt;'>
<span style='font-size:12pt;'>선택좌석 </span><input type='button' name='seat' value='' style='width:15pt;height:15pt;background:white'>&nbsp;&nbsp;
</div>
</div>

<img src="../image/ap_seat1.png" width='80%'>		<!-- 위  -->
<div id="seat_1"><br>

<?php 

for($i=1; $i<=100; $i++){
    
    echo "<button type='button' id='seat$i' class='seat' value='$i'>$i</button>";
    if($i== 13 || $i== 38 || $i== 63 || $i== 88){
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    
    
    if($i%50 == 0){
        echo "<br><br>";
    }
}

?>

</div><br>
<img src="../image/ap_seat2.png" style="width:80%; float:left;"> <!-- 아래  -->
<div id="seat_info" style="margin-top:-300px; margin-left:800px; float:none;">
<div id="select_ticket"><span style='font-size:15pt;'>좌석 정보</span><br><br><br></div>
<div>선택가능한 좌석수 : <?= $rs_cnt ?> 개</div>
선택한 좌석 번호 : 
<?php 
echo "<div id='no'></div>";

?>
</form>
</div>
<div style="text-align:center;">

<input type="button" id="select_ok"  style="width:100px; height:36px;" value="좌석 예약하기"
onclick="input_check('reserve.php?num=<?=$rs_cnt?>&fly=<?=$fly?>&start=<?=$start?>&back=<?=$back?>&start_check=<?=$start_check?>&back_check=<?=$back_check?>&sapnum=<?=$start_flight_ap_num?>&bapnum=<?=$back_flight_ap_num?>')">
</div>
</div>
<br><br><br><br>
<footer>
<?php include_once '../../common_lib/footer2.php';?>
</footer>
</body>
</html>




