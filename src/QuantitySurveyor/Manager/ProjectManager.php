<?php


namespace App\QuantitySurveyor\Manager;


use App\Entity\Project;
use App\QuantitySurveyor\AgGrid\ColumnDef;
use Evrinoma\UtilsBundle\Manager\AbstractEntityManager;
use Evrinoma\UtilsBundle\Rest\RestTrait;

class ProjectManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected $repositoryClass = Project::class;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @param $projectDto
     *
     * @return $this
     */
    public function get($projectDto): self
    {
        if ($projectDto) {
            $this->setData($this->repository->setDto($projectDto)->findProject());
        } else {
            $this->setRestClientErrorBadRequest();
        }

        return $this;
    }

    public function getAll()
    {
        return $this->getRepositoryAll($this->repositoryClass)->getData();
    }

    public function getColumnDefs()
    {
        $columnDef = new ColumnDef();
        $columnDef
            ->setField()
            ->setHeaderName()
            ->setWidth();

        return [];
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}