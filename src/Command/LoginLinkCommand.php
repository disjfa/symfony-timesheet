<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

#[AsCommand(
    name: 'app:login:link',
    description: 'Generate login link for users',
)]
class LoginLinkCommand extends Command
{
    private UserRepository $userRepository;
    private LoginLinkHandlerInterface $loginLinkHandler;

    public function __construct(UserRepository $userRepository, LoginLinkHandlerInterface $loginLinkHandler)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->loginLinkHandler = $loginLinkHandler;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->userRepository->findAll();
        $emails = array_map(static fn (User $user) => $user->getEmail(), $users);

        $helper = $this->getHelper('question');
        $loginAsUser = new ChoiceQuestion('Login as?', $emails);
        $email = $helper->ask($input, $output, $loginAsUser);

        $user = $this->userRepository->findOneBy(['email' => $email]);

        $link = $this->loginLinkHandler->createLoginLink($user);

        $io->success($link);

        return Command::SUCCESS;
    }
}
