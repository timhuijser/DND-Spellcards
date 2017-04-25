<?php

namespace AppBundle\Command\Crawler\DndSpells;

use AppBundle\Entity\CharacterClass;
use AppBundle\Entity\CrawlUrl;
use AppBundle\Entity\Spell;
use Doctrine\Common\Collections\ArrayCollection;
use Goutte\Client;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeDataFromDetailPageCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('crawler:scrape:dnd-spells:detail-page')
            ->setDescription('Scrape spell detail pages from dnd-spells.com')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crawlUrlRepository = $this->getContainer()->get('doctrine')->getRepository('AppBundle:CrawlUrl');
        $characterClassRepository = $this->getContainer()->get('doctrine')->getRepository('AppBundle:CharacterClass');
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        $crawlUrls = $crawlUrlRepository->findBy([
            'source' => CrawlUrl::SOURCE_DND_SPELLS,
        ]);

        $progress = new ProgressBar($output, count($crawlUrls));
        $progress->start();

        /** @var CrawlUrl $crawlUrl */
        foreach ($crawlUrls as $crawlUrl) {

            $client = new Client();
            $scraper = $client->request('GET', $crawlUrl->getUrl());

            $spell = new Spell();

            $titleCrawler = $scraper->filter('h1.classic-title');
            $spell->setTitle($titleCrawler->text());

            $titleChildren = $titleCrawler->siblings()->filter('p');

            /** @var \DOMElement $titleChild */
            foreach ($titleChildren as $i => $titleChild) {

                switch ($i) {

                    case 0:
                        $spell->setSchool($titleChild->nodeValue);
                        break;

                    case 1:
                        $spell->setLevel($this->retrieveDataFromText($titleChild->textContent, 'Level'));
                        $spell->setCastingTime($this->retrieveDataFromText($titleChild->textContent, 'Casting time'));
                        $spell->setRange($this->retrieveDataFromText($titleChild->textContent, 'Range'));
                        $spell->setComponents($this->retrieveDataFromText($titleChild->textContent, 'Components'));
                        $spell->setDuration($this->retrieveDataFromText($titleChild->textContent, 'Duration'));
                        break;

                    case 2:
                        $spell->setDescription($titleChild->textContent);
                        break;

                    case 3:
                        $description = $spell->getDescription();
                        $description .= PHP_EOL . $titleChild->textContent;
                        $spell->setDescription($description);
                        break;

                    case 5:
                       $classes = $this->retrieveCharacterClassesFromText($titleChild->textContent);

                       $characterClasses = new ArrayCollection();
                       foreach ($classes as $class) {
                           $characterClass = $characterClassRepository->findOneBy([
                               'slug' => $class,
                           ]);

                           $characterClasses->add($characterClass);

                           /** @var CharacterClass $characterClass */
                           $characterClass->addSpell($spell);
                           $entityManager->persist($characterClass);
                       }

                       $spell->setCharacterClasses($characterClasses);
                       break;

                }

            }

            $entityManager->persist($spell);

            $progress->advance();

        }

        $entityManager->flush();

        $progress->finish();
    }

    /**
     * @param $text
     * @param $element
     * @return mixed
     */
    private function retrieveDataFromText($text, $element)
    {
        $values = [];

        $explodedText = explode(PHP_EOL, trim($text));
        $explodedText = array_map('trim', $explodedText);

        foreach ($explodedText as $text) {
            $separatedText = explode(':', $text);
            $values[$separatedText[0]] = trim($separatedText[1]);
        }

        return $values[$element];
    }

    private function retrieveCharacterClassesFromText($text)
    {
        $characterClasses = [];

        foreach (CharacterClass::getSlugs() as $slug) {
            if (stripos($text, $slug)) {
                $characterClasses[] = $slug;
            }
        }

        return $characterClasses;
    }
}
