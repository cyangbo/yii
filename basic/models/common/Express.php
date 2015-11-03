<?php

namespace app\models\common;

class Express{

	public static function ccc(){
		return "ppppp";
	}

	/**
	 * 中通根据运单号,获取物流跟踪信息
	 */
	public static function zto($tracking){
			
		$order_code	= $tracking;
		$data = self::_ztoconfig();
		//print_r($data);exit;
		//Array ( [url] => http://partner.zto.cn/client/interface.php? [style] => json [partner] => 1000079663 [pass] => J8BTLC1IW1 [func] => mail.trace )

		$url = $data['url'];
		$style 	= $data['style'];
		$partner = $data['partner'];
		$pass = $data['pass'];
		$func = $data['func'];

		$datetime		= date('Y-m-d H:i:s');                               //当前时间
		//print_r($datetime);exit;

		$contentDetail = '{ "mailno":"'.$order_code.'" }';
		//print_r($contentDetail);exit;
		//358947487779
		$content = base64_encode($contentDetail);                           //编码好的内容
		$verify = md5($partner.$datetime.$content.$pass);                   //加密
		//发送的url
		$post = $url."style=".urlencode($style)."&func=".urlencode($func)."&partner=".urlencode($partner)."&datetime=".urlencode($datetime)."&content=".urlencode($content)."&verify=".urlencode($verify);
		//print_r($post);exit;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $post);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
		$return_data = curl_exec($curl);
		//print_r($return_data);exit;
		curl_close($curl);
		$zto = json_decode($return_data);      //转换成数组的返回值


		$zto = self::objectToArray($zto);

		return $zto;
		// print_r($zto);exit;
		if($zto['error']){
			$zto = "查询无结果";
		}elseif($zto['traces']['0']['acceptAddress'] == ''){
			$zto = "查询无结果";
		}elseif($zto['traces']['0']['acceptAddress'] != ''){
			$zto = array_reverse($zto['traces']);
		}
		//print_r($zto);exit;
		$this->view->zto = $zto;
		$this->view->tracking_type = "zto";
		$this->view->number = $order_code;
		echo $this->view->render($this->tplDirectory . "tracking.tpl");
	}

	/**
	 * 根据运单号获取圆通快递跟踪信息
	 */
	public static function yto($tracking){

		$number	= $tracking;

		$data = self::_ytoconfig();
		//print_r($data);exit;
		//Array ( [url] => http://58.32.246.70:8002 [app_key] => hE2Ib1 [format] => json [method] => yto.Marketing.WaybillTrace [user_id] => xindaguoji [ver] => 1.0 [secret] => xlNKIg )

		$url = $data['url'];
		$app_key = $data['app_key'];
		$format = $data['format'];
		$method = $data['method'];
		$user_id = $data['user_id'];
		$ver = $data['ver'];
		$secret = $data['secret'];

		$timestamp = date('Y-m-d H:i:s');
		$param = '';
		$param .= "[{'Number':".$number."}]";

		//构造sign
		$a = "app_key".$app_key."format".$format."method".$method."timestamp".$timestamp."user_id".$user_id."v".$ver;
		$b = $secret.$a;
		$sign = strtoupper(md5($b,false));
		$a1 = "app_key=".$app_key."&format=".$format."&method=".$method."&timestamp=".$timestamp."&user_id=".$user_id."&v=".$ver;
		$b1 = "sign=".$sign."&".$a1;
		$sign1 = $b1."&param=".$param;

		//发送post请求
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, 1 );
		curl_setopt($curl, CURLOPT_POSTFIELDS, $sign1);

		//获取回调信息
		$tmpInfo = curl_exec($curl);
		curl_close($curl);
		unset($timestamp);
		unset($param);
		//$yto = json_decode($tmpInfo);
		$yto =  json_decode( $tmpInfo,true);

		return $yto;
		if($yto == ''){
			$yto = "查询无结果";
		}else{
			$yto = array_reverse($yto);
		}

		$this->view->yto = $yto;
		$this->view->tracking_type = "yto";
		$this->view->number = $number;
		echo $this->view->render($this->tplDirectory . "tracking.tpl");

	}




	/**
	 * 邮政根据运单号,获取物流跟踪信息
	 */
	public static function cnexp($tracking){

		$order_code	= $tracking;
		$data = self::cnexptrack($order_code);
		$cnexp = self::objectToArray($data);
		//$cnexp = array_reverse($cnexp['out']['Mail']);
		$cnexp = $cnexp['out']['Mail'];
		foreach ( $cnexp as $k => $v){
			$cnexp[$k]['actionDateTime'] = str_replace("T","  -  ",$v['actionDateTime']);
			$cnexp[$k]['actionDateTime'] = str_replace("+08:00","",$cnexp[$k]['actionDateTime']);
		}

		//print_r($cnexp);exit;

		return $cnexp;

		if($cnexp['out'] == ''){
			$cnexp = "查询无结果";
		}elseif($cnexp['out']['Mail']){
			$cnexp = array_reverse($cnexp['out']['Mail']);
			foreach ( $cnexp as $k => $v){
				$cnexp[$k]['actionDateTime'] = str_replace("T","  -  ",$v['actionDateTime']);
				$cnexp[$k]['actionDateTime'] = str_replace("+08:00","",$cnexp[$k]['actionDateTime']);
			}
		}

			
		$this->view->cnexp = $cnexp;
		$this->view->tracking_type = "cnexp";
		$this->view->number = $order_code;
		echo $this->view->render($this->tplDirectory . "tracking.tpl");
	}

	/**
	 * 顺丰根据运单号,订单号获取物流跟踪信息
	 */
	public function sfAction(){
		//直接使用变量邮政的变量名称$cnexp，模板就不改动了
		$order_code	= $this->_request->getParam('tracking_number','');
		$order_code =   444029606685 ;
		$data = Common_Express::sftrack($order_code);
		$data = simplexml_load_string($data->return);
		if($data->Head == 'ERR'){
			$trackInfoArr = "查询出错";
		}else{
			$routerArr = $data->xpath('//Route');
			foreach ($routerArr as $k => $v){
				$trackInfoArr[$k] = array(
						'actionDateTime' => (string)$v->attributes()->accept_time,
						'officeName' => (string)$v->attributes()->accept_address,
						'relationOfficeDesc' => (string)$v->attributes()->remark,
				);
			}
		}
		$this->view->trackInfoArr = $trackInfoArr;
		$this->view->tracking_type = "sf";
		$this->view->number = $order_code;
		echo $this->view->render($this->tplDirectory . "tracking.tpl");
	}


	/**
	 * 思迈根据运单号,订单号获取物流跟踪信息
	 */
	public function smAction(){
		//直接使用变量邮政的变量名称$cnexp，模板就不改动了
		$order_code	= $this->_request->getParam('tracking_number','');
		$data = Common_Express::smtrack($order_code);
		$xml = simplexml_load_string($data);
		$trackInfoResponse = $xml->xpath('//detail');
		if(!empty($trackInfoResponse)){
			foreach($trackInfoResponse as $k=>$detail){
				$trackInfoArr[$k]['actionDateTime'] = $detail->time;
				$trackInfoArr[$k]['officeName'] =  $detail->memo;
				$trackInfoArr[$k]['relationOfficeDesc'] =$detail->scantype;
			}
		}else{
			$trackInfoArr = "查询无结果";
		}
		$this->view->trackInfoArr = $trackInfoArr;
		$this->view->number = $order_code;
		$this->view->tracking_type = "sm";
		echo $this->view->render($this->tplDirectory . "tracking.tpl");
	}





















	/**
	 * 根据运单号获取圆通快递跟踪信息
	 */
	private static function _ytoconfig(){

		$data = array();
		$data['url'] = 'http://58.32.246.70:8002';
		$data['app_key'] = "hE2Ib1";
		$data['format'] =  "json";
		$data['method'] = "yto.Marketing.WaybillTrace";
		$data['user_id'] = "xindaguoji";
		$data['ver'] = "1.0";
		$data['secret'] = "xlNKIg";

		return $data;

			
	}

	/**
	 * 根据运单号获取中通快递跟踪信息
	 */
	public static function _ztoconfig(){
		$data = array();

		$data['url'] = 'http://testpartner.zto.cn/client/interface.php?';      //测试url
		$data['style'] = "json";                                                //参数类型
		$data['partner'] = 'test';                                                 //测试用户名
		$data['pass'] = "ZTO123";                                                     //测试密码
		$data['func'] = "mail.trace";

		return $data;

	}

	/**
	 * 根据运单号获取邮政跟踪信息
	 */

	private static function cnexptrack($tracking_number){
			
		$url = 'http://211.156.220.124:7700/ECWS/xfire/services/MailTtService?wsdl';      //测试url          								//接口方法9974406213502
		$object = array('in0'=>'1','in1'=>'1','in2'=>$tracking_number);

		$client = new SoapClient($url);

		//var_dump($client->__getFunctions ());
		//var_dump ( $client->__getTypes () );

		$result = $client->getMails($object);
		//var_dump ($result);
		return $result;
			
	}

	/**
	 *获取顺丰物流跟踪信息
	 * @param1 快递单号，或者订单号
	 */
	public static function sftrack($tracking_number){
		$head = "BSPdevelop";                   //客户卡号,校验码
		$checkbody = 'j8DzkIFgmlomPt0aLuwU'; //checkbody
		$wsdl = 'http://bsp-oisp.test.sf-express.com:6080/bsp-oisp/ws/sfexpressService?wsdl'; //快递类服务接口url
		$client = new SoapClient($wsdl);
		$tracking_type = 1;/*1：根据顺丰运单号查询,2：根据客户订单号查询*/

		if(preg_match('/SOC\d{11}/',$tracking_number)){
			$tracking_type = 2;
		}
		$method_type = 1;/*1：标准路由查询,2：定制路由查询*/

		$xml = '<?xml version="1.0" encoding="utf-8" ?>';
		$xml .= '<Request service="RouteService" lang="zh-CN">';
		$xml .= '<Head>'.$head.'</Head>';
		$xml .= '<Body>';
		$xml .= '<RouteRequest tracking_type="'.$tracking_type.'" method_type="'.$method_type.'" tracking_number="'.$tracking_number.'"/>';
		$xml .= '</Body>';
		$xml .= '</Request>';

		$md5 = md5($xml . $checkbody, true);
		$verifyCode = base64_encode($md5);
		$result = $client->sfexpressService(array("arg0" => $xml, "arg1" => $verifyCode));
		return $result;
	}

	/**
	 *获取思迈物流跟踪信息
	 * @param1 快递单号，或者订单号
	 */
	public static function smtrack($tracking_number){
		//$trackUrl = "http://182.92.72.100:8092/yxdC/track.aspx?billcode=";
		$trackUrl = "http://120.26.204.154:8092/yxdC/track.aspx?billcode=";
		return file_get_contents($trackUrl.$tracking_number);
	}

	/**
	 * 对象转数组
	 * @param $obj
	 * @return mixed
	 */
	public static function objectToArray($obj)
	{
		$_arr = is_object($obj) ? get_object_vars($obj) : $obj;
		if (is_array($_arr)) {
			foreach ($_arr as $key => $val) {
				$val = (is_array($val) || is_object($val)) ? self::objectToArray($val) : $val;
				$arr[$key] = $val;
			}
		}
		return $arr;
	}


}