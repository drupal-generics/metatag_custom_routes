<?php

namespace Drupal\metatag_custom_routes;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Transliteration\PhpTransliteration;

/**
 * Class MetatagCustomRoutesHelper.
 *
 * @package Drupal\metatag_custom_routes
 */
class MetatagCustomRoutesHelper {

  /**
   * The transliteration service.
   *
   * @var \Drupal\Core\Transliteration\PhpTransliteration
   */
  protected $transliteration;

  /**
   * MetatagCustomRoutesHelper constructor.
   *
   * @param \Drupal\Core\Transliteration\PhpTransliteration $transliteration
   *   The transliteration service.
   */
  public function __construct(
    PhpTransliteration $transliteration
  ) {
    $this->transliteration = $transliteration;
  }

  /**
   * Transforms the URI into a MetatagCustomRoutes config entity ID.
   *
   * Performs transliteration and character replace similarly to how
   * machine names are generated.
   *
   * @param string $uri
   *   The uri.
   *
   * @return mixed
   *   The transformed string.
   *
   * @see MachineNameController::transliterate()
   */
  public function transformUriToEntityId(string $uri) {
    $transliterated = $this->transliteration->transliterate($uri, 'fr', '_');
    $transliterated = Unicode::strtolower($transliterated);

    return preg_replace('@' . strtr('[^a-z0-9_]+', ['@' => '\@', chr(0) => '']) . '@', '_', $transliterated);
  }

}
