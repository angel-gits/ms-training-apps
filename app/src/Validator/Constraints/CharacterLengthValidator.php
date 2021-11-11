<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CharacterLengthValidator extends ConstraintValidator
{
    /**
     * @param string $text
     * @param Constraint $constraint
     */
    public function validate($text, Constraint $constraint)
    {
        if (strlen(str_replace(" ", "", $text)) < $constraint->min) {
            $this->context
                ->buildViolation($constraint->minMessage)
                ->addViolation();
        }
    }
}
