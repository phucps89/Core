<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/5/2018
 * Time: 7:54 AM
 */

namespace PhucTran\Core\Services\BBCodeCompiler\Src;


use JBBCode\CodeDefinition;
use JBBCode\ElementNode;

class BBCodeDefinition extends CodeDefinition
{
    public function getChildrenAsHtml(ElementNode $el){
        $content = "";
        foreach($el->getChildren() as $child)
            $content .= $child->getAsHTML();
        return $content;
    }
}