<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 8/16/19
 * Time: 1:02 PM
 */

namespace App\Manager;


use App\Core\AbstractEntityManager;
use App\Dto\ApartDto\FileDto;
use App\Dto\LogSearchDto;
use App\Dto\SettingsDto;
use App\Entity\Settings;
use App\Rest\Core\RestTrait;
use Doctrine\ORM\EntityManagerInterface;
use Evrinoma\ShellBundle\Core\ShellInterface;

/**
 * Class SearchManager
 *
 * @package App\Manager
 */
class SearchManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields


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

    /**
     * @var ShellInterface
     */
    private $shellManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * SearchManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ShellInterface         $shellManager
     * @param SettingsManager        $settingsManager
     */
    public function __construct(EntityManagerInterface $entityManager, ShellInterface $shellManager, SettingsManager $settingsManager)
    {
        parent::__construct($entityManager);

        $this->settingsManager = $settingsManager;

        $this->shellManager = $shellManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @return Settings[]
     */
    public function saveSettings()
    {
        foreach ($this->getSettings() as $entity) {
            /** @var SettingsDto $item */
            foreach ($this->dto->generatorClone() as $item) {
                if ($item->getId() === $entity->getId()) {
                    $item->fillEntity($entity);
                    break;
                }
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
            $settingsDto    = $this->dto->getFactoryAdapter()->setFrom($this->dto)->setTo(SettingsDto::class)->adapter();
            $this->settings = $this->settingsManager->getSettings($settingsDto);
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    private function getNumberLineMeet()
    {
        foreach ($this->settings as $setting) {
            $fileDto = $setting->getData();
            if ($fileDto instanceof FileDto) {
                if ($this->dto->hasFile($fileDto->getName())) {
                    $file = $fileDto->getFilePath();
                    $run  = $this->shellManager->getProgram('cat').' '.escapeshellarg($file).' | '.
                        $this->shellManager->getProgram('grep').' -ni \''.escapeshellarg($this->dto->getSearchString()).'\' | '.
                        $this->shellManager->getProgram('sed').' -n \'s/^\\([0-9]*\\)[:].*/\\1/p\'';
                    if ($this->shellManager->setClean()->executeProgram($run)) {
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
     * @throws \Exception
     */
    private function getLineMeet(array $lines, $file, $name)
    {
        $message = [];
        foreach ($lines as $number) {
            $run = $this->shellManager->getProgram('sed').' -n \''.$number.','.($number + $this->step).'p;'.($number + $this->step + 1).'q\' '.$file;
            if ($this->shellManager->setClean()->executeProgram($run)) {
                $message[] = $this->getResult();
            }
        }
        if (count($message)) {
            $this->searchResult[] = ['file' => $name, 'messages' => $message];
        }

        return $this;
    }
//endregion Private

//region SECTION: Dto
    /**
     * @param LogSearchDto|SettingsDto $dto
     *
     * @return $this
     */
    public function setDto($dto): self
    {
        $this->dto = $dto;

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return Settings[]
     */
    public function getSettings(): array
    {
        $this->loadSettings();

        return $this->settings;
    }

    public function getResult(): array
    {
        $converts = [];
        foreach ($this->getResult() as $value) {
            $string     = preg_replace('/[^[:print:]\r\n]/', '', $value);
            $converts[] = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        }

        return $converts;
    }

    /**
     * @return array
     */
    public function getSearchResult(): array
    {
        return $this->searchResult;
    }

    /**
     * @return $this
     */
    public function getSearch(): self
    {
        if ($this->dto) {
            if ($this->dto->isValidSearchStr()) {
                try {
                    $this->loadSettings()->getNumberLineMeet();
                } catch (\Exception $exception) {
                    $this->searchResult[] = $exception->getMessage();
                }
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