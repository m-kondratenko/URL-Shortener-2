<?php

namespace ShorterBundle\Entity;

use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Urls
 *
 * @ORM\Table(name="urls")
 * @ORM\Entity(repositoryClass="ShorterBundle\Repository\UrlsRepository")
 */
class Urls
{
    public function verifyLongUrl($url) {
      $curl=curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_exec($curl);
      $response=curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      return (!empty($response)&&$response!=404);
    }

    public function generateShortURL(){
      $shorturl='';
      $base="0123456789abcdefghijklmnopqrstuvwxyz";
      $count=rand(1, 6);
      $length=strlen($base);
      for ($i=1; $i<=$count; $i++) {
        $shorturl.=$base[rand(0, $length)];
      }
      return $shorturl;
    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="longurl", type="string", length=255)
     */
    private $longurl;

    /**
     * @var string
     *
     * @ORM\Column(name="shorturl", type="string", length=255)
     */
    private $shorturl;

    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime", length=0)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="counting", type="decimal", length=10)
     */
    private $counting;

    /**
     * constructor
     */
    public function __construct()
    {
      //$this->date = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set longurl
     *
     * @param string $longurl
     * @return Urls
     */
    public function setLongurl($longurl)
    {
        $this->longurl = $longurl;

        return $this;
    }

    /**
     * Get longurl
     *
     * @return string
     */
    public function getLongurl()
    {
        return $this->longurl;
    }

    /**
     * Set shorturl
     *
     * @param string $shorturl
     * @return Urls
     */
    public function setShorturl($shorturl)
    {
        $this->shorturl = $shorturl;

        return $this;
    }

    /**
     * Get shorturl
     *
     * @return string
     */
    public function getShorturl()
    {
        return $this->shorturl;
    }

    /**
     * Set date
     *
     * @param \datetime $date
     * @return Urls
     */
    public function setDate()
    {
        //$this->date = $date;
        $this->date = new \DateTime();

        return $this;
    }

    /**
     * Get date
     *
     * @return \datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set counting
     *
     * @param string $counting
     * @return Urls
     */
    public function setCounting($counting)
    {
        $this->counting = $counting;

        return $this;
    }

    /**
     * Get counting
     *
     * @return string
     */
    public function getCounting()
    {
        return $this->counting;
    }
}
