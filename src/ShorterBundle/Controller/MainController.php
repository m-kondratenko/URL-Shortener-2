<?php

namespace ShorterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ShorterBundle\Entity\Urls;
use Symfony\Component\Validator\Constraints\DateTime;

class MainController extends Controller
{
    public function indexAction()
    {
      //check for 15 days expiration
      $difftime = new \DateTime();
      $difftime->modify('-15 days');
      $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery('SELECT u FROM ShorterBundle:Urls u WHERE u.date <= :difftime')
        ->setParameter('difftime', $difftime);
      $urls = $query->getResult();

      //delete URLs pairs if any
      foreach ($urls as $key) {
        $em->remove($key);
      }
      $em->flush();
      return $this->render('::base.html.twig');
    }
}
