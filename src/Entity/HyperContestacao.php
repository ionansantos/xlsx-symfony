<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation as API;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @API\ApiResource(
 * collectionOperations={
 * "importarPlanilha" ={
 *      "method"="POST",
 *      "path"="/importarPlanilha", 
 *      "controller"="App\Controller\ContestacaoController::importarPlanilha",
 *      "deserialize"=false,
 *  },
 * "exportarPlanilha" = {
 *      "method" = "GET",
 *      "path"="/exportarPlanilha",
 *      "controller"="App\Controller\ContestacaoController::exportarPlanilha",
 * }
 * },
 * attributes={
 *      "input_formats"={"json"={"application/ld+json", "application/json"}},
 *      "output_formats"={"json"={"application/ld+json", "application/json"}}
 * },
 *  itemOperations={}
 * )
 */
class HyperContestacao
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $mesInicial;

    /**
     * @ORM\Column(type="integer")
     */
    private $anoInicial;

    /**
     * @ORM\Column(type="integer")
     */
    private $mesFinal;

    /**
     * @ORM\Column(type="integer")
     */
    private $anoFinal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataImportacao;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usuario;


     /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $observacao;



    // Métodos Getter e Setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMesInicial(): ?int
    {
        return $this->mesInicial;
    }

    public function setMesInicial(?int $mesInicial): self
    {
        $this->mesInicial = $mesInicial;

        return $this;
    }

    public function getAnoInicial(): ?int
    {
        return $this->anoInicial;
    }

    public function setAnoInicial(?int $anoInicial): self
    {
        $this->anoInicial = $anoInicial;

        return $this;
    }

    public function getMesFinal(): ?int
    {
        return $this->mesFinal;
    }

    public function setMesFinal(?int $mesFinal): self
    {
        $this->mesFinal = $mesFinal;

        return $this;
    }

    public function getAnoFinal(): ?int
    {
        return $this->anoFinal;
    }

    public function setAnoFinal(?int $anoFinal): self
    {
        $this->anoFinal = $anoFinal;

        return $this;
    }

    public function getDataImportacao(): ?\DateTimeInterface
    {
        return $this->dataImportacao;
    }

    public function setDataImportacao(\DateTimeInterface $dataImportacao): self
    {
        $this->dataImportacao = $dataImportacao;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(?string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function setObservacao(?string $observacao): self
    {
        $this->observacao = $observacao;

        return $this;
    }
}
