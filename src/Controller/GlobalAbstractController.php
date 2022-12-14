<?php

namespace App\Controller;

use App\Entity\Booklet;
use App\Entity\BookletPercent;
use App\Entity\CurrentAccount;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use JMS\Serializer\SerializerInterface;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

abstract class GlobalAbstractController extends AbstractController
{

    private ValidatorInterface $validator;
    private UrlGeneratorInterface $urlGenerator;
    private SerializerInterface $serializer;

    var string $groupsGetBooklet = "getBooklet";
    var string $groupsGetCurrentAccount = "getCurrentAccount";
    var string $groupsGetUser = "getUser";
    var string $groupsGetBookletPercent = "getBookletPercent";

    /**
     * @param ValidatorInterface $validator
     * @param UrlGeneratorInterface $urlGenerator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface  $validator, UrlGeneratorInterface $urlGenerator,
                                SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->urlGenerator = $urlGenerator;
        $this->serializer = $serializer;
    }

    /**
     * Retourne l'url de localisation du booklet entré en paramètre
     *
     * @param Booklet $booklet
     * @return string
     */
    public function urlGenerator_get_booklet_by_id(Booklet $booklet): string
    {
        return $this->urlGenerator->generate(
            "booklets_get_booklet_by_id",
            ["idBooklet" => $booklet->getId()]
        );
    }

    public function urlGenerator_get_booklet_percent_by_id(BookletPercent $bookletPercent): string
    {
        return $this->urlGenerator->generate(
            "booklet_percents_get_booklet_percent_by_id",
            ["idBookletPercent" => $bookletPercent->getId()]
        );
    }

    /**
     * Retourne l'url de localisation du user entré en paramètre
     *
     * @param User $user
     * @return string
     */
    public function urlGenerator_get_user_by_id(User $user): string
    {
        return $this->urlGenerator->generate(
            "users_get_user_by_id",
            ["idUser" => $user->getId()]
        );
    }

    /**
     * Retourne l'url de localisation du current account entré en paramètre
     *
     * @param CurrentAccount $account
     * @return string
     */
    public function urlGenerator_get_current_account_by_id(CurrentAccount $account): string
    {
        return $this->urlGenerator->generate(
            "currentAccounts_get_current_account_by_id",
            ["idCurrentAccount" => $account->getId()]
        );
    }

    /**
     * Fonction permettant de ressorti un JsonResponse de status Created
     *
     * @param $data
     * @param $headers
     * @return JsonResponse
     */
    public function jsonResponseCreated($data, $headers): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_CREATED, $headers, true);
    }

    /**
     * Fonction permettant de ressortir un JsonResponse de status No_content
     *
     * @return JsonResponse
     */
    public function jsonResponseNoContent(): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * FOnction permettant de ressortir un json response de status Not acceptable
     *
     * @return JsonResponse
     */
    public function jsonResponseNotAcceptable(): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * Fonction permettant de ressortir un JsonResponse de status OK en prenant en paramètre les data et le headers
     *
     * @param $data
     * @param array $headers
     * @return JsonResponse
     */
    public function jsonResponseOk($data, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_OK, $headers, true);
    }

    /**
     * Fonction retournant le nombre de validator error contenue dans un objet, 0 étant pareil que False
     *
     * @param $object
     * @return integer
     */
    public function validatorError($object): int
    {
        $errors = $this->validator->validate($object);
        return $errors->count();
    }

    /**
     * Fonction permettant de ressortir un JsonResponse de status Not_found avec les erreurs du validator error
     *
     * @param $object
     * @return JsonResponse
     */
    public function jsonResponseValidatorError($object): JsonResponse
    {
        $errors = $this->validator->validate($object);
        dd($errors);
        return new JsonResponse($this->serializer->serialize($errors, "json"),
            Response::HTTP_NOT_MODIFIED, [], true);
    }

    public function jsonResponseUnauthorized(): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize("Vous n'êtes pas connectés", "json"),
            Response::HTTP_UNAUTHORIZED, [], true);
    }
}
