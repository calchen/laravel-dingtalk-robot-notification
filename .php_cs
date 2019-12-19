<?php

/**
 * 根据 StyleCI 的 Laravel Preset 整理的 PHP Coding Standards Fixer 规则
 * 注释掉的是 Fixer 中不存在的
 * 行尾注释，表示该行规则命名存在差异
 */
$rules = [
    '@PSR2' => true,
    'phpdoc_align' => true,  // align_phpdoc
    'binary_operator_spaces' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_return' => true,
    'cast_spaces' => true,
    'concat_space' => true,  // concat_without_spaces
    'declare_equal_normalize' => true,
    'function_typehint_space' => true,
    'hash_to_slash_comment' => true,
    'heredoc_to_nowdoc' => true,
    'include' => true,
    // length_ordered_imports 根据 .styleci.yml 禁用
    'lowercase_cast' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'method_separation' => true,
    'native_function_casing' => true,
    'native_function_type_declaration_casing' => true,
    'no_alias_functions' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    // 'no_blank_lines_after_throw' => true,
    // 'no_blank_lines_between_imports' => true,
    // 'no_blank_lines_between_traits' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_extra_consecutive_blank_lines' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_short_bool_cast' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_around_offset' => ['positions' => ['inside']],  // no_spaces_inside_offset
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unreachable_default_argument_value' => true,
    // no_unused_imports 根据 .styleci.yml 禁用
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'normalize_index_brace' => true,
    'not_operator_with_successor_space' => true,
    'object_operator_without_whitespace' => true,
    'phpdoc_indent' => true,
    'phpdoc_inline_tag' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    'phpdoc_to_comment' => true,
    'phpdoc_trim' => true,
    // 'phpdoc_type_to_var' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'pre_increment' => true,  // post_increment
    'no_mixed_echo_print' => true,  // print_to_echo
    'self_accessor' => true,
    'array_syntax' => ['syntax' => 'short'],  // short_array_syntax
    'list_syntax' => ['syntax' => 'short' ],  // short_list_syntax
    'short_scalar_cast' => true,
    'simplified_null_return' => true,
    'single_blank_line_before_namespace' => true,
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline_array' => true,
    'trim_array_spaces' => true,
    // 'unalign_equals' => true,
    'unary_operator_spaces' => true,
    'whitespace_after_comma_in_array' => true,

    //  根据 .styleci.yml 启用额外规则
    'ordered_imports' => true,

];
return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    );