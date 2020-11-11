<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintEnabledAge extends Constraint
{
    public $message = 'A character cannot be enabled beyond 90 years.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
