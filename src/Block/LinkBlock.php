<?php

namespace App\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Mapper\FormMapper;
use Twig\Environment;
use App\Repository\LinkRepository;

final class LinkBlock extends AbstractBlockService
{
    private $linkRepository;

    public function __construct(Environment $templatingOrDeprecatedName, LinkRepository $linkRepository)
    {
        parent::__construct($templatingOrDeprecatedName);

        $this->linkRepository = $linkRepository;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null): Response
    {
        return $this->renderResponse('partials/block/link.html.twig', [
            'links'     => $this->linkRepository->findBy([]),
        ], $response);
    }
}
