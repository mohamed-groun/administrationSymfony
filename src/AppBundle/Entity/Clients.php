<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clients
 *
 * @ORM\Table(name="clients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientsRepository")
 */
class Clients
{
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
     * @ORM\Column(name="nomc", type="string", length=255)
     */
    private $nomc;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var array
     *
     * @ORM\Column(name="type", type="array")
     */
    private $type;



    /**
     * @return array
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param array $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomc
     *
     * @param string $nomc
     *
     * @return Clients
     */
    public function setNomc($nomc)
    {
        $this->nomc = $nomc;

        return $this;
    }

    /**
     * Get nomc
     *
     * @return string
     */
    public function getNomc()
    {
        return $this->nomc;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    public function getWebPath(){
        return null=== $this->url ? null : $this->getUploadDir.'/'.$this->nomc;
    }

    protected  function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected  function getUploadDir(){
        return 'gallery/';
    }

    public function uploadGallery(){

        $this->url->move(
            $this->getUploadRootDir(),
            $this->url->getClientOriginalName());
        $this->url=$this->url->getClientOriginalName();
        $this->file=null ;

    }
}

