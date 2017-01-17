<?php

namespace SampleBundle\Bundle\NotificationBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;

class NotificationController
{
    private $defaults
        = array(
            "type" => "flash",
        ),
        $flashes = array(),
        $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

   /**
    * Depending on the supplied type argument, add the values
    * to the session flashBag or $this->flashes
    *
    * @param string $name
    * @param array $arguments
    */

    public function add($name, array $arguments = array())
    {
        $arguments += $this->defaults;
        // If the type is flash then add the values to the session flashBag
        if ($arguments["type"] === "flash") {
            $this->session->getFlashBag()->add($name, $arguments);
        }
        // Otherwise if its instant then add them to the class variable $flashes
        elseif ($arguments["type"] === "instant") {
            // We want to be able to have multiple notifications of the same name i.e "success"
            // so we need to add each new set of arguments into an array not overwrite the last
            // "success" value set
            if (!isset($this->flashes[$name])) {
                $this->flashes[$name] = array();
            }
            $this->flashes[$name][] = $arguments;
        }
        return true;
    }

    /**
    * Check the flashBag and $this->flashes for existence of $name
    *
    * @param $name
    *
    * @return bool
    */
    public function has($name)
    {
        if($this->session->getFlashBag()->has($name)){
            return true;
        } else {
            return isset($this->flashes[$name]);
        }
    }

   /**
    * Search for a specific notification and return matches from flashBag and $this->flashes
    *
    * @param $name
    *
    * @return array
    */
    public function get($name)
    {
        if($this->session->getFlashBag()->has($name) && isset($this->flashes[$name])){
            return array_merge_recursive($this->session->getFlashBag()->get($name), $this->flashes[$name]);
        } elseif($this->session->getFlashBag()->has($name)) {
            return $this->session->getFlashBag()->get($name);
        } else {
            return $this->flashes[$name];
        }
    }

   /**
    * Merge all flashBag and $this->flashes values and return the array
    *
    * @return array
    */
    public function all()
    {
        return array_merge_recursive($this->session->getFlashBag()->all(), $this->flashes);
    }
}

