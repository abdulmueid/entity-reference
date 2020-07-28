<?php

namespace abdulmueid\EntityReference;

class Generator
{
    /**
     * Generates a complete Reference with Check Digit
     * @param $entity
     * @param $amount
     * @param null $prefix
     * @return string
     */
    public function generateReference($entity, $amount, $prefix = null)
    {
        $prefix = $prefix ?? mt_rand(0, 9999999);
        $tmpReference = "0000000" . $prefix;
        $reference = substr($tmpReference, strlen($tmpReference) - 7, strlen($tmpReference)) . "05" . "00";

        $digits = "";
        $digits .= $entity;
        $digits .= substr($reference, 0, strlen($reference) - 2);
        $digits .= $amount;

        $s = 0;
        $p = 0;
        for ($j = 0; $j < strlen($digits); $j++) {
            $s = $digits[$j] + $p;
            $p = ($s * 10) % 97;
        }
        $p = ($p * 10) % 97;

        $checkDigit = 98 - $p;
        $strCheckDigit = "00" . $checkDigit;
        $strCheckDigit = substr($strCheckDigit, strlen($strCheckDigit) - 2, strlen($strCheckDigit));
        $reference = substr($reference, 0, strlen($reference) - 2) . $strCheckDigit;
        return $reference;
    }

    /**
     * Generates References in Bulk
     * @param string $entity
     * @param string $amount
     * @param int $totalReferencesToGenerate
     * @return array
     */
    public function generateReferences(string $entity, string $amount, int $totalReferencesToGenerate = 1)
    {
        $references = array_fill(0, $totalReferencesToGenerate, "");
        for ($i = 0; $i < $totalReferencesToGenerate; $i++) {
            $references[$i] = $this->generateReference($entity, $amount, $i);
        }
        return $references;
    }

    /**
     * Validates References
     * @param string $entity
     * @param string $amount
     * @param string $referenceWithCheckDigit
     * @return bool
     */
    function isReferenceValid(string $entity, string $amount, string $referenceWithCheckDigit): bool
    {
        $digits = "";
        $digits .= $entity;
        $digits .= substr($referenceWithCheckDigit, 0, strlen($referenceWithCheckDigit) - 2);
        $digits .= $amount;

        $s = 0;
        $p = 0;
        for ($j = 0; $j < strlen($digits); $j++) {
            $s = $digits[$j] + $p;
            $p = ($s * 10) % 97;
        }
        $p = ($p * 10) % 97;
        $checkDigit = 98 - $p;
        return $checkDigit == substr($referenceWithCheckDigit, strlen($referenceWithCheckDigit) - 2);
    }
}
