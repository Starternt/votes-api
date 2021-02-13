<?php
namespace App\Security;

use App\Entity\User;
use App\Utils\JsonApi\JsonApiErrorsTrait;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Neomerx\JsonApi\Contracts\Encoder\EncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

/**
 * @author Konstantin Laktionov <Starternh@gmail.com>
 * @package App\Security
 */
class JwtTokenAuthenticator extends AbstractGuardAuthenticator
{
    use JsonApiErrorsTrait;

    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var EncoderInterface
     */
    private $encoder;

    /**
     * JwtTokenAuthenticator constructor.
     *
     * @param JWTEncoderInterface $jwtEncoder
     * @param EntityManagerInterface $em
     * @param EncoderInterface $encoder
     */
    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManagerInterface $em, EncoderInterface $encoder)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @param Request $request
     *
     * @return mixed|string|void
     */
    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );

        $token = $extractor->extract($request);

        if (!$token) {
            return false;
        }

        return $token;
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface|void|null
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $data = $this->jwtEncoder->decode($credentials);

            return $this->em->find(User::class, $data['id']);
        } catch (JWTDecodeFailureException $e) {
            throw new CustomUserMessageAuthenticationException('Invalid Token');
        }
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response
     * @throws Exception
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $error = $this->createJsonApiError(
            (string)Response::HTTP_UNAUTHORIZED,
            'f4113e94-d8b3-4050-90af-f720b417d6f8',
            'Authorization required',
            'Invalid token'
        );

        return new Response(
            $this->encoder->encodeError($error),
            Response::HTTP_UNAUTHORIZED,
            ['Content-Type' => 'application/vnd.api+json']
        );
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return Response|void|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // nothing to do
    }

    public function supportsRememberMe()
    {
        return false;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        // nothing to do
    }

    public function supports(Request $request)
    {
        return true;
    }
}