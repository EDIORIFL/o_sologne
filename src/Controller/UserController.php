<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @Security("is_granted('ROLE_SUPERADMIN')")
     */
    public function index(
        Request $request,
        UserRepository $userRepository,
        PaginatorInterface $paginator
    ): Response {
        $datas = $userRepository->findAll();
        $users = $paginator->paginate($datas, $request->query->getInt('page', 1), 20);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_SUPERADMIN')")
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (in_array(User::ROLE_SUPERADMIN, $user->getRoles())) {
                $user->setRoles([User::ROLE_SUPERADMIN, User::ROLE_ADMIN, User::ROLE_USER]);
            } elseif (in_array(User::ROLE_ADMIN, $user->getRoles())) {
                $user->setRoles([User::ROLE_ADMIN, User::ROLE_USER]);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $user
                ->setPassword($encoder->encodePassword($user, $user->getPassword()))
                ->setCreatedat(new \DateTime('now'))
                ->setUpdatedat(new \DateTime('now'));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $hasAccess = $this->isGranted(User::ROLE_SUPERADMIN);
        if ($this->getUser() === $user || $hasAccess) {
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                if (in_array(User::ROLE_SUPERADMIN, $data->getRoles())) {
                    $user->setRoles([User::ROLE_SUPERADMIN, User::ROLE_ADMIN, User::ROLE_USER]);
                } elseif (in_array(User::ROLE_ADMIN, $data->getRoles())) {
                    $user->setRoles([User::ROLE_ADMIN, User::ROLE_USER]);
                }
                $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
                dd($data->getPassword() === $user->getPassword());
                $user->setUpdatedat(new \DateTime('now'));
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_index');
            }

            return $this->render('user/edit.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        } else {
            $this->redirectToRoute('user_index');
        }
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
