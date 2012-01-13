<?php
/**
 * Verifies that control statements conform to their coding standards.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Anton Kalyaev <anton.kalyaev@gmail.com>
 */

if (class_exists('PHP_CodeSniffer_Standards_AbstractPatternSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_AbstractPatternSniff not found');
}

/**
 * Verifies that control statements conform to their coding standards.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Anton Kalyaev <anton.kalyaev@gmail.com>
 */
class UAML_Sniffs_ControlStructures_ControlSignatureSniff extends PHP_CodeSniffer_Standards_AbstractPatternSniff {

  /**
   * Constructs a UAML_Sniffs_ControlStructures_ControlSignatureSniff.
   */
  public function __construct() {
    parent::__construct(true);
  }


  /**
   * Returns the patterns that this test wishes to verify.
   *
   * @return array(string)
   */
  protected function getPatterns() {
    return array(
             'do {...}EOL while (...);EOL',
             'while (...) {',
             'for (...) {',
             'if (...) {',
             'foreach (...) {',
             'do {',
             '}EOL else if (...) {',
             '}EOL elseif (...) {',
             '}EOL else {',
           );
  }
}
