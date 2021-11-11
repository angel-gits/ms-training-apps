<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CharacterLength extends Constraint
{
    public $min;
    public $minMessage;
}