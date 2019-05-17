<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Exception;
use Nerdery\Domain\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class SearchUsers
 * @package Nerdery\Action
 */
class SearchUsers
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $q = $request->getParam('q');

        try {
            /** @var QueryBuilder $qb */
            $qb = $this->em->getRepository(User::class)->createQueryBuilder('u');

            /** @var Query $query */
            $query = $qb->select('u')
                        ->where($qb->expr()->orX(
                            $qb->expr()->like('u.firstName', ':q'),
                            $qb->expr()->like('u.lastName', ':q'),
                            $qb->expr()->like('u.email', ':q')
                        ))
                        ->setParameter('q', '%' . $q . '%')
                        ->orderBy('u.lastName', 'ASC')
                        ->getQuery();

            /** @var User[] $users */
            $users = $query->execute();
        } catch (Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($users, StatusCode::HTTP_OK);
    }
}