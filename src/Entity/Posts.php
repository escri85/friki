<?php

namespace App\Entity;

use App\Repository\PostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PostsRepository::class)]
 
class Posts
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;


     #[ORM\Column(type: 'string', length: 50)]

    private $titulo;


     #[ORM\Column(type: 'string', length: 100, nullable: true)]

    private $likes;

     #[ORM\Column(type: 'string', length: 255, nullable: true)]

    private $foto;

    
     #[ORM\Column(type: 'datetime')]
     
    private $fecha_publicacion;

    
     #[ORM\Column(type: 'string', length: 10000)]
     
    private $contenido;

    #[ORM\OneToMany(targetEntity: "App\Entity\Comentarios", mappedBy: "posts")]
    private $comentarios;
   
    #[ORM\ManyToOne(targetEntity: "App\Entity\User", inversedBy: "posts")]
    private $user;

      /**
      Posts constructor.
     */

    public function __construct()
    {
        $this->comentarios = new ArrayCollection();
        $this->likes='';
        $this->fecha_publicacion=new \DateTime();
    }
 


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getLikes(): ?string
    {
        return $this->likes;
    }

    public function setLikes(?string $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * @return Collection<int, Comentarios>
     */
    public function getComentarios(): Collection
    {
        return $this->comentarios;
    }

    public function addComentario(Comentarios $comentario): self
    {
        if (!$this->comentarios->contains($comentario)) {
            $this->comentarios[] = $comentario;
            $comentario->setPosts($this);
        }

        return $this;
    }

    public function removeComentario(Comentarios $comentario): self
    {
        if ($this->comentarios->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getPosts() === $this) {
                $comentario->setPosts(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
