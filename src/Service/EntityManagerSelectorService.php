<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class EntityManagerSelectorService
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly EntityManagerInterface $entityManagerDb1,
        private readonly EntityManagerInterface $entityManagerDb2
    )
    {

    }
    public function getEntityManager(): EntityManagerInterface
    {
        $subdomain = explode('.', $this->requestStack->getCurrentRequest()->getHost())[0];

        if ($subdomain === 'subdominio1') {
            return $this->entityManagerDb1;
        } else if ($subdomain === 'subdominio2') {
            return $this->entityManagerDb2;
        }
        return $this->entityManagerDb1;
    }
}