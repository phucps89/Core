<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 10:02 PM
 */

namespace Sel2b\Core\Services\BBCodeCompiler\Src;

use DOMDocument;

class BBCodeCompilerService
{
    protected $_removeTags = [
        'script',
        'style',
        'iframe',
        'embed',
        'link',
        'a',
        'img',
        'address',
        'h1',
        'h2',
        'h3',
        'table',
        'tr',
        'td',
        'div',
        'span',
        'label',
        'input',
        'textarea',
        'form',
        'button',
        'textarea',
        'select',
        'hr',
        'br',
    ];

    private $_bbCodes;

    private $_parser;

    /**
     * BBCodeCompilerService constructor.
     * @param array $_removeTags
     */
    public function __construct()
    {
        $this->_bbCodes = require_once 'config/bbcode.php';
        $this->_parser = new \JBBCode\Parser();
        foreach ($this->_bbCodes as $bbCode) {
            $this->_parser->addCodeDefinition(app($bbCode));
        }
    }


    public function compile($content)
    {
        $content = $this->removeElementsByTagName($content);
        $content = strip_tags($content);

        $this->_parser->addCodeDefinitionSet(new \JBBCode\DefaultCodeDefinitionSet());
        return $this->_parser->parse($content)->getAsHTML();
    }

    private function removeElementsByTagName($content)
    {
        // create a new DomDocument object
        $document = new DOMDocument();

        // load the HTML into the DomDocument object (this would be your source HTML)
        $document->loadHTML($content);
        foreach ($this->_removeTags as $tag) {
            $nodeList = $document->getElementsByTagName($tag);
            for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0;) {
                $node = $nodeList->item($nodeIdx);
                $node->parentNode->removeChild($node);
            }
        }
        return $document->textContent;
    }
}