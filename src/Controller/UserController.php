<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function newUser(Request $request): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        return $this->renderForm('user/newUser.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {

        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/getLoggedUser", name="logged_user")
     */
    public function getLoggedUser()
    {

        $user = $this->getUser();

        return new Response('Well hi there ' . $user->getEmail());
    }

    /**
     * @Route("/forgotPassword", name="forgotPassword")
     */
    public function forgotPassword(Request $request, TokenGeneratorInterface $tokenGenerator, Mailer $mailer): Response
    {
        
        //$userRepository = new UserRepository();
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$user = $userRepository->findOneBy(['email' => $form['email']->getData()]);
            $token = $tokenGenerator->generateToken();
            $mailer->sendEmail();
        }
        return $this->renderForm('user/newUser.html.twig', [
            'form' => $form,
        ]);
    }

    public function resetPassword(Request $request): Response
    {

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Le mot de pass a été modifié avec success');
        }
        return $this->renderForm('user/newUser.html.twig', [
            'form' => $form,
        ]);
    }
}
