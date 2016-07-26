<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use Doctrine\ORM\EntityManager;

class EmailExistsValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        $repository = $this->em->getRepository('AppBundle:User');

        $user = $repository->findOneByEmail($value);

        if (is_null($user) && !empty($value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}