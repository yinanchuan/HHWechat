<?php
require_once ('lib/core/common_run.inc.php');

$urls = array (
	'.export'		=> 'exportAction',
	'.backend' 		=> 'backendAction',
	'.viewcodes' 	=> 'viewcodesAction',
	'.updatepwd' 	=> 'updatepwdAction',
	'.logout' 		=> 'logoutAction',
	'.*' 			=> 'loginAction' 
);

class exportAction extends Common{
	function GET(){
		$phase = isset ( $_GET['phase'] ) ? $_GET['phase'] : 1;
		
		$_activity = new activity();
		$page = $_activity->findPage( null, 0 ,intval( $phase ), 1 ,null);
		
		if(isset($page['page']))
		{
			$this->getExcel2($page['page']);
			//$this->getCSV($page['page'] , 'activity0'.$phase);
			//$this->getExcel($page['page'] , 'activity0'.$phase.'.xls');
		}
	}
	
	function getExcel2($list){

		$str = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<title>backend list</title>
<style>
td{
    text-align:left;
    font-size:12px;
    font-family:Arial, Helvetica, sans-serif;
    border:#000000 1px solid;
    color:#000000;
    width:100px;
}
table,tr{
    border-style:none;
}
.title{
    font-weight:bold;
}
</style>
</head>
<body>
<table width='1200' border='1'>
  <tr>
    <td class='title'>No.</td>
    <td class='title'>Id</td>
    <td class='title'>Name</td>
    <td class='title'>Phone</td>
    <td class='title'>Lucky</td>
    <td class='title'>Update Date</td>
    <td class='title'>Post Date</td>
  </tr>
";
		$i = 1;
		foreach($list as $key => $value){
			$isLuck = intval($value['luck']) == 1 ? "T" : "F";
			$str .= "
			  <tr>
			    <td>" . $i . "</td>
			    <td>" . $value['id'] . "</td>
			    <td>" . $value['name'] . "</td>
			    <td>" . $value['phone'] . "</td>
				<td>" . $isLuck . "</td>
			    <td>" . $value['udate'] . "</td>
			    <td>" . $value['cdate'] . "</td>
			  </tr>
			";
			$i ++;
		}
		
$str .= "
</table>
</body>
</html>
";

		log_access( 0, md5($str), "Export" );
		header ( "Content-type:application/vnd.ms-excel" );
		header ( "Content-Disposition:filename=backend.xls" );
		echo $str;
		exit;
	}
	
	function getCSV( $result, $name = 'activity')
	{
		
		$str = "No\t,Id\t,Name\t,Phone\t,Lucky\t,Update Date\t,Post Date\t\n"; 
    	for ($i = 0; $i < count($result); $i++) {
			$str .= ($i + 1).','.$result[$i]['id'].','.$result[$i]['name'].','.$result[$i]['phone'].',';
			if(intval($result[$i]['luck']) == 1){
				$str .= 'T';
			}
			$str .= ','.$result[$i]['udate'].','.$result[$i]['cdate']."\r\n";
		}
		header("Content-type:text/csv"); 
		header("Content-Disposition:attachment;filename=".$name.'.csv'); 
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0'); 
		header('Expires:0'); 
		header('Pragma:public'); 
		echo iconv('utf-8','gb2312',$str);
	}
	
	
	function getExcel($result, $name = 'activity.xls'){
		/** Error reporting */
		//error_reporting(E_ALL);
		//ini_set('display_errors', TRUE);
		//ini_set('display_startup_errors', TRUE);
		//date_default_timezone_set('Europe/London');
		
		if (PHP_SAPI == 'cli'){
			die('This example should only be run from a Web Browser');
		}
		
		/** Include PHPExcel */
		//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
		//require_once ('/lib/PHPExcel.php');
		require_once dirname(__FILE__) . '/lib/PHPExcel.php';
		
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Nways")
			 ->setLastModifiedBy("Nways")
			 ->setTitle("Office 2007 XLSX Test Document")
			 ->setSubject("Office 2007 XLSX Test Document")
			 ->setDescription("Acyivity list file for Office 2007 XLSX.")
			 ->setKeywords("office 2007 openxml php")
			 ->setCategory("Activity list file");
		
		
		// Add data
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Id')
			->setCellValue('C1', 'Name')
			->setCellValue('D1', 'Phone')
			->setCellValue('E1', 'Lucky')
			->setCellValue('F1', 'Update Date')
			->setCellValue('G1', 'Post Date');
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); //X * 7px
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		
		for ($i = 0; $i < count($result); $i++) {
			$objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($i + 2), ($i + 1));
			$objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($i + 2), $result[$i]['id']);
			$objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($i + 2), $result[$i]['name']);
			$objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($i + 2), $result[$i]['phone']);
			if(intval($result[$i]['luck']) == 1){
				$objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($i + 2), 'T');
			}
			$objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($i + 2), $result[$i]['udate']);
			$objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($i + 2), $result[$i]['cdate']);
			
			$objPHPExcel->getActiveSheet()->getStyle('A' . ($i) . ':G' . ($i + 2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A' . ($i) . ':G' . ($i + 2))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(18);
		}
		
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Activity');
		
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		ob_end_clean();
		
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Activity.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	
} 

class backendAction extends Common {
	function GET() {
		$wheresql = "";
		
		$keys = isset($_GET['keys']) ? trim(stripslashes($_GET['keys'])) : null;
		if(!empty($keys)){
			$wheresql .= " AND ( ";
			$wheresql .= " p.name LIKE '%$keys%' ";
			$wheresql .= " OR p.phone LIKE '%$keys%' ";
			$wheresql .= " ) ";
		}
		
		$_collect = new collect();
		$pagesize = 20;
		
		//分页处理
		$pages = $this->listPages();
		$page = $pages['page'];
		$limitstart = $pages['limitstart'];
		
		$sql = "
			SELECT p.id, p.uid, p.name, p.phone, p.cdate,
			p2.seconds, p2.times, p2.mindate
			FROM avenejump_profile p, (
				SELECT p1.phone, MAX(p1.num1) AS seconds, COUNT(p1.id) AS times, MIN(p1.cdate) AS mindate
				FROM avenejump_profile p1
				WHERE p1.isdelete = 0
				GROUP BY p1.phone
			) AS p2
			WHERE p.phone = p2.phone AND p.num1 = p2.seconds AND p.isdelete = 0
		";
		$sql .= $wheresql;
		//$sql .= " ORDER BY p2.seconds DESC, p.cdate ";
		
		$sqlpage = "SELECT COUNT(tp.uid) AS pnumber FROM ($sql) tp";
		$pagedata = $_collect->findObject($sqlpage);
		$total = $pagedata['pnumber'];
		$pagenum = ceil($total / $pagesize);
		
		$sqllist = $sql;
		$sqllist .= " ORDER BY p2.seconds DESC, p.cdate ";
		$sqllist .= " limit $limitstart,$pagesize";
		//die($sqllist);
		$list = $_collect->findList($sqllist);
		
		foreach($list as $key => &$value){
			if(isset($value['seconds'])){
				//$value['seconds'] = $this->formatScore($value['seconds']);
			}
		}
		
		$p = array();
		$p['list'] = $list;
		$p['page'] = $page;
		$p['pagenum'] = $pagenum;
		$p['total'] = $total;
		$p['keys'] = $keys;
		
		$this->render_admin ( 'backend', $p );
	}
	function POST() {}
}

class viewcodesAction extends Common {
	function GET() {
		$id =  isset ( $_GET ['id'] ) ? intval($_GET ['id']) : 0;
		
		$list = array();
		$_profile = new profile();
		
		$profile = $_profile->findById($id);
		if(isset($profile)){
			$phone = $profile['phone'];
			
			$sql = "
				SELECT p.id, p.num1 AS seconds, p.cdate FROM avenejump_profile p
				WHERE p.isdelete = 0 AND p.phone = '{$phone}'
				GROUP BY p.num1 DESC, p.cdate
			";
			$list = $_profile->findList($sql);
		}

		ajax_return ( ajax_success (null, $list) );
	}
}

class loginAction extends Common {
	function __construct($web) {
		$web->middleware ['session']->require_login = false;
	}
	function GET() {
		$this->render_admin ( 'login' );
	}
	function POST() {
		if (! isset ( $_POST ['password'] )) {
			ajax_return ( ajax_failure ( 'The password is required.' ) );
		}
		$password = $_POST ['password'];
		
		$username = 'admin';
		if (isset ( $_POST ['username'] )) {
			$username = $_POST ['username'];
		}
		
		$_user = new user ();
		
		$user = $_user->findByUsernameLevels($username,99);
		if (! isset ( $user )) {
			ajax_return ( ajax_failure ( 'Login account was not found.' ) );
		}
		if ($password != $user ['password']) {
			ajax_return ( ajax_failure ( 'Login password does not match.' ) );
		}
		
		$this->session_user ( $user );
		log_access(DicConst::$TYPE_LOG_LOGIN, $username);
		
		ajax_return ( ajax_success () );
	}
}

class logoutAction {
	function GET() {
		$_SESSION = array ();
		if (isset ( $_COOKIE [session_name ()] )) {
			setcookie ( session_name (), '', time () - 42000, '/' );
		}
		session_destroy ();
		header ( "Location: " . APP_URL . "admin.php" );
	}
}

class updatepwdAction extends Common {
	function GET() {
		$this->render_admin ( 'updatepwd' );
	}
	function POST() {
		if(!isset( $_POST ['password' ] ) || !isset($_POST ['oldpwd']) || !isset($_POST ['username'])){
			ajax_return ( ajax_failure( 'Parameter validation failure.' ) );
		}
		
		$_user = new user ();
		
		$username = stripslashes($_POST ['username']);
		$oldpwd = stripslashes($_POST ['oldpwd']);
		$password = stripslashes($_POST ['password']);
        
		$user = $_user->findByUsername($username);
		if(isset($user) && $user['password'] == $oldpwd){
			$_user = new user ($user['id']);
			$data = array (
				'password' => $password
			);
			$_user->save ( $data );
			
			ajax_return ( ajax_success () );
		}else{
			ajax_return ( ajax_failure('User name does not exist or the original password input error.') );
		}
	}
}

run ( $urls );
?>
