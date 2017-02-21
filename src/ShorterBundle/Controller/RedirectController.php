<?php

namespace ShorterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ShorterBundle\Entity\Urls;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class RedirectController extends Controller
{
    public function indexAction($url)
    {
      //check if there is such URL in the DB
      $repository = $this->getDoctrine()->getRepository('ShorterBundle:Urls');
      $em = $this->getDoctrine()->getManager();
      $urls = $repository->findOneByShorturl($url);
      if (!$urls) {
        $html = '<html><body><h1>There is no such short URL in the DB</h1></body></html>';
        return new Response($html, 404);
      }

      //get initial URL and increase counting
      $longurl = $urls->getLongurl();
      $count = $urls->getCounting();
      $urls->setCounting($count+1);
      $em->flush();

      //redirect to initial URL
      return $this->redirect($longurl, 301);
    }
}
