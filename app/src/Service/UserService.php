<?php
/**
 * User Service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserService
 */
class UserService
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * UserService constructor.
     * @param UserRepository               $userRepository
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Save user.
     * @param User        $user
     * @param string|null $newPlainPassword
     */
    public function save(User $user, ?string $newPlainPassword = null)
    {
        if ($newPlainPassword) {
            $encodedPassword = $this->passwordEncoder->encodePassword(
                $user,
                $newPlainPassword
            );

            $user->setPassword($encodedPassword);
        }

        $this->userRepository->save($user);
    }
}
