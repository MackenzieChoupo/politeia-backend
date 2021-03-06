<?php

namespace Politeia\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Politeia\CoreBundle\Repository\CitoyenRepository")
 * @ORM\Table(name="p_citoyen")
 * @ORM\HasLifecycleCallbacks()
 */
class Citoyen
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $nom;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $prenom;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;
    /**
     * @var string
     * @ORM\Column(type="string", length=1, options={"fixed" = true})
     */
    protected $sexe;
    const SEXE_HOMME = 'h';
    const SEXE_FEMME = 'f';
    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=true)
     */
    protected $dateNaissance;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $adresse;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $adresse2;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $cp;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $ville;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $tel;
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="AbonnmentMairie", mappedBy="citoyen", cascade={"persist", "remove"},
     *                                                orphanRemoval=true)
     */
    protected $abonnementMairies;
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="Signalement", mappedBy="citoyen")
     */
    protected $signalements;
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="ConfirmationSignalement", mappedBy="citoyen")
     */
    protected $confirmationsSignalements;
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="BoiteAIdeeReponse", mappedBy="citoyen", cascade={"persist", "remove"},
     *                                                  orphanRemoval=true)
     */
    protected $boiteAIdeeReponses;
    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="SondageVote", mappedBy="citoyen")
     */
    protected $sondageVotes;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $username;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $password;
    /**
     * @var string
     */
    protected $plainPassword;
    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $enabled;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $salt;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastLogin;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $token;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $deviceToken;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;
    /**
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $locked;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $created;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    public function __construct() {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->abonnementMairies = new ArrayCollection();
        $this->signalements = new ArrayCollection();
        $this->confirmationsSignalements = new ArrayCollection();
        $this->boiteAIdeeReponses = new ArrayCollection();
        $this->sondageVotes = new ArrayCollection();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->enabled = true;
        $this->locked = false;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue() {
        $this->setUpdated(new \DateTime());
    }
    
    /**
     *
     * @return string
     */
    public function __toString() {
        return (string)$this->getUsername();
    }
    
    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials() {
        $this->plainPassword = null;
    }
    
    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword() {
        return $this->plainPassword;
    }
    
    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     * @return Citoyen
     */
    public function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
        
        return $this;
    }
    
    /**
     *
     * @return string
     */
    public function getPrenomNom() {
        return $this->prenom . ' ' . $this->nom;
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * Set nom
     *
     * @param string $nom
     * @return Citoyen
     */
    public function setNom($nom) {
        $this->nom = $nom;
        
        return $this;
    }
    
    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }
    
    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Citoyen
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        
        return $this;
    }
    
    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }
    
    /**
     * Set email
     *
     * @param string $email
     * @return Citoyen
     */
    public function setEmail($email) {
        $this->email = $email;
        
        return $this;
    }
    
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * Set sexe
     *
     * @param string $sexe
     * @return Citoyen
     */
    public function setSexe($sexe) {
        $this->sexe = $sexe;
        
        return $this;
    }
    
    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe() {
        return $this->sexe;
    }
    
    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Citoyen
     */
    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;
        
        return $this;
    }
    
    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance() {
        return $this->dateNaissance;
    }
    
    /**
     * Set adresse
     *
     * @param string $adresse
     * @return Citoyen
     */
    public function setAdresse($adresse) {
        $this->adresse = $adresse;
        
        return $this;
    }
    
    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse() {
        return $this->adresse;
    }
    
    /**
     * Set adresse2
     *
     * @param string $adresse2
     * @return Citoyen
     */
    public function setAdresse2($adresse2) {
        $this->adresse2 = $adresse2;
        
        return $this;
    }
    
    /**
     * Get adresse2
     *
     * @return string
     */
    public function getAdresse2() {
        return $this->adresse2;
    }
    
    /**
     * Set cp
     *
     * @param string $cp
     * @return Citoyen
     */
    public function setCp($cp) {
        $this->cp = $cp;
        
        return $this;
    }
    
    /**
     * Get cp
     *
     * @return string
     */
    public function getCp() {
        return $this->cp;
    }
    
    /**
     * Set ville
     *
     * @param string $ville
     * @return Citoyen
     */
    public function setVille($ville) {
        $this->ville = $ville;
        
        return $this;
    }
    
    /**
     * Get ville
     *
     * @return string
     */
    public function getVille() {
        return $this->ville;
    }
    
    /**
     * Set tel
     *
     * @param string $tel
     * @return Citoyen
     */
    public function setTel($tel) {
        $this->tel = $tel;
        
        return $this;
    }
    
    /**
     * Get tel
     *
     * @return string
     */
    public function getTel() {
        return $this->tel;
    }
    
    /**
     * Set username
     *
     * @param string $username
     * @return Citoyen
     */
    public function setUsername($username) {
        $this->username = $username;
        
        return $this;
    }
    
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }
    
    /**
     * Set password
     *
     * @param string $password
     * @return Citoyen
     */
    public function setPassword($password) {
        $this->password = $password;
        
        return $this;
    }
    
    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
    
    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Citoyen
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;
        
        return $this;
    }
    
    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled() {
        return $this->enabled;
    }
    
    /**
     * Set salt
     *
     * @param string $salt
     * @return Citoyen
     */
    public function setSalt($salt) {
        $this->salt = $salt;
        
        return $this;
    }
    
    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }
    
    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return Citoyen
     */
    public function setLastLogin($lastLogin) {
        $this->lastLogin = $lastLogin;
        
        return $this;
    }
    
    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin() {
        return $this->lastLogin;
    }
    
    /**
     * Set token
     *
     * @param string $token
     * @return Citoyen
     */
    public function setToken($token) {
        $this->token = $token;
        
        return $this;
    }
    
    /**
     * Get token
     *
     * @return string
     */
    public function getToken() {
        return $this->token;
    }
    
    /**
     * Set passwordRequestedAt
     *
     * @param \DateTime $passwordRequestedAt
     * @return Citoyen
     */
    public function setPasswordRequestedAt($passwordRequestedAt) {
        $this->passwordRequestedAt = $passwordRequestedAt;
        
        return $this;
    }
    
    /**
     * Get passwordRequestedAt
     *
     * @return \DateTime
     */
    public function getPasswordRequestedAt() {
        return $this->passwordRequestedAt;
    }
    
    /**
     * Set locked
     *
     * @param boolean $locked
     * @return Citoyen
     */
    public function setLocked($locked) {
        $this->locked = $locked;
        
        return $this;
    }
    
    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked() {
        return $this->locked;
    }
    
    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Citoyen
     */
    public function setCreated($created) {
        $this->created = $created;
        
        return $this;
    }
    
    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }
    
    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Citoyen
     */
    public function setUpdated($updated) {
        $this->updated = $updated;
        
        return $this;
    }
    
    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }
    
    /**
     * Add abonnementMairies
     *
     * @param \Politeia\CoreBundle\Entity\AbonnmentMairie $abonnementMairies
     * @return Citoyen
     */
    public function addAbonnementMairy(\Politeia\CoreBundle\Entity\AbonnmentMairie $abonnementMairies) {
        $this->abonnementMairies[] = $abonnementMairies;
        $abonnementMairies->setCitoyen($this);
        
        return $this;
    }
    
    /**
     * Remove abonnementMairies
     *
     * @param \Politeia\CoreBundle\Entity\AbonnmentMairie $abonnementMairies
     */
    public function removeAbonnementMairy(\Politeia\CoreBundle\Entity\AbonnmentMairie $abonnementMairies) {
        $this->abonnementMairies->removeElement($abonnementMairies);
    }
    
    /**
     * Get abonnementMairies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAbonnementMairies() {
        return $this->abonnementMairies;
    }
    
    /**
     * Add signalements
     *
     * @param \Politeia\CoreBundle\Entity\Signalement $signalements
     * @return Citoyen
     */
    public function addSignalement(\Politeia\CoreBundle\Entity\Signalement $signalements) {
        $this->signalements[] = $signalements;
        
        return $this;
    }
    
    /**
     * Remove signalements
     *
     * @param \Politeia\CoreBundle\Entity\Signalement $signalements
     */
    public function removeSignalement(\Politeia\CoreBundle\Entity\Signalement $signalements) {
        $this->signalements->removeElement($signalements);
    }
    
    /**
     * Get signalements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSignalements() {
        return $this->signalements;
    }
    
    /**
     * Add confirmationsSignalements
     *
     * @param \Politeia\CoreBundle\Entity\ConfirmationSignalement $confirmationsSignalements
     * @return Citoyen
     */
    public function addConfirmationsSignalement(
        \Politeia\CoreBundle\Entity\ConfirmationSignalement $confirmationsSignalements
    ) {
        $this->confirmationsSignalements[] = $confirmationsSignalements;
        
        return $this;
    }
    
    /**
     * Remove confirmationsSignalements
     *
     * @param \Politeia\CoreBundle\Entity\ConfirmationSignalement $confirmationsSignalements
     */
    public function removeConfirmationsSignalement(
        \Politeia\CoreBundle\Entity\ConfirmationSignalement $confirmationsSignalements
    ) {
        $this->confirmationsSignalements->removeElement($confirmationsSignalements);
    }
    
    /**
     * Get confirmationsSignalements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConfirmationsSignalements() {
        return $this->confirmationsSignalements;
    }
    
    /**
     * Add boiteAIdeeReponses
     *
     * @param \Politeia\CoreBundle\Entity\BoiteAIdeeReponse $boiteAIdeeReponses
     * @return Citoyen
     */
    public function addBoiteAIdeeReponse(\Politeia\CoreBundle\Entity\BoiteAIdeeReponse $boiteAIdeeReponses) {
        $this->boiteAIdeeReponses[] = $boiteAIdeeReponses;
        $boiteAIdeeReponses->setCitoyen($this);
        
        return $this;
    }
    
    /**
     * Remove boiteAIdeeReponses
     *
     * @param \Politeia\CoreBundle\Entity\BoiteAIdeeReponse $boiteAIdeeReponses
     */
    public function removeBoiteAIdeeReponse(\Politeia\CoreBundle\Entity\BoiteAIdeeReponse $boiteAIdeeReponses) {
        $this->boiteAIdeeReponses->removeElement($boiteAIdeeReponses);
    }
    
    /**
     * Get boiteAIdeeReponses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBoiteAIdeeReponses() {
        return $this->boiteAIdeeReponses;
    }
    
    /**
     * Add sondageVotes
     *
     * @param \Politeia\CoreBundle\Entity\SondageVote $sondageVotes
     * @return Citoyen
     */
    public function addSondageVote(\Politeia\CoreBundle\Entity\SondageVote $sondageVotes) {
        $this->sondageVotes[] = $sondageVotes;
        
        return $this;
    }
    
    /**
     * Remove sondageVotes
     *
     * @param \Politeia\CoreBundle\Entity\SondageVote $sondageVotes
     */
    public function removeSondageVote(\Politeia\CoreBundle\Entity\SondageVote $sondageVotes) {
        $this->sondageVotes->removeElement($sondageVotes);
    }
    
    /**
     * Get sondageVotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSondageVotes() {
        return $this->sondageVotes;
    }
    
    /**
     * Set deviceToken
     *
     * @param string $deviceToken
     * @return Citoyen
     */
    public function setDeviceToken($deviceToken) {
        $this->deviceToken = $deviceToken;
        
        return $this;
    }
    
    /**
     * Get token
     *
     * @return string
     */
    public function getDeviceToken() {
        return $this->deviceToken;
    }
}
