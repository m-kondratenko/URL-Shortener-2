<?php

namespace ShorterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ShorterBundle\Entity\Urls;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\Request;

class ShortenController extends Controller
{
    public function indexAction()
    {
      $request = Request::createFromGlobals();
      $longurl = $request->request->get('longurl');
      $shorturl = $request->request->get('desiredurl');
      $urls = new Urls();

      //check for valid URL
      if (!$urls->verifyLongUrl($longurl)) {
        return $this->render('ShorterBundle:Shorter:index.html.twig',
          array('shorturl' => 'Your URL is not valid!'));
      }

      //check for desired URL
      if ($shorturl) {
        if(!preg_match('|^[0-9a-z]{1,6}$|', $shorturl)) {
          return $this->render('ShorterBundle:Shorter:index.html.twig',
            array('shorturl' => 'That is not a valid short URL'));
        }
        //search for desired URL in the DB
        $repository = $this->getDoctrine()->getRepository('ShorterBundle:Urls');
        if ($repository->findOneByShorturl($shorturl)) {
          return $this->render('ShorterBundle:Shorter:index.html.twig',
            array('shorturl' => 'Desired URL is already in the DB'));
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
      $shorturl="http://".$request->server->get('HTTP_HOST')."/web/".$shorturl;
      return $this->render('ShorterBundle:Shorter:index.html.twig',
        array('shorturl' => $shorturl));
    }
}
