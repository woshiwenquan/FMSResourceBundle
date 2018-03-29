<?php
/**
 * Created by PhpStorm.
 * User: wenquan
 * Date: 2018/3/26
 * Time: 下午1:55
 */

namespace App\FMS\ResourceBundle\Handle;

use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class ResponseHandler
{
    private function writeMsg($msg, $code) {
        $serializer = SerializerBuilder::create()->build();
        $data = $serializer->serialize($msg, 'json');
        $data = $serializer->deserialize($data, 'array', 'json');
        return new JsonResponse($data, $code, array('Access-Control-Allow-Origin'=> '*'));
    }

    private  function writeMsgJson($msg) {
        $serializer = SerializerBuilder::create()->build();
        $data = $serializer->serialize($msg, 'json');
        $data = $serializer->deserialize($data, 'array', 'json');
        return new Response('jsonpCallback('.json_encode($data, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT).')');
    }

    public function writeOk($data, $message, $code = Response::HTTP_OK)
    {
        $data = array('code'=>$code,'message'=>$message, 'data'=>$data);
        return $this->writeMsg($data, $code);
    }

    public function writeFail($data, $message, $code = Response::HTTP_BAD_REQUEST)
    {
        $data = array('code'=>$code,'message'=>$message, 'data'=>$data);
        return $this->writeMsg($data, $code);
    }

}