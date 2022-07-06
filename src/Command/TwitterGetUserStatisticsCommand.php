<?php

namespace App\Command;

use App\Repository\TwitterUserRepository;
use App\Repository\TwitterUserFollowsRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Enum\HttpMethod;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\TwitterUserFollows;

#[AsCommand(
    name: 'twitter:getUserStatistics',
    description: 'Get databases user twitter follow',
)]
class TwitterGetUserStatisticsCommand extends Command
{
    public HttpClientInterface $httpClient;
    public TwitterUserRepository $twitterUserRepository;
    public TwitterUserFollowsRepository $twitterUserFollowsRepository;

    public string $apiEndpoint = 'https://api.twitter.com/2/users/by/username/%s?user.fields=public_metrics';
    public string $token = '';

    public function __construct(HttpClientInterface $client, TwitterUserRepository $twitterUserRepository, TwitterUserFollowsRepository $twitterUserFollowsRepository)
    {
        $this->httpClient = $client;
        $this->twitterUserRepository = $twitterUserRepository;
        $this->twitterUserFollowsRepository = $twitterUserFollowsRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->twitterUserRepository->findOldUpdate();

        $response = $this->httpClient->request(
            HttpMethod::POST,
            'https://api.twitter.com/oauth2/token',
            [
                'auth_basic' => ['BSkBas2kto3lJgrsNGDJztcVx', '7jR1wjogr19h2loQJ2ZOhUuTDTqDHbQLep3qH7NhXl4Xe7yrkU'],
                'body' => 'grant_type=client_credentials',
                'headers' => [
                    'Accept: application/json',
                ]
            ]
        );

        $json = json_decode($response->getContent(), true);

        $this->token = $json['access_token'];

        foreach ($users as $user) {
            $userRequest = $this->httpClient->request(
                HttpMethod::GET,
                sprintf($this->apiEndpoint, $user->getUsername()),
                [
                    'auth_bearer' => $this->token,
                ]
            );

            $userDate = json_decode($userRequest->getContent(), true);

            $twitterUserFollows = new TwitterUserFollows();
            $twitterUserFollows->setCreateDateAt(new \DateTimeImmutable());
            $twitterUserFollows->setFollow($userDate["data"]["public_metrics"]["followers_count"]);
            $twitterUserFollows->setTwitterUser($user);

            $this->twitterUserFollowsRepository->add($twitterUserFollows, true);

            $user->addTwitterUserFollow($twitterUserFollows);
            $user->setUpdateDateAt(new \DateTimeImmutable());

            $this->twitterUserRepository->add($user, true);

            $io->note(sprintf('Write: %s', $user->getUsername()));
        }

        $io->success('Success');

        return Command::SUCCESS;
    }
}
