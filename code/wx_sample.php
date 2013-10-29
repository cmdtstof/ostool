<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "gbitsluanzhan");

$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
					require 'utils/dbOstoolUtils.php';
              		$msgType = "text";
					$logsql = "select `name`,`value`,`remark` from weixin_tiaokan";
					$result=mysql_query($logsql, $osconn);
					$count = mysql_num_rows($result);
					$tiaokanflag=false;
					$tiaokanValue="";
					//if(strtolower($keyword)=='a19谁'){
					if($count>0){
						mysql_data_seek($result, 0);
						while ($row=mysql_fetch_row($result)){
							$tiaokanValue = strstr(strtolower($keyword),strtolower(mb_convert_encoding($row[0],"utf-8","GBK")));
							if(empty($tiaokanValue)){
									$tiaokanflag = false;
									//$tiaokanValue=1;//mb_convert_encoding($row[0],"utf-8","GBK");
							}else{
								if($tiaokanValue>=0){
									$tiaokanflag = true;
									$tiaokanValue = mb_convert_encoding($row[1],"utf-8","GBK");
									break;
								}
							}
							
						}
					}
					//}
					if($tiaokanflag){						
						$contentStr = $tiaokanValue;
						$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
						echo $resultStr;
					}else{
						if($keyword=='A9'){
							$contentStr = "欢迎关注【乱战】卡牌游戏，本微信持续开发和补充功能ing。\r\n如需查询现有卡牌信息。请回复【A】。\r\n如有其他需求请留言。我们后续将予以回复!";
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $resultStr;
						}else if($keyword=='A' || $keyword=='a'){
							$logsql = "INSERT INTO weixin_log (fromUsername,toUsername,content,createTime,step) VALUES ('$fromUsername','$toUsername','$keyword',now(),'1')";
							$result=mysql_query($logsql, $osconn);
							$contentStr = "请准确输入您要查询的卡牌名称（如吕布）或属性（如毁天灭地），如输入错误将导致结果无法正常显示，请勿同时输入名称+属性。";
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $resultStr;
						}else{
							$logsql = "select step,content from weixin_log where fromUsername = '".$fromUsername."' and createTime > '".date("Y-m-d")."'order by createTime desc ";
							$result=mysql_query($logsql, $osconn);
							$count = mysql_num_rows($result);
							if($count>0){
								$r1 = "";
								$r2 = "";
								$r="";
								
								while ($row=mysql_fetch_row($result))
								{
									$r1 = $row[0];
									$r2 = $row[1];
									break;
								}
								if($r1=='1'){
									$strsql="SELECT name,agname,star,rare_level,color,str,`int`,skill_info,id from card where rare_level >0 and name like '%".mb_convert_encoding($keyword,"GBK","utf-8")."%' or agname like '%".mb_convert_encoding($keyword,"GBK","utf-8")."%' order by id";
									$result=mysql_query($strsql, $osconn);
											
									$count = mysql_num_rows($result);
									if($count>0){
										// 定位到第一条记录
										mysql_data_seek($result, 0);
										if($count>1){
											$r="为你查找到以下内容：\r\n";
											$te="1";
											while ($row=mysql_fetch_row($result))
											{
												$r = $r."【".$te."】".mb_convert_encoding($row[0],"utf-8","GBK")."*".mb_convert_encoding($row[1],"utf-8","GBK")."\r\n";
												$te++;
											}
											$r= $r."\r\n请输入相应的数字代码。回复【A】后，重新查询";
											$logsql = "INSERT INTO weixin_log (fromUsername,toUsername,content,createTime,step) VALUES ('$fromUsername','$toUsername','".mb_convert_encoding($keyword,"GBK","utf-8")."',now(),'2')";
											$result=mysql_query($logsql, $osconn);
										}else{
											$r="为你查找到以下内容：\r\n";
											while ($row=mysql_fetch_row($result))
											{
												$r = $r.mb_convert_encoding($row[0],"utf-8","GBK")."*".mb_convert_encoding($row[1],"utf-8","GBK")."\r\n".
													$row[2]."星".$row[3]."稀有";
												if($row[4]=="gold"){
													$r=$r."金卡  武力".$row[5]." 智力".$row[6]." \r\n技能：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
													
												}else if($row[4]=="silver"){
													$r=$r."银卡  武力".$row[5]." 智力".$row[6]." \r\n技能：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
												}else if($row[4]=="green"){
													$r=$r."计策卡  \r\n描述：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
												}else if($row[4]=="red"){
													$r=$r."陷阱卡  \r\n描述：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
												}
											}
											$r= $r."\r\n是否还有其他卡牌需要查询，请输入相应的卡牌名";
										}
									}else{
										$r= "您好，这是自动回复，暂时没有你需要的内容，如有其它需求请留言提出，我们后续将予以回复。如需查询卡牌讯息请回复【A】";
									}
										
									$contentStr = $r;
									$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);									
									echo $resultStr;
								}else if($r1=='2'){
									if(is_numeric($keyword)){
										$li = (int)$keyword-1;
										$strsql="SELECT name,agname,star,rare_level,color,str,`int`,skill_info from card where rare_level >0 and  name like '%".$r2."%' or agname like '%".$r2."%' order by id limit ".$li.",1";
										$result=mysql_query($strsql, $osconn);
												
										$count = mysql_num_rows($result);
										if($count>0){
											// 定位到第一条记录
											mysql_data_seek($result, 0);
											$r="为你查找到以下内容：\r\n";
											while ($row=mysql_fetch_row($result))
											{
												$r = $r.mb_convert_encoding($row[0],"utf-8","GBK")."*".mb_convert_encoding($row[1],"utf-8","GBK")."\r\n".
													$row[2]."星".$row[3]."稀有";
												if($row[4]=="gold"){
													$r=$r."金卡  武力".$row[5]." 智力".$row[6]." \r\n技能：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
													
												}else if($row[4]=="silver"){
													$r=$r."银卡  武力".$row[5]." 智力".$row[6]." \r\n技能：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
												}else if($row[4]=="green"){
													$r=$r."计策卡  \r\n描述：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
												}else if($row[4]=="red"){
													$r=$r."陷阱卡  \r\n描述：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
												}			
											}
											$r= $r."\r\n是否还有其他同名卡牌需要查询，请输入相应的卡牌属性编号。回复【A】后，重新查询";
											//$result=mysql_query($logsql, $osconn);
										}else{
											$r = "您好，这是自动回复，暂时没有你需要的内容，如有其它需求请留言提出，我们后续将予以回复。请重新输入您要的卡牌属性编号或回复【A】后，重新查询";
										}
									}else{
										$r = "您好，这是自动回复，暂时没有你需要的内容，如有其它需求请留言提出，我们后续将予以回复。请重新输入您要的卡牌属性编号或回复【A】后，重新查询";
									}
										
									$contentStr = $r;
									$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
									echo $resultStr;
								}else if($r1=='3'){
								}
							}else{						
								$contentStr = "欢迎关注【乱战】卡牌游戏，本微信持续开发和补充功能ing。\r\n如需查询现有卡牌信息。请回复【A】。\r\n如有其他需求请留言。我们后续将予以回复!";
								$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
								echo $resultStr;
							}	
							// 释放资源
							mysql_free_result($result);
							// 关闭连接
							mysql_close($osconn);
						}
					}
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "2";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        echo $signature;
		echo $timestamp;
		echo $nonce;
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
	
	private function tiaokanFind(){
	}
	
	private function fristFind($osconn,$fromUsername,$toUsername,$keyword){
		$strsql="SELECT name,agname,star,rare_level,color,str,`int`,skill_info,id from card where name like '%".mb_convert_encoding($keyword,"GBK","utf-8")."%' or agname like '%".mb_convert_encoding($keyword,"GBK","utf-8")."%' order by id";
		$result=mysql_query($strsql, $osconn);
		$count = mysql_num_rows($result);
		if($count>0){
			// 定位到第一条记录
			mysql_data_seek($result, 0);
			if($count>1){
				$r="为你查找到以下内容：\r\n";
				$te="1";
				while ($row=mysql_fetch_row($result))
				{
					$r = $r."【".$te."】".mb_convert_encoding($row[0],"utf-8","GBK")."*".mb_convert_encoding($row[1],"utf-8","GBK")."\r\n";
					$te++;
				}
				$r= $r."\r\n请输入相应的数字代码。回复【A】后，重新查询";
				$logsql = "INSERT INTO weixin_log (fromUsername,toUsername,content,createTime,step) VALUES ('$fromUsername','$toUsername','".mb_convert_encoding($keyword,"GBK","utf-8")."',now(),'2')";
				$result=mysql_query($logsql, $osconn);
			}else{
				$r="为你查找到以下内容：\r\n";
				while ($row=mysql_fetch_row($result))
				{
					$r = $r.mb_convert_encoding($row[0],"utf-8","GBK")."*".mb_convert_encoding($row[1],"utf-8","GBK")."\r\n".
						$row[2]."星".$row[3]."稀有";
					if($row[4]=="gold"){
						$r=$r."金卡  武力".$row[5]." 智力".$row[6]." \r\n技能：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
					}else if($row[4]=="silver"){
						$r=$r."银卡  武力".$row[5]." 智力".$row[6]." \r\n技能：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
					}else if($row[4]=="green"){
						$r=$r."计策卡  \r\n描述：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
					}else if($row[4]=="red"){
						$r=$r."陷阱卡  \r\n描述：".str_ireplace("<br>","\r\n",mb_convert_encoding($row[7],"utf-8","GBK"));
					}
				}
				$r= $r."\r\n是否还有其他卡牌需要查询，请输入相应的卡牌名";
			}
		}else{
			$r= "您好，这是自动回复，暂时没有你需要的内容，如有其它需求请留言提出，我们后续将予以回复。如需查询卡牌讯息请回复【A】";
		}
		$contentStr = $r;
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		return $resultStr;
	}
	
	function secondFind($keyword){
		return "23123";
	}
}

?>