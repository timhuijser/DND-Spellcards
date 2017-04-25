<?php

namespace AppBundle\Command\Crawler\DndSpells;

use AppBundle\Entity\CrawlUrl;
use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeDetailPageUrlsCommand extends ContainerAwareCommand
{
    const URL = 'https://www.dnd-spells.com/spells';

    protected function configure()
    {
        $this
            ->setName('crawler:scrape:dnd-spells:detail-urls')
            ->setDescription('Scrape dnd-spells.com for detail URLs')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $scraper = $client->request('GET', self::URL);

        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach ($scraper->filter('table#example > tbody > tr') as $i => $spellRow) {

            $crawler = new Crawler($spellRow);

            foreach ($crawler->filter('td') as $j => $spellField) {
                if ($j == 1) {
                    $title = new Crawler($spellField);

                    $url = $title
                        ->children()
                        ->first()
                        ->filterXPath("//a/@href")
                        ->text();

                    $crawlUrl = new CrawlUrl();
                    $crawlUrl->setUrl($url);
                    $crawlUrl->setSource(CrawlUrl::SOURCE_DND_SPELLS);

                    $em->persist($crawlUrl);
                }
            }
        }

        $em->flush();

        $output->writeln('Done');
    }
}
