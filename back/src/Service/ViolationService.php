<?php

namespace App\Service;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationService
{
    /**
     * @return array<int, mixed>
     */
    public function formatViolations(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = [
                'field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage(),
                'invalid_value' => $violation->getInvalidValue(),
            ];
        }

        return $errors;
    }
}