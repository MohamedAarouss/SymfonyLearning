<?php

namespace App\Validator\Constraints;

use App\Entity\Character;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ConstraintEnabledAgeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ConstraintEnabledAge) {
            throw new UnexpectedTypeException($constraint, ConstraintEnabledAge::class);
        }

        if ($value === null) {
            return;
        }

        if (!$value instanceof Character) {
            throw new UnexpectedValueException($value, 'Character');
        }

        if ($value->getAge() > 90 && $value->getEnabled()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
