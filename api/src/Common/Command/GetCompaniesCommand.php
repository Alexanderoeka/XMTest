<?php
declare(strict_types=1);


namespace App\Common\Command;


use App\Common\EmailSender;
use App\Domain\HistoricalQuotes\HistoricalQuotesService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCompaniesCommand extends Command
{
    private HistoricalQuotesService $historicalQuotesService;

    private EmailSender $emailSender;

    public function __construct(
        HistoricalQuotesService $historicalQuotesService,
        EmailSender $emailSender,
        string $name = null
    )
    {
        parent::__construct($name);

        $this->historicalQuotesService = $historicalQuotesService;
        $this->emailSender = $emailSender;
    }

    protected function configure()
    {
        $this->setName('get:companies')
            ->setDescription('Getting companies');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start getting companies');

        $result = $this->historicalQuotesService->getCompanies();

        $output->writeln('FINISHED TO DATABASE');

        $output->writeln('PROCESS SENDING EMAIL');

        $textSubject = 'companies is loaded';

        $bodyHtml = '<p>OMG! There are already here!!!!!! AA<p>';

        $emailResult = $this->emailSender->sendEmail('someOne@mail.ru', 'someTwo@mail.ru', $textSubject, $bodyHtml);

        $output->writeln("EMAIL SENT RESULT : $emailResult");


        return 0;
    }


}