<?php

namespace Fhp\Segment;

/**
 * Contains meta information about a data element group, i.e. anything that can be statically known about a sub-class of
 * {@link BaseDeg} through reflection.
 */
class DegDescriptor extends BaseDescriptor
{
    /** @var DegDescriptor[] */
    private static $descriptors = [];

    /**
     * @param string $class The name of a sub-class of {@link BaseDeg}.
     * @return DegDescriptor The descriptor for the class.
     */
    public static function get(string $class): DegDescriptor
    {
        if (!array_key_exists($class, static::$descriptors)) {
            static::$descriptors[$class] = new DegDescriptor($class);
        }
        return static::$descriptors[$class];
    }

    /**
     * Please use the factory above.
     * @param string $class The name of a sub-class of {@link BaseDeg}.
     */
    protected function __construct(string $class)
    {
        $this->class = $class;
        try {
            $clazz = new \ReflectionClass($class);
            if (!$clazz->isSubclassOf(BaseDeg::class)) {
                throw new \InvalidArgumentException("Must inherit from BaseDeg: $class");
            }
            parent::__construct($clazz);

            // Check if the name ends in V2 or so, implicitly assume V1.
            if (preg_match('/^[A-Z]+[vV]([0-9]+)$/', $clazz->getShortName(), $match) === 1) {
                $this->version = intval($match[1]);
            }
        } catch (\ReflectionException $e) {
            throw new \RuntimeException($e);
        }
    }
}
