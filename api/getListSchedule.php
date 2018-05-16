<?php
include_once("../includes/gfconfig.php");
include_once("../includes/gfinnit.php");
include_once("../includes/gffunction.php");
include_once("../libs/cls.mysql.php"); 
include_once("../libs/cls.meet.php");
$objMeet = new CLS_MEET;
$postData = file_get_contents("php://input");
$JSON = json_decode($postData, true);

if (isset($JSON['mem_id'])) {
	$memId = $JSON['mem_id'];
	$objMeet->getList(" and mem_id='".$memId."'","");
	$currentTime = strtotime(date('d-m-Y'));
	$data = "";
	while($rs=$objMeet->Fetch_Assoc()) {
		$id = $rs['id'];
		$mem_id = $rs['mem_id'];
		$customer_id = $rs['customer_id'];
		$content = $rs['content'];

		if ($rs['status'] == STATUS_COMPLETE) {
			$status = "Thành công";
		} else if ($rs['status'] == STATUS_FAILED) {
			$status = "Thất bại";
		} else if ($rs['status'] == STATUS_CANCEL) {
			$status = "Hủy bỏ";
		} else {
			$status = "Sắp diễn ra";
		}
		
		$type = $rs['type'];
		if ($rs['type'] == "tang_qua") {
			$type = "Tặng quà";
		} else if ($rs['type'] == "hop_hanh") {
			$type = "Họp hành";
		} else if ($rs['type'] == "dam_hieu") {
			$type = "Đám hiếu";
		} else if ($rs['type'] == "dam_hi") {
			$type = "Đám hỉ";
		} else if ($rs['type'] == "di_choi") {
			$type = "Đi chơi";
		} else if ($rs['type'] == "lien_hoan") {
			$type = "Liên hoan";
		} else {
			$type = "Gặp mặt";
		}

		$datetime = date("d-m-Y", strtotime($rs['datetime']));
		$address = $rs['address'];
		$image = $rs['image'];
		$result = $rs['result'];
		$next_content = $rs['next_content'];
		$note = $rs['note'];
		$warning = "";
		if (strtotime($rs['datetime']) < $currentTime) {
			$warning = "outdate";
		} else {
			$warning = "processing";
		}


		$data.= "{
				\"mem_id\":\"$mem_id\", 
				\"content\": {
					\"id\":\"$id\",	
					\"customer_id\":\"$customer_id\",
					\"content\":\"$content\",
					\"status\":\"$status\",
					\"datetime\":\"$datetime\",
					\"type\":\"$type\",
					\"address\":\"$address\",
					\"image\":\"$image\",
					\"result\":\"$result\",
					\"next_content\":\"$next_content\",
					\"note\":\"$note\",
					\"warning\":\"$warning\"
					}
				},";
	}

	$data = "[".substr($data, 0, strlen($data)-1)."]";	
	echo $data;
}

// Trang thai
// <option value="st_waiting">Sắp diễn ra</option>
// <option value="st_complete">Thành công</option>
// <option value="st_cancel">Hủy bỏ</option>
// <option value="st_faile">Thất bại</option>

// Type schedule
// <option value="tang_qua">Tặng quà</option>
// <option value="hop_hanh">Họp hành</option>
// <option value="dam_hieu">Đám hiếu</option>
// <option value="dam_hi">Đám hỉ</option>
// <option value="di_choi">Đi chơi</option>
// <option value="lien_hoan">Liên hoan</option>
// <option value="gap_mat">Gặp mặt</option>

?>