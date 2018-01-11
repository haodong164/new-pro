<?php
namespace app\tiaopi\controller;
use think\Controller;
define('Token','robots');
header("Content-type:text/html;charset=utf-8");
class Index extends Controller
{
	public function index(){
		return $this->fetch();
	}
	public function robot(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		libxml_disable_entity_loader(true);//是设置是否禁止从外部加载XML实体，设为true就是禁止
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$ToUserName=$postObj->ToUserName;
		$FromUserName=$postObj->FromUserName;
		$content=$postObj->Content;
		$MsgType=$postObj->MsgType;
		$nowtime=time();
		switch ($MsgType) {
			// case 'event':
			// $xmltpl="
			// 	<xml>
			// 		<ToUserName><![CDATA[%s]]></ToUserName>
			// 		<FromUserName><![CDATA[%s]]></FromUserName>
			// 		<CreateTime>%s</CreateTime>
			// 		<MsgType><![CDATA[%s]]></MsgType>
			// 		<Event><![CDATA[%s]]></Event>
			// 		<EventKey><![CDATA[]]></EventKey>
			// 		<Ticket><![CDATA[TICKET]]></Ticket>
			// 	</xml>
			// 	";
			// 	if()
			// break;
			case 'text':
				$url="http://www.tuling123.com/openapi/api?key=8137cf2b1b674f8b83bb3d25df3acf8d&info=".$content;
				$replay=file_get_contents($url);
				$recontent=json_decode($replay);
		    	$xmltpl="
					<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>
		    	";
			    $repaycontent=$recontent->text;

			    $data['text']=$content;//内容
			    $data['time']=$nowtime;//时间
			    $data['openid']=$FromUserName;//
			    $data['reply']=$repaycontent;//回复内容
			    $data=db('tiaopi')->insert($data);

			    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text',$repaycontent);
				echo $resultStr;
			break;
			//图片
			case 'image':
		    	$xmltpl="
					<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Image>
							<MediaId><![CDATA[%s]]></MediaId>
						</Image>
					</xml>
		    	";
		    	$data['image']=$postObj->PicUrl;//内容
			    $data['time']=$nowtime;//时间
			    $data['openid']=$FromUserName;//
			    $data['reply']='bF9mSqNG2gIJeJRxAgvIEyrNWCIRxCkSnwdybK-fJk3CuR5FIZyuaNuSl8n2FeXK';//回复内容
			    $data=db('tiaopi')->insert($data);

			    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'image',"bF9mSqNG2gIJeJRxAgvIEyrNWCIRxCkSnwdybK-fJk3CuR5FIZyuaNuSl8n2FeXK");
				echo $resultStr;
			break;
			//语音voice
			case 'voice':
		    	$xmltpl="
					<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Voice>
							<MediaId><![CDATA[%s]]></MediaId>
						</Voice>
					</xml>
		    	";
			    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'voice',"dfLGUzockD2AFBZ_mtJIA5_PpDG2RNzx18ksJMNbUwAScoIzxuhuZrLLtfjPM8oP");
				echo $resultStr;
			break;

			//视频video location
			case 'video':
		    	$xmltpl="
					<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Video>
						<MediaId><![CDATA[%s]]></MediaId>
						<Title><![CDATA['123']]></Title>
						<Description><![CDATA['456']]></Description>
					</Video>
					</xml>
		    	";
			    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'video',"mI_n6H1Bsu3MEH_nJypQQGQlzv49aIi9pX0-UbcmbET-rGI8AB5YQtcxyz7DquGl");
				echo $resultStr;
			break;
			//位置location
			case 'location':
		    	$xmltpl="
					<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
					</xml>
		    	";
			    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text',"这是我的位置");
				echo $resultStr;
			break;
			default:
		    	$url="http://www.tuling123.com/openapi/api?key=8137cf2b1b674f8b83bb3d25df3acf8d&info=".$content;
				$replay=file_get_contents($url);
				$recontent=json_decode($replay);
		    	$xmltpl="
					<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>
		    	";
			    $repaycontent=$recontent->text;
			    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text',"我啥也不是");
				echo $resultStr;
				break;
		}
	}
	public function robots(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		libxml_disable_entity_loader(true);//是设置是否禁止从外部加载XML实体，设为true就是禁止
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$ToUserName=$postObj->ToUserName;
		$FromUserName=$postObj->FromUserName;
		$content=$postObj->Content;
		$url="http://www.tuling123.com/openapi/api?key=8137cf2b1b674f8b83bb3d25df3acf8d&info=".$content;
		$replay=file_get_contents($url);
		$recontent=json_decode($replay);
    	$nowtime=time();
    	$xmltpl="
			<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>0</FuncFlag>
				</xml>
    	";
	    	$repaycontent=$recontent->text;
	    	 
	    	$resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text',$repaycontent);
			echo $resultStr;
    	//}
		//验证token
		// $signature=$_GET["signature"];
    	// $timestamp=$_GET["timestamp"];
    	// $nonce=$_GET["nonce"];
    	// $echostr=$_GET['echostr'];
    	// $array=array(Token,$timestamp,$nonce);
    	// sort($array,SORT_STRING);
    	// $str=implode('',$array);
    	// $str=sha1($str);
    	// if($str==$signature)
    	// {
    		// echo $echostr;
    	// }
    	// else
    	// {
    		// return false;
    	// }
	}
	
}
    