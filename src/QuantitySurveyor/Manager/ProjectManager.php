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
        $id = new ColumnDef();
        $id->setType(ColumnDef::NUMBER_COLUMN)->setHeaderName('ID')->setField('id')->setWidth(100)->setEditable()->setResizable();

        $name = new ColumnDef();
        $name->setHeaderName('Название')->setField('name')->setWidth(200);

        $dateStart = new ColumnDef();
        $dateStart->setType(ColumnDef::DATE_COLUMN)->setHeaderName('Дата начала')->setField('dateStart')->setWidth(140);

        $dateFinish = new ColumnDef();
        $dateFinish->setType(ColumnDef::DATE_COLUMN)->setHeaderName('Дата окончания')->setField('dateFinish')->setWidth(140);

        $description = new ColumnDef();
        $description->setHeaderName('Описание')->setField('description')->setWidth(140);

        return [$id, $name, $dateStart, $dateFinish, $description];
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}