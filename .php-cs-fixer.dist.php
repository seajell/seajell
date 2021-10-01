<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('vendor')
    ->notPath('bootstrap')
    ->notPath('storage')
    ->notPath('public')
    ->notPath('config')
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in(__DIR__);

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'ordered_imports' => ['sort_algorithm' => 'length'],
        'no_unused_imports' => true,
        'elseif' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'ternary_to_null_coalescing' => true,
        'linebreak_after_opening_tag' => true,
        'not_operator_with_successor_space' => false,
        'phpdoc_order' => true,
        'phpdoc_align' => ['align' => 'left'],
        'concat_space'=> ['spacing' => 'one'],
        'new_with_braces' => false,
        'phpdoc_no_empty_return' => false,
        'trailing_comma_in_multiline' => true,
        'whitespace_after_comma_in_array' => true,
        'method_chaining_indentation' => true,
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => [
            'statements' => ['return']
        ],
        'visibility_required' => [
            'elements' => ['method', 'property']
        ],
        'single_line_comment_style' => true,
    ])
    ->setFinder($finder);
