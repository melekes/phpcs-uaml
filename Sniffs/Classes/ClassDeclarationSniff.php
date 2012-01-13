<?php
/**
 * Class Declaration Test.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Anton Kalyaev <anton.kalyaev@gmail.com>
 */

/**
 * Class Declaration Test.
 *
 * Checks the declaration of the class is correct.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Anton Kalyaev <anton.kalyaev@gmail.com>
 */
class UAML_Sniffs_Classes_ClassDeclarationSniff implements PHP_CodeSniffer_Sniff {

  /**
   * Returns an array of tokens this test wants to listen for.
   *
   * @return array
   */
  public function register() {
    return array(T_CLASS, T_INTERFACE);
  }


  /**
   * Processes this test, when one of its tokens is encountered.
   *
   * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
   * @param integer              $stackPtr  The position of the current token in the
   *                                        stack passed in $tokens.
   *
   * @return void
   */
  public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
    $tokens = $phpcsFile->getTokens();
    $errorData = array($tokens[$stackPtr]['content']);

    if (isset($tokens[$stackPtr]['scope_opener']) === false) {
      $error = 'Possible parse error: %s missing opening or closing brace';
      $phpcsFile->addWarning($error, $stackPtr, 'MissingBrace', $errorData);
      return;
    }

    $curlyBrace = $tokens[$stackPtr]['scope_opener'];
    $lastContent = $phpcsFile->findPrevious(T_WHITESPACE, ($curlyBrace - 1), $stackPtr, true);
    $classLine = $tokens[$lastContent]['line'];
    $braceLine = $tokens[$curlyBrace]['line'];
    if ($braceLine !== $classLine) {
      $error = 'Opening brace of a %s must be on the same line as the definition';
      $phpcsFile->addError($error, $curlyBrace, 'OpenBraceSameLine', $errorData);
      return;
    }

    if ($tokens[($curlyBrace + 1)]['content'] !== $phpcsFile->eolChar) {
      $error = 'Opening %s brace must be the last in the line';
      $phpcsFile->addError($error, $curlyBrace, 'OpenBraceNotLast', $errorData);
    }

    if ($tokens[($lastContent + 1)]['code'] !== T_WHITESPACE) {
      $error = 'Expected a single space character before the opening brace';
      $phpcsFile->addError($error, $curlyBrace, 'SpaceBeforeBrace');
    }

    $columnDifference = $tokens[$curlyBrace]['column'] - $tokens[($lastContent + 1)]['column'];
    if ($columnDifference !== 1) {
      $error = 'Expected 1 space between the class declaration and the opening brace; found %s';
      $data  = array(($columnDifference - 1));
      $phpcsFile->addError($error, $curlyBrace, 'SpaceBeforeBrace', $data);
      return;
    }
  }
}

?>
