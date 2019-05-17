<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\User;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class DeleteUser
 * @package Nerdery\Action
 */
class DeleteUser
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
        $id = (int)$request->getAttribute('id');

        try {
            /** @var User|null $user */
            $user = $this->em->getRepository(User::class)->find($id);

            if (null === $user) {
                return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
            }

            $this->em->remove($user);
            $this->em->flush();

        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withStatus(StatusCode::HTTP_NO_CONTENT);
    }
}