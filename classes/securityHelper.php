<?php
/**
 * Security helper functions to prevent ModSecurity issues and SQL injection
 */
class SecurityHelper
{
  /**
   * Sanitize and validate numeric ID from GET/POST
   * Returns integer or null if invalid
   */
  public static function sanitizeId($id)
  {
    if (!isset($id) || empty($id)) {
      return null;
    }
    // Remove any non-numeric characters
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    // Validate as integer
    $id = filter_var($id, FILTER_VALIDATE_INT);
    return ($id !== false && $id > 0) ? (int)$id : null;
  }

  /**
   * Sanitize string input for database
   */
  public static function sanitizeString($connection, $input)
  {
    if (!isset($input)) {
      return '';
    }
    $input = trim($input);
    $input = stripslashes($input);
    return mysqli_real_escape_string($connection, $input);
  }

  /**
   * Sanitize email input
   */
  public static function sanitizeEmail($connection, $email)
  {
    if (!isset($email)) {
      return '';
    }
    $email = trim($email);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return mysqli_real_escape_string($connection, $email);
  }

  /**
   * Sanitize output for HTML display
   */
  public static function escapeHtml($string)
  {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
  }
}
