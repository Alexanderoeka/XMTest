<?php
declare(strict_types=1);


namespace App\Common\Command;


use App\Common\CollectionDto;
use App\Domain\HistoricalQuotes\Dto\CompanySelectDto;
use App\Domain\HistoricalQuotes\Factory\CompanyFactory;
use App\Domain\HistoricalQuotes\Request\RequestTypes;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCompaniesCommand extends Command
{


    public function __construct(
        private RequestTypes $requestTypes,
        private CompanyFactory $companyFactory
    )
    {
        parent::__construct();

    }

    protected function configure()
    {
        $this->setName('get:companies')
            ->setDescription('Getting companies');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start getting companies');

        $companyNameSymbolArray = $this->requestTypes->getCompaniesNameAndSymbolAPI();

        $output->writeln('Start inserting companies');

        /** @var CompanySelectDto[] $companiesDto */
        $companiesDto = CollectionDto::getData($companyNameSymbolArray, CompanySelectDto::class);

        $this->companyFactory->makeBatch($companiesDto);

        $output->writeln('FINISH');

        return 0;
    }


}