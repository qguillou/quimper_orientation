<?php

namespace Manager;

use Manager\DefaultManager;
use Form\Type\DocumentType;
use Entity\Document;

class DocumentManager extends DefaultManager
{
    public function create()
    {
        $entity = new Document();

        return $entity;
    }

    public function isEditable()
    {
        return false;
    }

    public function getFormClass()
    {
        return DocumentType::class;
    }

    public function getAdminPageTitle()
    {
        return "Administration des documents";
    }

    public function getDisplayColumnTitle()
    {
        return array(
            'URI'
        );
    }

    public function getDisplayColumn()
    {
        return array(
            'uri'
        );
    }

    public function getDisplayFormField()
    {
        return array(
        );
    }

    public function getOrderBy()
    {
        return array('uri' => 'ASC');
    }
}
