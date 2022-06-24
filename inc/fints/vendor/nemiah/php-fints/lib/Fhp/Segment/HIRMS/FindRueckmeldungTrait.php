<?php

namespace Fhp\Segment\HIRMS;

/**
 * Utility functions for segments that contain an array of {@link Rueckmeldung}.
 * Implements {@link RueckmeldungContainer}.
 */
trait FindRueckmeldungTrait
{
    /**
     * @param int $code The value of Rueckmeldung.rueckmeldungscode to search for.
     * @return Rueckmeldung|null The corresponding Rueckmeldung instance, or null if not found.
     */
    public function findRueckmeldung(int $code): ?Rueckmeldung
    {
        $matches = $this->findRueckmeldungen($code);

        if (count($matches) > 1) {
            throw new \InvalidArgumentException("Unexpectedly multiple matches for Rueckmeldungscode $code");
        }
        return count($matches) === 0 ? null : $matches[0];
    }

    /** @return Rueckmeldung[] */
    public function findRueckmeldungen(int $code): array
    {
        return array_values(array_filter($this->rueckmeldung, function ($rueckmeldung) use ($code) {
            return $rueckmeldung->rueckmeldungscode === $code;
        }));
    }
}
