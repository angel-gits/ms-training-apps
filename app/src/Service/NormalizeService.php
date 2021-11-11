<?php
namespace App\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NormalizeService
{
    private $datetimeFormat;
    private $dateFormat;

    public function __construct()
    {
        $this->datetimeFormat = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format(\DateTime::ISO8601) : '';
        };
        $this->dateFormat = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof \DateTime ? $innerObject->format('Y-m-d') : '';
        };
    }

    public function normalizeByGroup($object, $groups = ['groups' => 'main']) {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $serializer = new Serializer([new ObjectNormalizer($classMetadataFactory)]);

        return $serializer->normalize($object, null, [
            'groups' => $groups['groups'],
            AbstractNormalizer::CALLBACKS => [
                'date' => $this->datetimeFormat,
                'registrationDate' => $this->dateFormat,
                'finishDateTime' => $this->datetimeFormat,
                'startDate' => $this->datetimeFormat,
                'startDateTime' => $this->datetimeFormat,
            ],
        ]);
    }
}