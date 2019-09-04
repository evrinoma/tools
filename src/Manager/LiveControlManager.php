<?php
/**
 * Created by PhpStorm.
 * User: nikolns
 * Date: 9/3/19
 * Time: 8:30 AM
 */

namespace App\Manager;

use App\Core\AbstractEntityManager;
use App\Dto\LiveVideoDto;
use App\Entity\LiveVideo\Cam;
use App\Rest\Core\RestTrait;
use Doctrine\ORM\EntityManagerInterface;
use ponvif;

/**
 * Class LiveControlManager
 *
 * @package App\Manager
 */
class LiveControlManager extends AbstractEntityManager
{
    use RestTrait;

//region SECTION: Fields
    const ACTION_TOP                              = 'actionTop';
    const ACTION_BOTTOM                           = 'actionBottom';
    const ACTION_LEFT                             = 'actionLeft';
    const ACTION_RIGHT                            = 'actionRight';
    const ACTION_ZOOM_IN                          = 'actionZoomIn';
    const ACTION_ZOOM_OUT                         = 'actionZoomOut';
    const ACTION_SAVE_POSITION_AND_MOVE_TO_PRESET = 'actionSavePositionAndMoveToPreset';
    const ACTION_MOVE_TO_PRESET                   = 'actionMoveToPreset';
    const ACTION_RETURN_FROM_PRESET               = 'actionReturnFromPreset';
    const DELETE_ALL_PRESETS_BY_NAME              = 'deleteAllPresetsByName';
    /**
     * @var array
     */
    private $actions = [
        self::ACTION_TOP,
        self::ACTION_BOTTOM,
        self::ACTION_LEFT,
        self::ACTION_RIGHT,
        self::ACTION_ZOOM_IN,
        self::ACTION_ZOOM_OUT,
        self::ACTION_SAVE_POSITION_AND_MOVE_TO_PRESET,
        self::ACTION_MOVE_TO_PRESET,
        self::ACTION_RETURN_FROM_PRESET,
        self::DELETE_ALL_PRESETS_BY_NAME,
    ];
    /**
     * @var null
     */
    private $action;
    /**
     * @var null | ponvif
     */
    private $onvif;
    /**
     * @var string
     */
    private $presetCallToken = '';
    /**
     * @var string
     */
    private $presetSaveToken = '300';
    /**
     * @var string
     */
    private $presetSaveName = 'Save current';
    /**
     * @var null| Cam
     */
    private $camera = null;
    /**
     * @var LiveVideoManager
     */
    private $liveVideoManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * LiveControlManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param LiveVideoManager       $liveVideoManager
     */
    public function __construct(EntityManagerInterface $entityManager, LiveVideoManager $liveVideoManager)
    {
        parent::__construct($entityManager);

        $this->liveVideoManager = $liveVideoManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param LiveVideoDto $liveVideoDto
     *
     * @return $this
     */
    public function controlAction($liveVideoDto)
    {
        $cams = $this->liveVideoManager->getCamera($liveVideoDto)->getData();

        foreach ($cams as $camera) {
            $this->makeAction($camera);
            if (!$this->isRestStatusOk()) {
                return $this;
            }
        }

        return $this;
    }
//endregion Public

//region SECTION: Private
    /**
     * @param Cam $camera
     *
     * @return $this
     * @throws \Exception
     */
    private function makeAction($camera)
    {
        $this->setRestServerErrorUnknownError();

        if ($this->action) {
            if ($camera->isControl()) {
                $this->onvif = new ponvif();
                $this->onvif->setIPAddress($camera->getIp());
                $this->onvif->setUsername($camera->getUserName());
                $this->onvif->setPassword($camera->getPassword());
                $this->onvif->initialize();
                $token = null;
                foreach ($this->onvif->media_GetProfiles() as $source) {
                    if (isset($source['PTZConfiguration']) && isset($source['@attributes']) && isset($source['@attributes']['token'])) {
                        $token = $source['@attributes']['token'];
                        break;
                    }
                }
                if (null !== $token) {
                    if ($this->isActionCallable($this->action)) {
                        $this->{$this->action}($token);
                        $this->setRestSuccessOk();
                    } else {
                        $this->setRestServerErrorServiceUnavailable();
                    }
                }
            } else {
                $this->setRestSuccessOk();
            }
        }

        return $this;
    }

    /**
     * @param $action
     *
     * @return bool
     */
    private function isActionCallable($action)
    {
        if (in_array($action, $this->actions, true)) {
            if (is_callable(array($this, $action))) {
                return true;
            }
        }

        return false;
    }

    private function actionLeft($token)
    {
        $this->onvif->ptz_RelativeMove($token, -0.01, 0, 0, 0);
    }

    private function actionRight($token)
    {
        $this->onvif->ptz_RelativeMove($token, 0.01, 0, 0, 0);
    }

    private function actionTop($token)
    {
        $this->onvif->ptz_RelativeMove($token, 0, 0.05, 0, 0);
    }

    private function actionBottom($token)
    {
        $this->onvif->ptz_RelativeMove($token, 0, -0.05, 0, 0);
    }

    private function actionZoomIn($token)
    {
        $this->onvif->ptz_RelativeMoveZoom($token, 0.1, 0);
    }

    private function actionZoomOut($token)
    {
        $this->onvif->ptz_RelativeMoveZoom($token, -0.1, 0);
    }

    private function actionSavePositionAndMoveToPreset($token)
    {
        $this->createSavePreset($token);
        $this->moveToPreset($token);
    }

    private function actionMoveToPreset($token)
    {
        $this->moveToPreset($token);
    }

    private function actionReturnFromPreset($token)
    {
        $this->moveToSavePreset($token);
        //  $this->deletePresetByToken($token, $this->presetSaveToken);
    }

    private function deletePresetByToken($token, $tokenName)
    {
        $this->onvif->ptz_RemovePreset($token, $tokenName);
    }

    private function moveToPresetPosition($token, $tokenName)
    {
        if ($this->presetCallToken !== '') {
            $presets = $this->onvif->ptz_GetPresets($token);
            foreach ($presets as $preset) {
                if ($tokenName === $preset["Token"]) {
                    $x    = $preset['PTZPosition']['PanTilt']['@attributes']['x'];
                    $y    = $preset['PTZPosition']['PanTilt']['@attributes']['y'];
                    $zoom = $preset['PTZPosition']['Zoom']['@attributes']['x'];
                    $this->onvif->ptz_GotoPreset($token, $preset['Token'], $x, $y, $zoom);

                    break;
                }
            }
        }
    }

    private function moveToPreset($token)
    {
        $this->moveToPresetPosition($token, $this->presetCallToken);
    }

    private function moveToSavePreset($token)
    {
        $this->moveToPresetPosition($token, $this->presetSaveToken);
    }

    private function createSavePreset($token)
    {
        $this->onvif->ptz_SetPreset($token, $this->presetSaveName, $this->presetSaveToken);
    }

    private function deleteAllPresetsByName($token)
    {
        $presets = $this->onvif->ptz_GetPresets($token);
        foreach ($presets as $preset) {
            if ($this->presetSaveName === $preset["Name"]) {
                $this->deletePresetByToken($token, $preset["Token"]);
            }
        }
    }

    private function getPreset($token)
    {
        $this->onvif->ptz_GetPresets($token);
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getModelActions()
    {
        return $this->actions;
    }

    /**
     * @param string $style
     *
     * @return string
     */
    public function getControl($style = '')
    {
        $html = '';
        $html .= '<div class="livecontrol-actions" object="'.$this->camera->getName().'"';
        $html .= 'style="';
        $html .= $style;
        $html .= (($this->camera->isShowOnCreate()) ? '' : ' display: none;');
        $html .= '">';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td><button id="actionZoomOut" class="livecontrol-zoomOut"></button></td>';
        $html .= '<td><button id="actionTop" class="livecontrol-top"></button></td>';
        $html .= '<td><button id="actionZoomIn" class="livecontrol-zoomIn"></button></td>';
        $html .= '</tr><tr>';
        $html .= '<td><button id="actionLeft" class="livecontrol-left"></button></td>';
        $html .= '<td></td>';
        $html .= '<td><button id="actionRight" class="livecontrol-right"></button></td>';
        $html .= '</tr><tr>';
        $html .= '<td></td>';
        $html .= '<td><button id="actionBottom" class="livecontrol-bottom"></button></td>';
        $html .= '<td></td>';
        $html .= '</tr>';
        $html .= '</table>';
        $html .= '</div>';

        return $html;
    }

    /**
     * @return null
     */
    public function getAction()
    {
        return $this->action;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}