<?php

namespace Politeia\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="Politeia\CoreBundle\Repository\MairieRepository")
 * @ORM\Table(name="p_mairie")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Mairie
{

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id; 
    
    /**
     * @var Kreatys\UserBundle\Entity\Profil
     * @ORM\OneToOne(targetEntity="Kreatys\UserBundle\Entity\Profil", mappedBy="mairie", cascade={"persist", "remove"})
     */
    protected $profil;
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="MairieHoraire", mappedBy="mairie", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $horaires;  
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ville;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $codePostal;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $adresse;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $site;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tel;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $telAnimation;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $telUrbanisme;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $baseline;
    
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $infos;
    
    /**
     * @var File
     * @Vich\UploadableField(mapping="mairie", fileNameProperty="imageName")
     */
    protected $imageFile;
    
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $imageName;
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="News", mappedBy="mairie", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $news;
    
    /**
     * @var AlertePcs
     * @ORM\OneToOne(targetEntity="AlertePcs", inversedBy="mairie", cascade={"persist", "remove"})
     */
    protected $alertePcs;
    
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Planning", mappedBy="mairie", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $plannings;
    
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="AbonnmentMairie", mappedBy="mairie", cascade={"remove"})
     */
    protected $citoyenAbonnes;
    
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="Signalement", mappedBy="mairie", cascade={"remove"})
     */
    protected $signalements;
    
    /*
     * @var ArrayCollection;
     * ORM\OneToMany(targetEntity="BoiteAIdeeTheme", mappedBy="mairie", cascade={"persist", "remove"}, orphanRemoval=true)
     * ORM\OrderBy({"position" = "ASC"})     
    protected $boiteAIdeeThemes;*/
    
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="BoiteAIdeeQuestion", mappedBy="mairie", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"}) 
     */   
    protected $boiteAIdeeQuestions;
    
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="Sondage", mappedBy="mairie", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"created" = "DESC"})
     */
    protected $sondages;
    
    /**
     * @var ArrayCollection 
     * @ORM\ManyToMany(targetEntity="Publicite", mappedBy="mairies")
     */
    protected $publicites;

    /**
     * @var \Datetime $created
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime $updated
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;
    
    /**
     * @var \Boolean $reportsEnabled
     * @ORM\Column(type="boolean", nullable=true, options={"default":"1"})
     */
    protected $reportsEnabled;
    
    /**
     * @var \Boolean $moderatingEnabled
     * @ORM\Column(type="boolean", nullable=true, options={"default":"1"})
     */
    protected $moderatingEnabled;

    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->horaires = new ArrayCollection();
        $this->signalements = new ArrayCollection();
        $this->boiteAIdeeThemes = new ArrayCollection();
        $this->sondages = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->publicites = new ArrayCollection();
        $this->alertePcs = new AlertePcs();
        $this->setReportsEnabled(true);
        $this->setModeratingEnabled(true);
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->ville:'Nouvelle mairie';
    }
    
    /**
     * 
     * @return boolean
     */
    public function isNew() 
    {
        return (int)$this->id === 0;
    }  
    
    /**
     * 
     * @return boolean
     */
    public function isDeletable() 
    {
        return false;
    }    
    
    
    public function getNbCitoyen()
    {
        return $this->citoyenAbonnes->count();
    }


    // Champs virtuel
    
    /**
     * @var string 
     */
    protected $userEmail;
    
    /**
     * 
     * @return string
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * 
     * @param string $userEmail
     * @return Mairie
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;
        return $this;
    }

        
    /**
     * @var string 
     */
    protected $userPlainPassword;
        
    /**
     * 
     * @return string
     */
    public function getUserPlainPassword()
    {
        return $this->userPlainPassword;
    }

    /**
     * 
     * @param string $userPlainPassword
     * @return Mairie
     */
    public function setUserPlainPassword($userPlainPassword)
    {
        $this->userPlainPassword = $userPlainPassword;
        return $this;
    }


    /**
     * Set imageFile
     * 
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Mairie
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new \DateTimeImmutable();
        }
        
        return $this;
    }
 
    /**
     * Get imageFile
     *
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
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
     * Set ville
     *
     * @param string $ville
     * @return Mairie
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return Mairie
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Mairie
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Mairie
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Mairie
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Mairie
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set telAnimation
     *
     * @param string $telAnimation
     * @return Mairie
     */
    public function setTelAnimation($telAnimation)
    {
        $this->telAnimation = $telAnimation;

        return $this;
    }

    /**
     * Get telAnimation
     *
     * @return string 
     */
    public function getTelAnimation()
    {
        return $this->telAnimation;
    }

    /**
     * Set telUrbanisme
     *
     * @param string $telUrbanisme
     * @return Mairie
     */
    public function setTelUrbanisme($telUrbanisme)
    {
        $this->telUrbanisme = $telUrbanisme;

        return $this;
    }

    /**
     * Get telUrbanisme
     *
     * @return string 
     */
    public function getTelUrbanisme()
    {
        return $this->telUrbanisme;
    }

    /**
     * Set baseline
     *
     * @param string $baseline
     * @return Mairie
     */
    public function setBaseline($baseline)
    {
        $this->baseline = $baseline;

        return $this;
    }

    /**
     * Get baseline
     *
     * @return string 
     */
    public function getBaseline()
    {
        return $this->baseline;
    }

    /**
     * Set infos
     *
     * @param string $infos
     * @return Mairie
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string 
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Mairie
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Mairie
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Mairie
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add horaires
     *
     * @param \Politeia\CoreBundle\Entity\MairieHoraire $horaires
     * @return Mairie
     */
    public function addHoraire(\Politeia\CoreBundle\Entity\MairieHoraire $horaires)
    {
        $this->horaires[] = $horaires;

        return $this;
    }

    /**
     * Remove horaires
     *
     * @param \Politeia\CoreBundle\Entity\MairieHoraire $horaires
     */
    public function removeHoraire(\Politeia\CoreBundle\Entity\MairieHoraire $horaires)
    {
        $this->horaires->removeElement($horaires);
    }

    /**
     * Get horaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHoraires()
    {
        return $this->horaires;
    }

    /**
     * Add news
     *
     * @param \Politeia\CoreBundle\Entity\News $news
     * @return Mairie
     */
    public function addNews(\Politeia\CoreBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \Politeia\CoreBundle\Entity\News $news
     */
    public function removeNews(\Politeia\CoreBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set alertePcs
     *
     * @param \Politeia\CoreBundle\Entity\AlertePcs $alertePcs
     * @return Mairie
     */
    public function setAlertePcs(\Politeia\CoreBundle\Entity\AlertePcs $alertePcs = null)
    {
        $this->alertePcs = $alertePcs;

        return $this;
    }

    /**
     * Get alertePcs
     *
     * @return \Politeia\CoreBundle\Entity\AlertePcs 
     */
    public function getAlertePcs()
    {
        return $this->alertePcs;
    }

    /**
     * Add citoyenAbonnes
     *
     * @param \Politeia\CoreBundle\Entity\AbonnmentMairie $citoyenAbonnes
     * @return Mairie
     */
    public function addCitoyenAbonne(\Politeia\CoreBundle\Entity\AbonnmentMairie $citoyenAbonnes)
    {
        $this->citoyenAbonnes[] = $citoyenAbonnes;

        return $this;
    }

    /**
     * Remove citoyenAbonnes
     *
     * @param \Politeia\CoreBundle\Entity\AbonnmentMairie $citoyenAbonnes
     */
    public function removeCitoyenAbonne(\Politeia\CoreBundle\Entity\AbonnmentMairie $citoyenAbonnes)
    {
        $this->citoyenAbonnes->removeElement($citoyenAbonnes);
    }

    /**
     * Get citoyenAbonnes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCitoyenAbonnes()
    {
        return $this->citoyenAbonnes;
    }

    /**
     * Add signalements
     *
     * @param \Politeia\CoreBundle\Entity\Signalement $signalements
     * @return Mairie
     */
    public function addSignalement(\Politeia\CoreBundle\Entity\Signalement $signalements)
    {
        $this->signalements[] = $signalements;

        return $this;
    }

    /**
     * Remove signalements
     *
     * @param \Politeia\CoreBundle\Entity\Signalement $signalements
     */
    public function removeSignalement(\Politeia\CoreBundle\Entity\Signalement $signalements)
    {
        $this->signalements->removeElement($signalements);
    }

    /**
     * Get signalements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSignalements()
    {
        return $this->signalements;
    }

    /**
     * Set profil
     *
     * @param \Kreatys\UserBundle\Entity\Profil $profil
     * @return Mairie
     */
    public function setProfil(\Kreatys\UserBundle\Entity\Profil $profil = null)
    {
        $this->profil = $profil;
        $profil->setMairie($this);

        return $this;
    }

    /**
     * Get profil
     *
     * @return \Kreatys\UserBundle\Entity\Profil 
     */
    public function getProfil()
    {
        return $this->profil;
    }

    

    /**
     * Add boiteAIdeeQuestions
     *
     * @param \Politeia\CoreBundle\Entity\BoiteAIdeeQuestion $boiteAIdeeQuestions
     * @return Mairie
     */
    public function addBoiteAIdeeQuestion(\Politeia\CoreBundle\Entity\BoiteAIdeeQuestion $boiteAIdeeQuestions)
    {
        $this->boiteAIdeeQuestions[] = $boiteAIdeeQuestions;
        $boiteAIdeeQuestions->setMairie($this);

        return $this;
    }

    /**
     * Remove boiteAIdeeQuestions
     *
     * @param \Politeia\CoreBundle\Entity\BoiteAIdeeQuestion $boiteAIdeeQuestions
     */
    public function removeBoiteAIdeeQuestion(\Politeia\CoreBundle\Entity\BoiteAIdeeQuestion $boiteAIdeeQuestions)
    {
        $this->boiteAIdeeQuestions->removeElement($boiteAIdeeQuestions);
    }

    /**
     * Get boiteAIdeeQuestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBoiteAIdeeQuestions()
    {
        return $this->boiteAIdeeQuestions;
    }

    /**
     * Add sondages
     *
     * @param \Politeia\CoreBundle\Entity\Sondage $sondages
     * @return Mairie
     */
    public function addSondage(\Politeia\CoreBundle\Entity\Sondage $sondages)
    {
        $this->sondages[] = $sondages;
        $sondages->setMairie($this);

        return $this;
    }

    /**
     * Remove sondages
     *
     * @param \Politeia\CoreBundle\Entity\Sondage $sondages
     */
    public function removeSondage(\Politeia\CoreBundle\Entity\Sondage $sondages)
    {
        $this->sondages->removeElement($sondages);
    }

    /**
     * Get sondages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSondages()
    {
        return $this->sondages;
    }

    /**
     * Add plannings
     *
     * @param \Politeia\CoreBundle\Entity\Planning $plannings
     * @return Mairie
     */
    public function addPlanning(\Politeia\CoreBundle\Entity\Planning $plannings)
    {
        $this->plannings[] = $plannings;
        $plannings->setMairie($this);

        return $this;
    }

    /**
     * Remove plannings
     *
     * @param \Politeia\CoreBundle\Entity\Planning $plannings
     */
    public function removePlanning(\Politeia\CoreBundle\Entity\Planning $plannings)
    {
        $this->plannings->removeElement($plannings);
    }

    /**
     * Get plannings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPlannings()
    {
        return $this->plannings;
    }

    /**
     * Add publicites
     *
     * @param \Politeia\CoreBundle\Entity\Publicite $publicites
     * @return Mairie
     */
    public function addPublicite(\Politeia\CoreBundle\Entity\Publicite $publicites)
    {
        $this->publicites[] = $publicites;

        return $this;
    }

    /**
     * Remove publicites
     *
     * @param \Politeia\CoreBundle\Entity\Publicite $publicites
     */
    public function removePublicite(\Politeia\CoreBundle\Entity\Publicite $publicites)
    {
        $this->publicites->removeElement($publicites);
    }

    /**
     * Get publicites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublicites()
    {
        return $this->publicites;
    }

    /**
     * Set reportsEnabled
     *
     * @param \boolean $reportsEnabled
     * @return Mairie
     */
    public function setReportsEnabled($reportsEnabled)
    {
        $this->reportsEnabled = $reportsEnabled;

        return $this;
    }

    /**
     * Get reportsEnabled
     *
     * @return \boolean
     */
    public function getReportsEnabled()
    {
        return $this->reportsEnabled;
    }
    
    /**
     * Set moderatingEnabled
     *
     * @param \boolean $moderatingEnabled
     * @return Mairie
     */
    public function setModeratingEnabled($moderatingEnabled)
    {
        $this->moderatingEnabled = $moderatingEnabled;

        return $this;
    }

    /**
     * Get moderatingsEnabled
     *
     * @return \boolean
     */
    public function getModeratingEnabled()
    {
        return $this->moderatingEnabled;
    }
}
