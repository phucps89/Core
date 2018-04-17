<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/4/2018
 * Time: 7:23 PM
 */

namespace PhucTran\Core\Services\BladeCompiler\Src;


use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class BladeCompilerService
{

    private $_params;

    /**
     * BladeCompilerService constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        $config = require_once 'config/bladecompiler.php';
        $this->initDirective($config['directives']);
    }

    private function initDirective($directives)
    {
        if (is_null($directives)) {
            return;
        }
        foreach ($directives as $directive => $compiler) {
            $objCompiler = app($directives[$directive]);
            if ($objCompiler instanceof BladeDirectiveInterface) {
                Blade::directive($directive, function ($expression) use ($objCompiler) {
                    return $objCompiler->transform($expression, $this->_params);
                });
            }
            else {
                throw new InternalErrorException('Directive compiler must implement interface ' . BladeDirectiveInterface::class);
            }
        }
    }

    public function compileString($templateContent, $params = null)
    {
        $fileResult = $this->storeTemplate($templateContent);
        $this->_params = $params;
        $content = view($fileResult['ins'], [
            'data' => $params
        ])->render(function () use ($fileResult) {
            unlink($fileResult['file']);
        });
        return $content;
    }

    public function compileFile($templateFile, $params = null)
    {
        $content = view($templateFile, [
            'data' => $params
        ]);
        return $content;
    }

    private function storeTemplate($templateContent)
    {
        $storage = Storage::disk('view');
        $insTemp = 'template_' . uniqid();
        $storage->put($insTemp . '.blade.php', $templateContent);
        return [
            'file' => $storage->url($insTemp . '.blade.php'),
            'ins'  => $insTemp
        ];
    }
}