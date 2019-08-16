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
use App\Dto\FileDto;
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
    private $searchStr    = '';
    private $step         = 5;

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

//region SECTION: Private
    /**
     * @return $this
     */
    private function loadSettings()
    {
        $this->settings = $this->settingsManager->getFiles(SearchManager::class);

        return $this;
    }

    /**
     * $files берем активные из настроек
     */
    private function getNumberLineMeet()
    {
        foreach ($this->settings as $setting) {
            $fileDto = $setting->getData();
            if ($fileDto instanceof FileDto) {
                $file = $fileDto->getFilePath();
                $run  = $this->programs['cat'].' '.escapeshellarg($file).' | '.
                    $this->programs['grep'].' -ni \''.escapeshellarg($this->searchStr).'\' | '.
                    $this->programs['sed'].' -n \'s/^\\([0-9]*\\)[:].*/\\1/p\'';
                if ($this->setClean()->executeProgram($run)) {
                    $this->getLineMeet($this->getResult(), $file, $fileDto->getName());
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
//        $name = mb_strcut(mb_strrchr($file, '/'), 1, mb_strlen($file));
        foreach ($lines as $number) {
            $run = $this->programs['sed'].' -n \''.$number.','.($number + $this->step).'p;'.($number + $this->step + 1).'q\' '.$file;
            if ($this->setClean()->executeProgram($run)) {
                $this->searchResult[$name][] = $this->getResult();
            }
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

    /**
     * @return int
     */
    private function isSearchStr()
    {
        return $this->searchStr !== '';
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return array
     */
    public function getSearchResult(): array
    {
        return $this->searchResult;
    }

    /**
     * @return string
     */
    public function getSearchStr(): string
    {
        return $this->searchStr;
    }

    /**
     * @return $this
     */
    public function getSearch()
    {
        if ($this->hasProgram() && $this->isSearchStr()) {

            $this->loadSettings()->getNumberLineMeet();
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

    /**
     * @param array $files
     *
     * @return SearchManager
     */
    public function setFiles(array $files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @param string $searchStr
     *
     * @return SearchManager
     */
    public function setSearchStr($searchStr)
    {
        if ($searchStr) {
            $this->searchStr = $searchStr;
        }

        return $this;
    }
//endregion Getters/Setters
}