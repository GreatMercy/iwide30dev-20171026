<?php
//http://localhost/iwide/iwide3_0/libraries/BaseApi/testApi.php
include_once 'Super8Webservice.php';
//问题：传来的数量，要不要跟可用房数量进行比较作业务判断


$suba = new Super8Webservice(false);


$suba->local_test = true;

//$suba->Register("测试007", '123456', '13560428181');

//$suba->login("13560428181", '123456');

//$suba->GetCustomer("303503093");

//$suba->ModifyCustomer("303503093",'测试008','13560428181');

//$suba->ChangePassword("303503093",'123456','abc123');
//$suba->ChangePassword("303503093",'123456','abc123');
//$suba->Register("测试007", '123456', '13560428199');

//$suba->login("13560428199", '123456');

//$suba->GetCoupons('303503090');
//$suba->
//$suba->login("13560428189", '123456');
//$suba->Register("测试008", '123456', '13560428189');
//$suba->GetPoints('305893509');
//$suba->GetCustomer('305893509');
//$suba->GetHotels('110100', '2016-04-27', '2016-04-28');
//$suba->GetHotelRooms('628', '2016-04-27', '2016-04-29', 1);
//$suba->GetOrder('32495716');

//$suba->CheckMemberStatus('13560428194');

//32495726 这一张单3间房，都确认入住
//32495727 这一张单2间房，取消1间房
//32495728 这一张单是1间房，取消1间房
//32495729 这一张单是2间房，取消2间房
//32495730 这一张单是2间房，取消1间房2016-04-28那一间夜
//$suba->GetOrder('32495730');
//$suba->SendVerifySMS('13560428194', "");
//206344
//$suba->ForgetPassword('13560428194', "111111",'206344');
//$suba->login("13560428184", '123456');
//$suba->GetHotelRooms('629', '2016-04-27', '2016-04-29', 1);
$suba->GetAccounts('305893509', 101);
?>