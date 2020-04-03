<?php

namespace App\Security;

/**
 * Class Ldap
 *
 * @package App\Security
 */
class Ldap
{
//region SECTION: Fields
    /**
     * @var mixed $connect ldap server connector
     */
            private $connect = false;

    /**
     * @var mixed $servers list ldap servers
     */
    private $servers = null;

    private $host;
    private $port;
    private $domain;
    private $search;

    private $log  = "ldap";
    private $pass = "ldap";
//endregion Fields

//region SECTION: Constructor
    /**
     * конструктор
     *
     * @param $servers
     */
    public function __construct($servers)
    {
        $this->servers = $servers;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param string $user
     * @param string $pass
     * @param string $domain
     *
     * @return bool
     */
    public function checkUser($user, $pass, $domain = null)
    {
        //нет пароля не нужно лезть в ldap
        if (mb_strlen($pass) !== 0) {
            //нет соединения пытаемся найти о создать подключение и проверяем пользователя
            if (!$this->connect) {
                return $this->searchLdap($user, $pass, $domain);
            } else {
                //есть соединения - проверяем пользователя
                try {
                    $bind = @ldap_bind($this->connect, $user."@".$this->domain, $pass);
                } catch (\ErrorException $e) {
                    $bind = false;
                }

                return $bind;
            }
        } else {
            return false;
        }
    }

    public function connect($domain = 'ite-ng.ru')
    {
        $this->domain  = $domain;
        $domainServers = $this->servers[$domain];
        foreach ($domainServers as $server) {
            $this->connect = ldap_connect($server['host'], $server['port']);

            if (false !== $this->connect) {
                $this->setLdapDefaultSettings();
                $this->host   = $server['host'];
                $this->port   = $server['port'];
                $this->search = $server['search'];
                break;
            }
        }

        if (!$this->connect) {
            throw new \Exception('No ldap connection');
        }

    }

    /**
     * сбрасываем соединение
     */
    public function closeLdap()
    {
        if ($this->connect) {
            ldap_unbind($this->connect);
        }
    }

    /**
     * деструктор
     */
    public function __destruct()
    {
        $this->closeLdap();
    }
//endregion Public

//region SECTION: Private
    /**
     * @param $domainServers
     * @param $user
     * @param $pass
     *
     * @return bool
     */
    private function openLdapServer($domainServers, $user, $pass)
    {
        foreach ($domainServers as $server) {
            $this->connect = ldap_connect($server['host'], $server['port']);
            if (false !== $this->connect) {
                $this->setLdapDefaultSettings();
                if (!$this->checkUser($user, $pass, $this->domain)) {
                    $this->closeLdap();
                    $this->connect = false;
                } else {
                    $this->host   = $server['host'];
                    $this->port   = $server['port'];
                    $this->search = $server['search'];

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param string $user   user name
     * @param string $pass   user pass
     * @param string $domain domain name
     *
     * @return mixed|resource
     */
    private function searchLdap($user, $pass, $domain)
    {
        if (!is_null($this->servers)) {
            if (null !== $domain && array_key_exists($domain, $this->servers)) {
                $this->domain  = $domain;
                $domainServers = $this->servers[$domain];
                if ($this->openLdapServer($domainServers, $user, $pass)) {
                    return true;
                }
            } else {
                foreach ($this->servers as $nameDomain => $domainServers) {
                    $this->domain = $nameDomain;
                    if ($this->openLdapServer($domainServers, $user, $pass)) {
                        return true;
                    }
                }
            }
            $this->domain = '';

            return false;
        } else {
            die("List of Servers is empty");
        }
    }
//endregion Private

//region SECTION: Getters/Setters
    /**
     * настроки поумолчанию для ldap серверов
     */
    public function setLdapDefaultSettings()
    {
        //for win2003
        ldap_set_option($this->connect, LDAP_OPT_PROTOCOL_VERSION, 3) or die("Could set protocol version 3");
        //for win2003
        ldap_set_option($this->connect, LDAP_OPT_REFERRALS, 0) or die("Could not set referrals");
    }
//endregion Getters/Setters

}