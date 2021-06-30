<?php
/**
 * User Controller.
 */

namespace App\Controller;

use App\Form\UserType;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 */
class UserController extends AbstractController
{
    /** @var UserService */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route(
     *     "/user/editPassword",
     *     methods={"GET", "POST"},
     *     name="user_edit_password"
     * )
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @IsGranted("ROLE_ADMIN")
     */
    public function editPassword(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPasswordPlain = $form->get('newPassword')->getData();
            $this->userService->save($user, $newPasswordPlain);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('user_edit_password');
        }

        return $this->render(
            'user/edit_password.html.twig',
            ['form' => $form->createView()]
        );
    }
}
