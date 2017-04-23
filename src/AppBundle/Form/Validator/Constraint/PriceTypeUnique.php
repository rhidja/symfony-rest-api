<?php
# src/AppBundle/Form/Validator/Constraint/PriceTypeUnique.php

namespace AppBundle\Form\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PriceTypeUnique extends Constraint
{
    public $message = 'A place cannot contain prices with same type';
}
