<?php

namespace Proxies\__CG__\App\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Training extends \App\Entity\Training implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array<string, null> properties to be lazy loaded, indexed by property name
     */
    public static $lazyPropertiesNames = array (
);

    /**
     * @var array<string, mixed> default values of properties to be lazy loaded, with keys being the property names
     *
     * @see \Doctrine\Common\Proxy\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array (
);



    public function __construct(?\Closure $initializer = null, ?\Closure $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'trainingPlan', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'startDateTime', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'program', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'finishDateTime', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'status', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'exercises', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'goal'];
        }

        return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'trainingPlan', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'startDateTime', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'program', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'finishDateTime', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'status', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'exercises', '' . "\0" . 'App\\Entity\\Training' . "\0" . 'goal'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Training $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy::$lazyPropertiesDefaults as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getTrainingPlan(): ?\App\Entity\TrainingPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTrainingPlan', []);

        return parent::getTrainingPlan();
    }

    /**
     * {@inheritDoc}
     */
    public function setTrainingPlan(?\App\Entity\TrainingPlan $trainingPlan): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTrainingPlan', [$trainingPlan]);

        return parent::setTrainingPlan($trainingPlan);
    }

    /**
     * {@inheritDoc}
     */
    public function getStartDateTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStartDateTime', []);

        return parent::getStartDateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setStartDateTime($startDateTime): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStartDateTime', [$startDateTime]);

        return parent::setStartDateTime($startDateTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getProgram(): ?\App\Entity\Program
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProgram', []);

        return parent::getProgram();
    }

    /**
     * {@inheritDoc}
     */
    public function setProgram(?\App\Entity\Program $program): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProgram', [$program]);

        return parent::setProgram($program);
    }

    /**
     * {@inheritDoc}
     */
    public function getFinishDateTime()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFinishDateTime', []);

        return parent::getFinishDateTime();
    }

    /**
     * {@inheritDoc}
     */
    public function setFinishDateTime($finishDateTime): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFinishDateTime', [$finishDateTime]);

        return parent::setFinishDateTime($finishDateTime);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus(): ?int
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus(int $status): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getExercises(): \Doctrine\Common\Collections\Collection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getExercises', []);

        return parent::getExercises();
    }

    /**
     * {@inheritDoc}
     */
    public function addExercise(\App\Entity\Exercise $exercise): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addExercise', [$exercise]);

        return parent::addExercise($exercise);
    }

    /**
     * {@inheritDoc}
     */
    public function removeExercise(\App\Entity\Exercise $exercise): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeExercise', [$exercise]);

        return parent::removeExercise($exercise);
    }

    /**
     * {@inheritDoc}
     */
    public function getGoal(): ?\App\Entity\GoalUser
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGoal', []);

        return parent::getGoal();
    }

    /**
     * {@inheritDoc}
     */
    public function setGoal(?\App\Entity\GoalUser $goal): \App\Entity\Training
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGoal', [$goal]);

        return parent::setGoal($goal);
    }

}
