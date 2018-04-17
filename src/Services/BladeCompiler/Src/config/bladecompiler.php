<?php

return [
    'directives' => [
        'example_directive' => \App\Services\BladeCompiler\Src\Compilers\Directives\ExampleDirective::class,
        'main_content' => \App\Services\BladeCompiler\Src\Compilers\Directives\MailMainContentDirective::class,
        'customer_name' => \App\Services\BladeCompiler\Src\Compilers\Directives\B2BInvitation\B2BBuyerNameDirective::class,
        'company_name' => \App\Services\BladeCompiler\Src\Compilers\Directives\B2BInvitation\B2BCompanyNameDirective::class,
    ],
];