<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use \DateTime;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Vich\Uploadable
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Veuillez rentrer une adresse mail valide")
     * @Assert\Length(max="180", allowEmptyString="false")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", allowEmptyString="false", maxMessage="Ce champ est trop long")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max="100", allowEmptyString="false", maxMessage="Ce champ est trop long")
     * @Assert\NotBlank(message="Ce champ ne doit pas être vide")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     * @Assert\Length(max="45", maxMessage="Ce champ est trop long")
     */
    private $fonction;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $entryDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $userPicture;

    /**
     * @Vich\UploadableField(mapping="picture_file", fileNameProperty="userPicture")
     * @Assert\File(
     *     maxSize = "1024k",
     *     maxSizeMessage = "Les fichiers de plus de 1Mo ne sont pas autorisés",
     *     uploadIniSizeErrorMessage = "Les fichiers de plus de 1Mo ne sont pas autorisés"
     * )
     * @var File | null
     */
    private $pictureFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $linkedin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $facebook;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, mappedBy="users")
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity=Method::class, mappedBy="contact")
     */
    private $methods;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $greenSkills1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $greenSkills2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Ce champ est trop long")
     */
    private $greenSkills3;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Length(max="10", allowEmptyString="false", maxMessage="Veuillez entrer un numéro à 10 chiffres")
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Le numéro de téléphone ne doit contenir que des chiffres")
     */
    private $phone;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->methods = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->userPicture;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getEntryDate(): ?\DateTimeInterface
    {
        return $this->entryDate;
    }

    public function setEntryDate(?\DateTimeInterface $entryDate): self
    {
        $this->entryDate = $entryDate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUserPicture(): ?string
    {
        return $this->userPicture;
    }

    public function setUserPicture(?string $userPicture): self
    {
        $this->userPicture = $userPicture;

        return $this;
    }

    public function setPictureFile(File $picture = null): User
    {
        $this->pictureFile = $picture;
        if ($picture) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->addUser($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            $team->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Method[]
     */
    public function getMethods(): Collection
    {
        return $this->methods;
    }

    public function addMethod(Method $method): self
    {
        if (!$this->methods->contains($method)) {
            $this->methods[] = $method;
            $method->addContact($this);
        }
    }

    public function getGreenSkills1(): ?string
    {
        return $this->greenSkills1;
    }

    public function setGreenSkills1(?string $greenSkills1): self
    {
        $this->greenSkills1 = $greenSkills1;

        return $this;
    }


    public function removeMethod(Method $method): self
    {
        if ($this->methods->contains($method)) {
            $this->methods->removeElement($method);
            $method->removeContact($this);
        }
    }

    public function getGreenSkills2(): ?string
    {
        return $this->greenSkills2;
    }

    public function setGreenSkills2(?string $greenSkills2): self
    {
        $this->greenSkills2 = $greenSkills2;

        return $this;
    }

    public function getGreenSkills3(): ?string
    {
        return $this->greenSkills3;
    }

    public function setGreenSkills3(?string $greenSkills3): self
    {
        $this->greenSkills3 = $greenSkills3;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
