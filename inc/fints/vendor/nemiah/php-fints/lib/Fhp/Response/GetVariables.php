<?php

namespace Fhp\Response;

use Fhp\Segment\BaseSegment;
use Fhp\Segment\HIRMS\HIRMSv2;
use Fhp\Segment\HIRMS\Rueckmeldungscode;
use Fhp\Segment\HITANS\HITANS;

/**
 * Class GetVariables
 * @package Fhp\Response
 */
class GetVariables extends Response
{
	public function get()
	{
		$variables = new \stdClass();
        $variables->tanModes = $this->parseTanModes();
		return $variables;
	}

	public function getSupportedTanMechanisms() {
		return $this->get()->tanModes;
	}

    private function parseTanModes()
    {
        $allowedModes = null;
        // TODO This should just grab the HIRMS referencing the HKVVB segment, not any others.
        foreach ($this->findSegments('HIRMS') as $segmentRaw) {
            $allowed = HIRMSv2::parse($segmentRaw)->findRueckmeldung(Rueckmeldungscode::ZUGELASSENE_VERFAHREN);
            if (isset($allowed)) {
                $allowedModes = array_map('intval', $allowed->rueckmeldungsparameter);
                break;
            }
        }

		$result = array();
        foreach ($this->findSegments('HITANS') as $segmentRaw) {
            $hitans = BaseSegment::parse($segmentRaw);
            if (!($hitans instanceof HITANS)) {
                throw new \InvalidArgumentException("All HITANS segments must implement the HITANS interface");
            }
            foreach ($hitans->getParameterZweiSchrittTanEinreichung()->getVerfahrensparameterZweiSchrittVerfahren() as $verfahren) {
                if ($allowedModes === null || in_array($verfahren->getSicherheitsfunktion(), $allowedModes)) {
                    $result[$verfahren->getSicherheitsfunktion()] = $verfahren->getNameDesZweiSchrittVerfahrens();
                }
            }
        }
		return $result;
	}
}
