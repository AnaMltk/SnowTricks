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
     * @Route("/forgotPassword", name="forgotPassword")
     */
    public function forgotPassword(Request $request, TokenGeneratorInterface $tokenGenerator, Mailer $mailer, UserRepository $userRepository, UrlGeneratorInterface $urlGenerator): Response
    {
       
        $subject = 'Modification de mot de passe';
        $text = 'Cliquez sur le lien pour modifier votre mot de passe ';
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['email' => $form['email']->getData()]);
            if($user){
                $receiver = $user->getEmail();
                $token = $tokenGenerator->generateToken();
                $url = $urlGenerator->generate('resetPassword', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
                $text = $text.' '.$url;
                $user->setToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $mailer->sendEmail($receiver, $subject, $text);
                $this->addFlash('reinitialisation', 'Le mail a été envoyé');
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
     */
    public function resetPassword(Request $request, string $token, UserRepository $userRepository): Response
    {

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['token'=>$token]);
            if($user === null ){
                $this->addFlash('danger', 'Invalid token');
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
