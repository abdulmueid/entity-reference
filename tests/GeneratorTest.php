<?php

use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    /**
     * @var \abdulmueid\EntityReference\Generator
     */
    private $generator;

    /**
     * @var int
     */
    private $entity;

    /**
     * @var int
     */
    private $amount;

    protected function setUp(): void
    {
        $this->generator = new \abdulmueid\EntityReference\Generator();
        $this->entity = '82002';
        $this->amount = '50';
    }

    /**
     * Test Reference Generation
     * @return string
     */
    public function testGenerateReference(): string
    {
        $reference = $this->generator->generateReference($this->entity, $this->amount);
        $this->assertNotEmpty($reference);
        $this->assertIsString($reference);
        $this->assertEquals(11, mb_strlen($reference));
        return $reference;
    }

    /**
     * Test Reference Validation
     * @depends testGenerateReference
     * @param $reference string
     */
    public function testIsReferenceValid(string $reference)
    {
        $result = $this->generator->isReferenceValid($this->entity, $this->amount, $reference);
        $this->assertTrue($result);
    }

    /**
     * Test Bulk Reference Generation
     * @return array
     */
    public function testGenerateReferences(): array
    {
        $referencesToGenerate = 100;
        $references = $this->generator->generateReferences($this->entity, $this->amount, $referencesToGenerate);
        $this->assertNotEmpty($references);
        $this->assertIsArray($references);
        $this->assertCount($referencesToGenerate, $references);
        return $references;
    }

    /**
     * Validate References Generated in Bulk
     * @depends testGenerateReferences
     * @param array $references
     */
    public function testAreReferencesValid(array $references)
    {
        foreach ($references as $key => $value) {
            $this->assertTrue($this->generator->isReferenceValid($this->entity, $this->amount, $value));
        }
    }
}