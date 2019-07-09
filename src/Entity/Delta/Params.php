<?php

namespace App\Entity\Delta;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Params
 *
 * @ORM\Table(name="PARAMS", indexes={@ORM\Index(name="IDX_7F36C9759497FC04", columns={"SCALEID"}), @ORM\Index(name="IDX_7F36C975FE08514F", columns={"DEVICEID"}), @ORM\Index(name="IDX_7F36C975EBD84B70", columns={"SCRIPT_ENGINE_ID"}), @ORM\Index(name="IDX_7F36C97547405208", columns={"GROUPID"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Params
{
//region SECTION: Fields
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="PARAMTYPE", type="integer", nullable=false)
     */
    private $paramtype;

    /**
     * @var string
     *
     * @ORM\Column(name="DEVICECHAN", type="string", length=50, nullable=false)
     */
    private $devicechan;

    /**
     * @var int
     *
     * @ORM\Column(name="DS_ID", type="integer", nullable=false)
     */
    private $dsId;

    /**
     * @var string
     *
     * @ORM\Column(name="DS_CHAN", type="string", length=50, nullable=false)
     */
    private $dsChan;

    /**
     * @var string
     *
     * @ORM\Column(name="NAME", type="string", length=254, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ADDITIONALNAME", type="string", length=254, nullable=true)
     */
    private $additionalname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SHORTNAME", type="string", length=20, nullable=true)
     */
    private $shortname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="AKS", type="string", length=20, nullable=true)
     */
    private $aks;

    /**
     * @var int
     *
     * @ORM\Column(name="FLAGS", type="integer", nullable=false)
     */
    private $flags;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SCRIPT_TEXT", type="text", length=16, nullable=true)
     */
    private $scriptText;

    /**
     * @var int
     *
     * @ORM\Column(name="SCANRATE", type="smallint", nullable=false)
     */
    private $scanrate = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="INTERVAL", type="smallint", nullable=false)
     */
    private $interval = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="ALARMDELAY", type="smallint", nullable=false)
     */
    private $alarmdelay = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="STALETIMEOUT", type="smallint", nullable=false)
     */
    private $staletimeout = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="CALCTIME", type="integer", nullable=false)
     */
    private $calctime = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="SAVETIME", type="integer", nullable=false)
     */
    private $savetime = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="STEP", type="smallint", nullable=false)
     */
    private $step = '0';

    /**
     * @var string|null
     *
     * @ORM\Column(name="METATYPE", type="guid", nullable=true)
     */
    private $metatype;

    /**
     * @var Scales
     *
     * @ORM\ManyToOne(targetEntity="Scales", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SCALEID", referencedColumnName="ID")
     * })
     */
    private $scale;

    /**
     * @var Devices
     *
     * @ORM\ManyToOne(targetEntity="Devices", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="DEVICEID", referencedColumnName="ID")
     * })
     */
    private $device;

    /**
     * @var ScriptEngines
     *
     * @ORM\ManyToOne(targetEntity="ScriptEngines", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="SCRIPT_ENGINE_ID", referencedColumnName="ID")
     * })
     */
    private $scriptEngine;

    /**
     * @var Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="GROUPID", referencedColumnName="ID")
     * })
     */
    private $group;

    /**
     * @var ArrayCollection
     */
    private $paramData;
//endregion Fields

//region SECTION: Constructor
    /**
     * @ORM\PostLoad()
     */
    public function setInitialFoo()
    {
        $this->paramData = new ArrayCollection();
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @return ArrayCollection
     */
    public function addParamData($paramData)
    {
        return $this->paramData->add($paramData);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getParamtype(): int
    {
        return $this->paramtype;
    }

    /**
     * @return string
     */
    public function getDevicechan(): string
    {
        return $this->devicechan;
    }

    /**
     * @return int
     */
    public function getDsId(): int
    {
        return $this->dsId;
    }

    /**
     * @return string
     */
    public function getDsChan(): string
    {
        return $this->dsChan;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getAdditionalname(): ?string
    {
        return $this->additionalname;
    }

    /**
     * @return string|null
     */
    public function getShortname(): ?string
    {
        return $this->shortname;
    }

    /**
     * @return string|null
     */
    public function getAks(): ?string
    {
        return $this->aks;
    }

    /**
     * @return int
     */
    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * @return string|null
     */
    public function getScriptText(): ?string
    {
        return $this->scriptText;
    }

    /**
     * @return int
     */
    public function getScanrate(): int
    {
        return $this->scanrate;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @return int
     */
    public function getAlarmdelay(): int
    {
        return $this->alarmdelay;
    }

    /**
     * @return int
     */
    public function getStaletimeout(): int
    {
        return $this->staletimeout;
    }

    /**
     * @return int
     */
    public function getCalctime(): int
    {
        return $this->calctime;
    }

    /**
     * @return int
     */
    public function getSavetime(): int
    {
        return $this->savetime;
    }

    /**
     * @return int
     */
    public function getStep(): int
    {
        return $this->step;
    }

    /**
     * @return string|null
     */
    public function getMetatype(): ?string
    {
        return $this->metatype;
    }

    /**
     * @return Scales
     */
    public function getScale()
    {
        return $this->scale;
    }

    /**
     * @return Devices
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @return ScriptEngines
     */
    public function getScriptEngine()
    {
        return $this->scriptEngine;
    }

    /**
     * @return Groups
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param int $paramtype
     *
     * @return Params
     */
    public function setParamtype(int $paramtype)
    {
        $this->paramtype = $paramtype;

        return $this;
    }

    /**
     * @param string $devicechan
     *
     * @return Params
     */
    public function setDevicechan(string $devicechan)
    {
        $this->devicechan = $devicechan;

        return $this;
    }

    /**
     * @param int $dsId
     *
     * @return Params
     */
    public function setDsId(int $dsId)
    {
        $this->dsId = $dsId;

        return $this;
    }

    /**
     * @param string $dsChan
     *
     * @return Params
     */
    public function setDsChan(string $dsChan)
    {
        $this->dsChan = $dsChan;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Params
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string|null $additionalname
     *
     * @return Params
     */
    public function setAdditionalname(?string $additionalname)
    {
        $this->additionalname = $additionalname;

        return $this;
    }

    /**
     * @param string|null $shortname
     *
     * @return Params
     */
    public function setShortname(?string $shortname)
    {
        $this->shortname = $shortname;

        return $this;
    }

    /**
     * @param string|null $aks
     *
     * @return Params
     */
    public function setAks(?string $aks)
    {
        $this->aks = $aks;

        return $this;
    }

    /**
     * @param int $flags
     *
     * @return Params
     */
    public function setFlags(int $flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * @param string|null $scriptText
     *
     * @return Params
     */
    public function setScriptText(?string $scriptText)
    {
        $this->scriptText = $scriptText;

        return $this;
    }

    /**
     * @param int $scanrate
     *
     * @return Params
     */
    public function setScanrate(int $scanrate)
    {
        $this->scanrate = $scanrate;

        return $this;
    }

    /**
     * @param int $interval
     *
     * @return Params
     */
    public function setInterval(int $interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * @param int $alarmdelay
     *
     * @return Params
     */
    public function setAlarmdelay(int $alarmdelay)
    {
        $this->alarmdelay = $alarmdelay;

        return $this;
    }

    /**
     * @param int $staletimeout
     *
     * @return Params
     */
    public function setStaletimeout(int $staletimeout)
    {
        $this->staletimeout = $staletimeout;

        return $this;
    }

    /**
     * @param int $calctime
     *
     * @return Params
     */
    public function setCalctime(int $calctime)
    {
        $this->calctime = $calctime;

        return $this;
    }

    /**
     * @param int $savetime
     *
     * @return Params
     */
    public function setSavetime(int $savetime)
    {
        $this->savetime = $savetime;

        return $this;
    }

    /**
     * @param int $step
     *
     * @return Params
     */
    public function setStep(int $step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * @param string|null $metatype
     *
     * @return Params
     */
    public function setMetatype(?string $metatype)
    {
        $this->metatype = $metatype;

        return $this;
    }

    /**
     * @param Scales $scale
     *
     * @return Params
     */
    public function setScale($scale)
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * @param Devices $device
     *
     * @return Params
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @param ScriptEngines $scriptEngine
     *
     * @return Params
     */
    public function setScriptEngine($scriptEngine)
    {
        $this->scriptEngine = $scriptEngine;

        return $this;
    }

    /**
     * @param Groups $group
     *
     * @return Params
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }
//endregion Getters/Setters
}
