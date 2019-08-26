<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/16/19
 * Time: 1:02 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Core\CoreShellTrait;
use App\Dto\ApartDto\FileDto;
use App\Dto\ApartDto\SettingsDto;
use App\Dto\LogSearchDto;
use App\Entity\Settings;
use App\Rest\Core\RestTrait;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SearchManager
 *
 * @package App\Manager
 */
class SearchManager extends AbstractEntityManager
{
    use CoreShellTrait;

    use RestTrait;

//region SECTION: Fields

    private $programs = ['sed' => '', 'grep' => '', 'cat' => ''];

    /**
     * @var Settings[]
     */
    private $settings;
    private $searchResult = [];

    /**
     * @var LogSearchDto
     */
    private $dto;

    private $step = 5;

    private $settingsManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * SearchManager constructor.
     *
     */
    public function __construct(EntityManagerInterface $entityManager, SettingsManager $settingsManager)
    {
        parent::__construct($entityManager);

        $this->settingsManager = $settingsManager;
    }
//endregion Constructor

//region SECTION: Protected
    /**
     * @param $run
     *
     * @return bool
     */
    protected function executeProgram($run): bool
    {
        exec($run, $this->result);

        return count($this->result) ? true : false;
    }
//endregion Protected

//region SECTION: Public
    /**
     * @param $settingsDto
     *
     * @return Settings[]
     */
    public function saveSettings($settingsDto)
    {
        foreach ($this->getSettings() as $entity) {
            if ($settingsDto[$entity->getId()]) {
                $settingsDto[$entity->getId()]->fillEntity($entity);
            }
        }

        return $this->entityManager->flush();
    }
//endregion Public

//region SECTION: Private
    /**
     * @return $this
     */
    private function loadSettings()
    {
        if ($this->dto) {
            $settingsDto = $this->dto->getFactoryAdapter()->setFrom($this->dto)->setTo(SettingsDto::class)->adapter();
            $this->settings = $this->settingsManager->getSettings($settingsDto);
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function getNumberLineMeet()
    {
        foreach ($this->settings as $setting) {
            $fileDto = $setting->getData();
            if ($fileDto instanceof FileDto) {
                if ($this->dto->hasFile($fileDto->getName())) {
                    $file = $fileDto->getFilePath();
                    $run  = $this->programs['cat'].' '.escapeshellarg($file).' | '.
                        $this->programs['grep'].' -ni \''.escapeshellarg($this->dto->getSearchString()).'\' | '.
                        $this->programs['sed'].' -n \'s/^\\([0-9]*\\)[:].*/\\1/p\'';
                    if ($this->setClean()->executeProgram($run)) {
                        $this->getLineMeet($this->getResult(), $file, $fileDto->getName());
                    }
                }
            }
        }

        return $this;
    }

    /**
     * $files берем активные из настроек
     *
     * @param array  $lines
     * @param string $file
     * @param string $name
     *
     * @return SearchManager
     */
    private function getLineMeet(array $lines, $file, $name)
    {
        $message = [];
        foreach ($lines as $number) {
            $run = $this->programs['sed'].' -n \''.$number.','.($number + $this->step).'p;'.($number + $this->step + 1).'q\' '.$file;
            if ($this->setClean()->executeProgram($run)) {
                $message[] = $this->getResult();
            }
        }
        if (count($message)) {
            $this->searchResult[] = ['file' => $name, 'messages' => $message];
        }

        return $this;
    }

    /**
     * Got to exit, if executable program have't a valid path
     *
     * @return bool
     */
    private function hasProgram(): bool
    {
        foreach ($this->programs as $program => $value) {
            $this->programs[$program] = $this->findProgram($program);
            if (!$this->programs[$program]) {
                return false;
            }
        }

        return true;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param LogSearchDto $logSearchDto
     *
     * @return $this
     */
    public function setDto(LogSearchDto $logSearchDto)
    {
        $this->dto = $logSearchDto;

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return Settings[]
     */
    public function getSettings()
    {
        $this->loadSettings();

        return $this->settings;
    }

    public function getResult()
    {
        $converts = [];
        foreach ($this->result as $value) {
            $string     = preg_replace('/[^[:print:]\r\n]/', '', $value);
            $converts[] = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        }

        return $converts;
    }

    /**
     * @return array
     */
    public function getSearchResult()
    {
        return $this->searchResult;
    }

    /**
     * @return $this
     */
    public function getSearch()
    {
        if ($this->dto) {
            if ($this->hasProgram() && $this->dto->isValidSearchStr()) {
                $this->loadSettings()->getNumberLineMeet();
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getRestStatus(): int
    {
        return $this->status;
    }


//endregion Getters/Setters
}