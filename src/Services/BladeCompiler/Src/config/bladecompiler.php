<?php

return [
    'directives' => [
        'example_directive' => \Sel2b\Core\Services\BladeCompiler\Src\Compilers\Directives\ExampleDirective::class,
        'main_content' => \Sel2b\Core\Services\BladeCompiler\Src\Compilers\Directives\MailMainContentDirective::class,
        'customer_name' => \Sel2b\Core\Services\BladeCompiler\Src\Compilers\Directives\B2BInvitation\B2BBuyerNameDirective::class,
        'company_name' => \Sel2b\Core\Services\BladeCompiler\Src\Compilers\Directives\B2BInvitation\B2BCompanyNameDirective::class,
    ],
];