<?php 
require dirname(dirname(__FILE__)) . '/include/reconfig.php';
require dirname(dirname(__FILE__)) . '/include/estate.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);

if($data['uid'] == '' or $data['img'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $uid =  $rstate->real_escape_string($data['uid']);
 $img = $data['img'];
 $img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$path = 'images/profile/'.uniqid().'.png';
$fname = dirname( dirname(__FILE__) ).'/'.$path;

file_put_contents($fname, $data);
 
 $table="tbl_user";
  $field = array('pro_pic'=>$path);
  $where = "where id=".$uid."";
$h = new Estate();
	  $check = $h->restateupdateData_Api($field,$table,$where);
	  $c = $rstate->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
 $returnArr = array("UserLogin"=>$c,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Profile Image Upload Successfully!!");
}
echo  json_encode($returnArr);
?>