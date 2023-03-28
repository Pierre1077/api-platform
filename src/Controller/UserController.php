<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]

class UserController extends AbstractController
{
    public function __construct(
    ) {}

    public function __invoke(): User
    {

        return $this->getUser();
    }
}