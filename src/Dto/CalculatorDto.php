<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CalculatorDto
{
    #[Assert\NotBlank]
    #[Assert\Choice([20, 100])]
    public int $price;

    #[Assert\NotBlank]
    #[Assert\AtLeastOneOf([
        new Assert\Regex('/DE[0-9]{9}/'),
        new Assert\Regex('/IT[0-9]{11}/'),
        new Assert\Regex('/GR[0-9]{9}/')
    ])]
    public string $tax;
}