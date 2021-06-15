<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Repository\MainRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NoteController.
 *
 * @Route("/")
 */
class MainController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request         HTTP request
     * @param MainRepository     $noteRepository  Note repository
     * @param PaginatorInterface $paginator       Paginator
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="main_index",
     * )
     */
    public function index(Request $request, MainRepository $noteRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $noteRepository->queryAll(),
            $request->query->getInt('page', 1),
            MainRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'main/index.html.twig',
            [
                'pagination' => $pagination,
            ]
        );
    }

    /**
     * Show action.
     *
     * @param Note $note Note entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="note_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Note $note): Response
    {
        return $this->render(
            'note/show.html.twig',
            ['note' => $note]
        );
    }
}
