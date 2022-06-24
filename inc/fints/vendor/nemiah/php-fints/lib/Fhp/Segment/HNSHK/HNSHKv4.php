<?php
/** @noinspection PhpUnused */

namespace Fhp\Segment\HNSHK;

use Fhp\Model\TanMode;
use Fhp\Options\Credentials;
use Fhp\Options\FinTsOptions;
use Fhp\Segment\BaseSegment;
use Fhp\Segment\Common\Kik;

/**
 * Segment: Signaturkopf (Version 4)
 *
 * @link https://www.hbci-zka.de/dokumente/spezifikation_deutsch/fintsv3/FinTS_3.0_Security_Sicherheitsverfahren_HBCI_Rel_20181129_final_version.pdf
 * Section: B.5.1
 *
 * @link https://www.hbci-zka.de/dokumente/spezifikation_deutsch/fintsv3/FinTS_3.0_Security_Sicherheitsverfahren_PINTAN_2018-02-23_final_version.pdf
 * Section B.9.4
 */
class HNSHKv4 extends BaseSegment
{
    /** @var \Fhp\Segment\HNVSK\SicherheitsprofilV1 */
    public $sicherheitsprofil;
    /**
     * For the PIN/TAN profile (see section B.9.4), this must be:
     *   - 998 for Ein-Schritt-Verfahren, or
     *   - the value in the 900--997 range as received in
     *     {@link \Fhp\Segment\TAN\VerfahrensparameterZweiSchrittVerfahrenv6::$sicherheitsfunktion}
     * @var int
     */
    public $sicherheitsfunktion;
    /** @var string Max length: 14; A nonce, that matches the one in HNSHA */
    public $sicherheitskontrollreferenz;
    /**
     * 1: Signaturkopf und HBCI-Nutzdaten (SHM)
     * (not allowed: 2: Von Signaturkopf bis Signaturabschluss (SHT))
     * @var int (Version 2)
     */
    public $bereichDerSicherheitsapplikation = 1; // This is the only allowed value.
    /**
     * 1: Der Unterzeichner ist Herausgeber der signierten Nachricht, z. B. Erfasser oder Erstsignatur (ISS)
     * 3: Der Unterzeichner unterstützt den Inhalt der Nachricht, z. B. bei Zweitsignatur (CON)
     * 4: Der Unterzeichner ist Zeuge, aber für den Inhalt der Nachricht nicht verantwortlich, z. B. Übermittler,
     *    welcher nicht Erfasser ist (WIT)
     * @var int
     */
    public $rolleDesSicherheitslieferanten = 1;
    /** @var \Fhp\Segment\HNVSK\SicherheitsidentifikationDetailsV2 */
    public $sicherheitsidentifikationDetails;
    /** @var int */
    public $sicherheitsreferenznummer = 1; // Not used / supported by this library, so just a dummy value.
    /** @var \Fhp\Segment\HNVSK\SicherheitsdatumUndUhrzeitV2 */
    public $sicherheitsdatumUndUhrzeit;
    /** @var HashalgorithmusV2 */
    public $hashalgorithmus;
    /** @var SignaturalgorithmusV2 */
    public $signaturalgorithmus;
    /** @var \Fhp\Segment\HNVSK\SchluesselnameV3 */
    public $schluesselname;
    /** @var \Fhp\Segment\HNVSK\ZertifikatV2|null For the PIN/TAN profile, this must be empty (see section B.9.4). */
    public $zertifikat;

    /**
     * @param string $sicherheitskontrollreferenz A nonce (random number) to reference the corresponding HNSHA segment.
     * @param FinTsOptions $options See {@link FinTsOptions}.
     * @param Credentials $credentials See {@link Credentials}.
     * @param TanMode|null $tanMode Optionally specifies which two-step TAN mode to use, defaults to 999 (single step).
     * @param string $kundensystemId See {@link SicherheitsidentifikationDetailsV2::$identifizierungDerPartei}.
     */
    public static function create(string $sicherheitskontrollreferenz, FinTsOptions $options, Credentials $credentials, ?TanMode $tanMode, string $kundensystemId): HNSHKv4
    {
        $result = HNSHKv4::createEmpty();
        $result->sicherheitsprofil =
            \Fhp\Segment\HNVSK\SicherheitsprofilV1::createPIN($tanMode);
        $result->sicherheitsfunktion = $tanMode === null ? TanMode::SINGLE_STEP_ID : $tanMode->getId();
        $result->sicherheitskontrollreferenz = $sicherheitskontrollreferenz;
        $result->sicherheitsidentifikationDetails =
            \Fhp\Segment\HNVSK\SicherheitsidentifikationDetailsV2::createForSender($kundensystemId);
        $result->sicherheitsdatumUndUhrzeit =
            \Fhp\Segment\HNVSK\SicherheitsdatumUndUhrzeitV2::now();
        $result->hashalgorithmus = new HashalgorithmusV2();
        $result->signaturalgorithmus = new SignaturalgorithmusV2();
        $result->schluesselname = \Fhp\Segment\HNVSK\SchluesselnameV3::create(
            Kik::create($options->bankCode),
            $credentials->getBenutzerkennung(),
            \Fhp\Segment\HNVSK\SchluesselnameV3::SIGNIERSCHLUESSEL);
        return $result;
    }
}
