<?php

namespace App\Block;

use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use App\Repository\MenuRepository;
use Twig\Environment;

final class MenuBlock extends AbstractBlockService
{
    private $menuRepository;

    public function __construct(Environment $templatingOrDeprecatedName, MenuRepository $menuRepository = null)
    {
        parent::__construct($templatingOrDeprecatedName);

        $this->menuRepository = $menuRepository;
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null): Response
    {
        return $this->renderResponse('partials/block/menu.html.twig', [
            'menus'     => $this->menuRepository->findBy([]),
        ], $response);
    }
}
