<?php

namespace Proxies\__CG__\App\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class TrainingPlan extends \App\Entity\TrainingPlan implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'id', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'programPlan', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'name', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'goal', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'plannedExercises'];
        }

        return ['__isInitialized__', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'id', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'programPlan', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'name', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'goal', '' . "\0" . 'App\\Entity\\TrainingPlan' . "\0" . 'plannedExercises'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (TrainingPlan $proxy) {
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
    public function getProgramPlan(): ?\App\Entity\ProgramPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProgramPlan', []);

        return parent::getProgramPlan();
    }

    /**
     * {@inheritDoc}
     */
    public function setProgramPlan(?\App\Entity\ProgramPlan $programPlan): \App\Entity\TrainingPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProgramPlan', [$programPlan]);

        return parent::setProgramPlan($programPlan);
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setName(?string $name): \App\Entity\TrainingPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', [$name]);

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getGoal(): ?\App\Entity\Goal
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getGoal', []);

        return parent::getGoal();
    }

    /**
     * {@inheritDoc}
     */
    public function setGoal(?\App\Entity\Goal $goal): \App\Entity\TrainingPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setGoal', [$goal]);

        return parent::setGoal($goal);
    }

    /**
     * {@inheritDoc}
     */
    public function getPlannedExercises(): \Doctrine\Common\Collections\Collection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlannedExercises', []);

        return parent::getPlannedExercises();
    }

    /**
     * {@inheritDoc}
     */
    public function addPlannedExercise(\App\Entity\ExercisePlan $plannedExercise): \App\Entity\TrainingPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPlannedExercise', [$plannedExercise]);

        return parent::addPlannedExercise($plannedExercise);
    }

    /**
     * {@inheritDoc}
     */
    public function removePlannedExercise(\App\Entity\ExercisePlan $plannedExercise): \App\Entity\TrainingPlan
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePlannedExercise', [$plannedExercise]);

        return parent::removePlannedExercise($plannedExercise);
    }

}
