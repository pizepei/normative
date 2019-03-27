<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/14
 * Time: 16:09
 */

namespace service\document;


class DocumentService
{
    /**
     * 获取文档只的请求参数（文档格式）
     */
    public  function getParamInit($info)
    {
        //var_dump($info);
        if(!empty($info)){
            $i = $i??0;
            foreach($info as $key=>$value){
                $infoData[$i]['field'] = $key;
                $infoData[$i]['fieldExplain'] = $value['fieldExplain'];//字段说明
                $infoData[$i]['type'] = $value['fieldRestrain'][0];//字段说明
                $infoData[$i]['fieldRestrain'] = implode(' | ',$value['fieldRestrain']);//约束
                if(isset($value['substratum'])){
                    $str = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    $i++;
                    $this->recursiveParam($value['substratum'],$infoData,$i,$str);
                    $str = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                $i++;
            }
        }

        return $infoData??[];
    }

    /**
     * @param $info
     * @param $infoData
     * @param $i
     * @param $str
     */
    public function recursiveParam($info,&$infoData,&$i,&$str)
    {
        $not = '&not;';
        if(!empty($info)){
            foreach($info as $key=>$value){
                $infoData[$i]['field'] = $str.$not.$key;
                $infoData[$i]['fieldExplain'] = $value['fieldExplain'];//字段说明
                $infoData[$i]['type'] = $value['fieldRestrain'][0];//字段说明
                $infoData[$i]['fieldRestrain'] = implode(' | ',$value['fieldRestrain']);//约束
                if(isset($value['substratum'])){
                    $rawStr = $str;
                    $str = $str.$str;
                    $i++;
                    $this->recursiveParam($value['substratum'],$infoData,$i,$str);
                    $str = $rawStr;
                }
                $i++;
            }
        }
    }



}