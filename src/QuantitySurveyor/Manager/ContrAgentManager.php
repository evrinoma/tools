<?php


namespace App\QuantitySurveyor\Manager;


use App\Entity\Contragent;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

final class ContrAgentManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = ContrAgent::class;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @param $contrAgentDto
     *
     * @return $this
     */
    public function get($contrAgentDto): self
    {
        if ($contrAgentDto) {
            $this->setData($this->repository->setDto($contrAgentDto)->findProject());
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }

    public function getAll()
    {
        return $this->getRepositoryAll($this->repositoryClass)->getData();
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}