<?php

namespace App\Service\Export;

use App\Annotation\Export;
use App\Entity\Event;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use Sonata\Exporter\Handler;
use Sonata\Exporter\Source\SourceIteratorInterface;
use Sonata\Exporter\Writer\CsvWriter;
use Sonata\Exporter\Writer\JsonWriter;
use Sonata\Exporter\Writer\XlsWriter;
use Sonata\Exporter\Writer\XmlWriter;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Sonata\Exporter\Source\ArraySourceIterator;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Twig\Environment;
use Knp\Snappy\Pdf;

/**
 * Class PdfClubExport.
 *
 * @Export(
 *     name="pdf-club"
 * )
 */
final class PdfClubExport implements ExportInterface
{
    private $twig;
    private $pdf;

    public function __construct(Environment $twig, Pdf $pdf)
    {
        $this->twig = $twig;
        $this->pdf = $pdf;
    }

    public function export(Event $event)
    {
        if ($event->getNumberPeopleByEntries() > 1) {
            $html = $this->twig->render('entry/export_pdf_club_teams.html.twig', [
                'event'  => $event
            ]);
        }
        else {
            $html = $this->twig->render('entry/export_pdf_club_individuals.html.twig', [
                'event'  => $event
            ]);
        }


        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html, array(
                'encoding' => 'utf-8'
            )),
            'file.pdf'
        );
    }
}
