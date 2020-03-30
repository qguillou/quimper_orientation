<?php

declare(strict_types=1);

namespace App\Service\Export;

use App\Service\Model\ModelManager;
use EasyCorp\Bundle\EasyAdminBundle\Search\QueryBuilder as EasyadminQueryBuilder;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Twig\Environment;
use Knp\Snappy\Pdf;

class ExportManager
{
    /**
     * @var ExportDiscovery
     */
    private $discovery;

    private $twig;
    private $pdf;

    public function __construct(ExportDiscovery $discovery, Environment $twig, Pdf $pdf)
    {
        $this->discovery = $discovery;
        $this->twig = $twig;
        $this->pdf = $pdf;
    }

    /**
     * Returns a list of available export.
     *
     * @return array
     */
    public function getExports() {
        return $this->discovery->getExports();
    }

    /**
     * Returns one export by name
     *
     * @param $name
     * @return array
     *
     * @throws \Exception
     */
    public function getExport($name) {
        $exports = $this->discovery->getExports();
        if (isset($exports[$name])) {
            return $exports[$name];
        }

        throw new \Exception('Export not found.');
    }

    /**
     * Creates a export
     *
     * @param $name
     * @return ExportInterface
     *
     * @throws \Exception
     */
    public function create($name) {
        $exports = $this->discovery->getExports();
        if (array_key_exists($name, $exports)) {
            $class = $exports[$name]['class'];
            if (!class_exists($class)) {
                throw new \Exception('Export class does not exist.');
            }
            return new $class($this->twig, $this->pdf);
        }

        throw new \Exception('Export does not exist.');
    }
}
