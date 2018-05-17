<?php
// define path to dirs
	define('ROOTHOST','http://'.$_SERVER['HTTP_HOST'].'/customercare/');
	define('WEBSITE','http://'.$_SERVER['HTTP_HOST'].'/customercare/');

	define('DOMAIN',$_SERVER['HTTP_HOST']);
	define('BASEVIRTUAL0',ROOTHOST.'images/');
	define('ROOT_PATH',''); 
	define('TEM_PATH',ROOT_PATH.'templates/');
	define('COM_PATH',ROOT_PATH.'components/');
	define('MOD_PATH',ROOT_PATH.'modules/');
	define('LAG_PATH',ROOT_PATH.'languages/');
	define('EXT_PATH',ROOT_PATH.'extensions/');
	define('EDI_PATH',EXT_PATH.'editor/');
	define('DOC_PATH',ROOT_PATH.'documents/');
	define('DAT_PATH',ROOT_PATH.'databases/');
	define('IMG_PATH',ROOT_PATH.'images/');
	define('MED_PATH',ROOT_PATH.'media/');
	define('LIB_PATH',ROOT_PATH.'libs/');
	define('JSC_PATH',ROOT_PATH.'js/');
	define('LOG_PATH',ROOT_PATH.'logs/');
	define('API_PUBLIC',ROOTHOST.'/api/');
	
	define('WITHDRAW_DAY','01');
	define('WITHDRAW_MONTH','20');
	define('WITHDRAW_TIME','2100000');
	
	define('MAX_ROWS','50');
	define('MAX_ITEM','20'); // số bản ghi trên 1 trang
	define('LOGIN_TIME_OUT','60');
	define('URL_REWRITE','1');
	define('MAX_ROWS_INDEX',40);
	
	define('THUMB_WIDTH',285);
	define('THUMB_HEIGHT',285);
	
	$LANG_CODE='vi';
	
	define('SMTP_SERVER','smtp.gmail.com');
	define('SMTP_PORT','465');
	define('SMTP_USER','xxx@gmail.com');
	define('SMTP_PASS','xxx');
	define('SMTP_MAIL','xxx@gmail.com');
	define('IGF_LICENSE','xxx');
	
	define('SITE_NAME','');
	define('EMAIL_SUPPORT','gmail@gmail.com');
	define('SITE_TITLE','');
	define('SITE_DESC','');
	define('SITE_KEY','');
	define('COM_CONTACT','');

	// Permistion
	define('PER_SUPPERVISOR','1');
	define('PER_USER','2');	

	// Defined category
	define('CAT_TTCN','1');
	define('CAT_SOTHICH','2');
	define('CAT_QHGD','3');
	define('CAT_QTHT','4');
	define('CAT_LLCT','5');
	define('CAT_QHXH','6');

	define('CAT_TTCDN','7');
	define('CAT_TT_NGUOI_DAIDIEN_DN','8');
	define('CAT_TC_DOITAC_DN','9');

	define('CAT_TTCTC','10');
	define('CAT_TT_NGUOI_DAIDIEN_TC','11');
	define('CAT_TC_DOITAC_TC','12');

	// Defined sub category cá nhân
	define('SUB_CN_DINHDANH_COTHE','1');
	define('SUB_CN_THONGTIN_QL_CANHAN_XAHOI','2');
	define('SUB_CN_THONGTIN_XAHOI_HIENTAI','3');
	define('SUB_CN_THETHAO','4');
	define('SUB_CN_AMTHUC','5');
	define('SUB_CN_NGHETHUAT','6');
	define('SUB_CN_SACH','7');
	define('SUB_CN_XE','8');
	define('SUB_CN_DIENTHOAI','9');
	define('SUB_CN_THOITRANG','10');
	define('SUB_CN_GIAY','11');
	define('SUB_CN_NUOCHOA','12');
	define('SUB_CN_DOUONG','13');
	define('SUB_CN_CAHAT','14');
	define('SUB_CN_KINHDEO','15');
	define('SUB_CN_DONGHO','16');
	define('SUB_CN_AMNHAC','17');
	define('SUB_CN_DULICH','18');
	define('SUB_CN_QHGD_THONGTIN_DINHDANH_COTHE','19');
	define('SUB_CN_QHGD_THONGTIN_KHAC','20');
	define('SUB_CN_QUATRINH_HOCTAP','21');
	define('SUB_LYLICH_CONGTAC','22');
	define('SUB_QUANHE_XAHOI','23');
	
	// Doanh nghiệp
	define('SUB_DN_THONGTIN_COBAN','24');
	define('SUB_DN_THONGTIN_KHAC','25');	
	
	define('SUB_DN_NDD_THONGTIN_DINHDANH_GANCOTHE','26');
	define('SUB_DN_NDD_THONGTIN_KHAC','27');

	define('SUB_DN_TCDT_THONGTIN_DINHDANH_GAN_TOCHUC','31');
	define('SUB_DN_TCDT_THONGTIN_NGUOI_DAIDIEN_DOITAC','32');

	// Tổ chức
	define('SUB_TC_THONGTIN_COBAN','33');
	define('SUB_TC_THONGTIN_KHAC','34');	
	
	define('SUB_TC_NDD_THONGTIN_DINHDANH_GANCOTHE','35');
	define('SUB_TC_NDD_THONGTIN_KHAC','36');

	define('SUB_TC_TCDT_THONGTIN_DINHDANH_GAN_TOCHUC','37');
	define('SUB_TC_TCDT_THONGTIN_NGUOI_DAIDIEN_DOITAC','38');

	// Config
	define('NUM_QTHT','5');
	define('NUM_LLCT','5');
	define('NUM_QHXH','5');
	define('NUM_DAIDIEN_DOANHNGHIEP','1');
	define('NUM_DOITAC_DOANHNGHIEP','2');
	define('NUM_DAIDIEN_TOCHUC','1');
	define('NUM_DOITAC_TOCHUC','2');

	define('ITEM_INROW','4');

	define("GROUP_CANHAN", '0');
	define("GROUP_DOANHNGHIEP", '1');
	define("GROUP_TOCHUC", '2');

	define("STATUS_COMPLETE", "st_complete");
	define("STATUS_FAILED", "st_faile");
	define("STATUS_CANCEL", "st_cancel");
	define("STATUS_WAITING", "st_waiting");	

	define( 'API_ACCESS_KEY', 'AIzaSyB6el3ViwEws3JtSNdG4W0XHufGpRH3OtI');
	
	// define( 'API_ACCESS_KEY', 'AIzaSyDg4xr1iLa_9yZs4WM_asWEhGCXllqiK1Q');
	
	define("PLATFORM_ANDROID", 0);
	define("PLATFORM_IOS", 1);

	define("NOTIFY_BIRTHDAY", 0);
	define("NOTIFY_APPROVE", 1);
	define("NOTIFY_REQUEST", 2);
	define("NOTIFY_REJECT", 3);
	define("NOTIFY_SCHEDULE", 4);
	
?>