<?php

// config for Wepamultimedia/Faq
return [
    'backend_menu' => [
        [
            'label' => 'en:Faq|es:Faq',
            'icon' => 'chat-alt-2',
            'route' => '#',
            'active' => 'admin.faq*',
            'can' => 'admin.auth',
            'children' => [
                [
                    'label' => 'en:Categories|es:Categorías',
                    'route' => 'admin.faq.categories.index',
                    'active' => 'admin.faq.categories*',
                    'can' => 'admin.auth',
                ],
                [
                    'label' => 'en:Questions and Answers|es:Preguntas y respuestas',
                    'route' => 'admin.faq.questions-answers.index',
                    'active' => 'admin.faq.questions-answers*',
                    'can' => 'admin.auth',
                ],
            ],
        ],
    ],
];
