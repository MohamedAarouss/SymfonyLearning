<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class ConstraintsUniqueWeaponLegendary extends Constraint
{
    public $message = 'The user "{{ username }}" is already have a weapon legendary';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
