<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor'])
    ->in(__DIR__);

$config = new PhpCsFixer\Config();

return $config->setUsingCache(true)
    ->setRules([
        '@PSR2'                                 => true,
        'encoding'                              => true,
        'echo_tag_syntax'                       => true,
        'elseif'                                => true,
        'blank_line_after_opening_tag'          => true,
        'no_leading_namespace_whitespace'       => true,
        'no_blank_lines_after_class_opening'    => true,
        'no_trailing_comma_in_singleline_array' => true,
        'concat_space'                          => [
            'spacing' => 'one',
        ],
        'function_declaration' => [
            'closure_function_spacing' => 'one',
        ],
        'single_blank_line_at_eof'            => true,
        'ordered_imports'                     => true,
        'single_line_after_imports'           => true,
        'no_trailing_whitespace'              => true,
        'blank_line_before_statement'         => true,
        'indentation_type'                    => true,
        'braces'                              => true,
        'visibility_required'                 => true,
        'no_unused_imports'                   => true,
        'no_closing_tag'                      => true,
        'no_blank_lines_after_phpdoc'         => true,
        'no_empty_phpdoc'                     => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_align'                        => [
            'tags' => ['param', 'return', 'throws', 'type', 'var', 'property'],
        ],
        'phpdoc_annotation_without_dot' => true,
        'phpdoc_inline_tag_normalizer'  => true,
        'phpdoc_order'                  => true,
        'phpdoc_scalar'                 => true,
        'phpdoc_separation'             => true,
        'phpdoc_trim'                   => true,
        'phpdoc_var_without_name'       => true,
        'array_syntax'                  => ['syntax' => 'short'],
        'binary_operator_spaces'        => ['operators' => ['=>' => 'align_single_space_minimal', '=' => 'align_single_space_minimal']],
        'constant_case'                 => ['case' => 'lower'],
        'lowercase_keywords'            => true,
        'blank_line_after_namespace'    => true,
        'method_argument_space'         => true,
        'no_spaces_inside_parenthesis'  => true,
        'unary_operator_spaces'         => true,
        'trailing_comma_in_multiline'   => true,
        'magic_constant_casing'         => true,
    ])
    ->setFinder($finder);
