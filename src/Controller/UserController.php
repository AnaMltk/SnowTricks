<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Mailer;
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
     * @param AuthenticationUtils $authenticationUtils
     * 
     * @return Response
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
     * @param Request $request
     * @param Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @param UrlGeneratorInterface $urlGenerator
     * 
     * @return Response
     */
    public function newUser(Request $request, Mailer $mailer, TokenGeneratorInterface $tokenGenerator, UrlGeneratorInterface $urlGenerator): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $receiver = $user->getEmail();
            $token = $tokenGenerator->generateToken();
            $url = $urlGenerator->generate('activateAccount', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
            $user->setToken($token);
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $mailer->sendEmailForAccountActivation($receiver, $url);
            $this->addFlash('registration', 'Votre compte a été crée avec succes, vous allez recevoir un email pour l\'activer');
        }
        return $this->renderForm('user/newUser.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/activateAccount/{token}", name="activateAccount")
     * @param UserRepository $userRepository
     * @param string $token
     * 
     * @return Response
     */
    public function activateAccount(UserRepository $userRepository, string $token): Response
    {
        $user = $userRepository->findOneBy(['token' => $token]);
            if ($user === null) {
                return $this->redirectToRoute('index');
            }
            $user->setToken(null);
            $user->setRoles(['ROLE_ADMIN']);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('index');
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     * @return void
     */
    public function logout(): void
    {

        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/forgotPassword", name="forgotPassword")
     * @param Request $request
     * @param TokenGeneratorInterface $tokenGenerator
     * @param Mailer $mailer
     * @param UserRepository $userRepository
     * @param UrlGeneratorInterface $urlGenerator
     * 
     * @return Response
     */
    public function forgotPassword(Request $request, TokenGeneratorInterface $tokenGenerator, Mailer $mailer, UserRepository $userRepository, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['email' => $form['email']->getData()]);
            if ($user) {
                $receiver = $user->getEmail();
                $token = $tokenGenerator->generateToken();
                $url = $urlGenerator->generate('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
                $user->setToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $mailer->sendEmailForPasswordReinitialisation($receiver, $url);
                $this->addFlash('reinitialisation', 'Le mail de modification de mot de passe a été envoyé');
            } else {
                $this->addFlash('failure', 'L\'Utilisateur n\'existe pas');
            }
        }
        return $this->renderForm('user/forgotPassword.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/resetPassword/{token}", name="resetPassword")
     * @param Request $request
     * @param string $token
     * @param UserRepository $userRepository
     * 
     * @return Response
     */
    public function resetPassword(Request $request, string $token, UserRepository $userRepository): Response
    {

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['token' => $token]);
            if ($user === null) {
                return $this->redirectToRoute('index');
            }
            $user->setToken(null);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $form['password']->getData()));
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('notice', 'Le mot de pass a été modifié avec success');
            return $this->redirectToRoute('login');
        }
        return $this->renderForm('user/resetPassword.html.twig', [
            'form' => $form,
        ]);
    }
}
