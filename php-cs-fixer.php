<?php
return (new PhpCsFixer\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()->in(__DIR__ . '/src')
    )
    ->setRules([
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => false,
        // 'braces' => true,
        'class_definition' => [
            'inline_constructor_arguments' => false, // handled by method_argument_space fixer
            'space_before_parenthesis' => true, // defined in PSR12 ¶8. Anonymous Classes
        ],
        // 'curly_braces_position' => [
        //     'control_structures_opening_brace' => 'same_line',
        //     'functions_opening_brace' => 'next_line_unless_newline_at_signature_end',
        //     'anonymous_functions_opening_brace' => 'same_line',
        //     'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        //     'anonymous_classes_opening_brace' => 'same_line',
        //     'allow_single_line_empty_anonymous_classes' => true,
        //     'allow_single_line_anonymous_functions' => true,
        // ],
        'compact_nullable_typehint' => true,
        'constant_case' => true,
        'declare_equal_normalize' => true,
        'elseif' => true,
        'full_opening_tag' => true,
        'function_declaration' => true,
        'indentation_type' => true,
        'line_ending' => true,
        'lowercase_cast' => true,
        'lowercase_keywords' => true,
        'lowercase_static_reference' => true,
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'new_with_braces' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_break_comment' => true,
        'no_closing_tag' => true,
        'no_leading_import_slash' => true,
        'no_space_around_double_colon' => true,
        'no_spaces_after_function_name' => true,
        'no_spaces_inside_parenthesis' => true,
        'no_trailing_whitespace' => true,
        'no_trailing_whitespace_in_comment' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
            ],
        ],
        'ordered_imports' => [
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
            'sort_algorithm' => 'alpha',
        ],
        // 'return_type_declaration' => true,
        'short_scalar_cast' => true,
        'single_blank_line_at_eof' => true,
        'single_blank_line_before_namespace' => false,
        'single_class_element_per_statement' => true,
        'single_import_per_statement' => [
            'group_to_single_imports' => true,
        ],
        'single_line_after_imports' => true,
        'single_trait_insert_per_statement' => true,
        'switch_case_semicolon_to_colon' => true,
        'switch_case_space' => true,
        'ternary_operator_spaces' => true,
        'visibility_required' => true,
    ])
;
