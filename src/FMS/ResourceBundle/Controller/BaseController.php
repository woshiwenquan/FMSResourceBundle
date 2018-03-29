<?php
/**
 * Created by PhpStorm.
 * User: wenquan
 * Date: 2018/3/23
 * Time: 下午4:28
 */

namespace App\FMS\ResourceBundle\Controller;


use App\FMS\ResourceBundle\DoctrineExtends\FMSDoctrine;
use App\FMS\ResourceBundle\Handle\ResponseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

class BaseController extends AbstractController
{
    public function getFMSDoctrine()
    {
        return new FMSDoctrine($this->getDoctrine());
    }

    public function getResponseHandler()
    {
        return new ResponseHandler();
    }

    protected function getPageInfo($page, $count = 0, $path, $data, $maxPage, $thisPageCount=null)
    {
        $a = $count / $maxPage;
        $b = (int)($count / $maxPage);
        if ($a + 1 > $b + 1) {
            $maxPage = ((int)($count / $maxPage)) + 1;
        } else {
            $maxPage = $a;
        }

        if ($page - 1 != 0) {
            $prePage = $page - 1;
        } else {
            $prePage = 0;
        }
        if ($page + 1 > $maxPage) {
            $nextPage = 0;
        } else {
            $nextPage = $page + 1;
        }
        if ($maxPage == 0) {
            $maxPage = 1;
        }
        $pageInfo = array(
            'currentPage' => $page,
            'prePage' => $prePage,
            'nextPage' => $nextPage,
            'maxPage' => $maxPage,
            'thisPageCount' => $thisPageCount,
            'allNum' => $count,
            'path' => $path,//分页路径
            'param' => $data//参数
        );
        return $pageInfo;
    }

    public function saveEntity($entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($entity);
        try {
            $entityManager->flush();
        }catch (Exception $exception) {
            return $exception->getMessage();
        }


    }

    public function removeEntity($entity)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}