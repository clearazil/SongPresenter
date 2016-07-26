<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class EmailExists extends Constraint
{
    public $message = 'VALIDATOR_CONSTRAINT_EMAIL_NOT_FOUND';
}