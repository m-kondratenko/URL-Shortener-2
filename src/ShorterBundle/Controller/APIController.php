<?php

namespace ShorterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ShorterBundle\Entity\Urls;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class APIController extends Controller
{
    public function indexAction()
    {
      $request = Request::createFromGlobals();
      $longurl = $request->query->get('longurl');
      $shorturl = $request->query->get('desiredurl');
      $urls = new Urls();

      //check for valid URL
      if (!$urls->verifyLongUrl($longurl)) {
        $html = 'Your URL is not valid!';
        return new Response($html, 200);
      }

      //check for desired URL
      if ($shorturl) {
        if(!preg_match('|^[0-9a-z]{1,6}$|', $shorturl)) {
          $html = 'That is not a valid short URL';
          return new Response($html, 200);
        }
        //search for desired URL in the DB
        $repository = $this->getDoctrine()->getRepository('ShorterBundle:Urls');
        if ($repository->findOneByShorturl($shorturl)) {
          $html = 'Desired URL is already in the DB';
          return new Response($html, 200);
        }
      }
      //generate short URL
      else {
        $repository = $this->getDoctrine()->getRepository('ShorterBundle:Urls');
        do {
          $generatedurl=$urls->generateShortURL();
        } while ($repository->findOneByShorturl($generatedurl));
        $shorturl=$generatedurl;
      }

      //insert URL pair into the DB
      $urls->setLongurl($longurl);
      $urls->setShorturl($shorturl);
      $urls->setDate();
      $urls->setCounting('0');
      $em = $this->getDoctrine()->getManager();
      $em->persist($urls);
      $em->flush();

      //generate request
      $shorturl="http://".$request->server->get('HTTP_HOST')."/".$shorturl;
      return new Response($shorturl, 200);
      //return $shorturl;
    }
}
