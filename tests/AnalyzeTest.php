<?php
require 'tests/Analyze.php';
use PHPUnit\Framework\TestCase;
class AnalyzeTest extends TestCase
{
    public function testExample()
    {
		$p=new Analyze;
 		$tes=[
		"u"=>70,
		"t"=>11
		];
		$p->accessAnalyze($tes);
		$result=$p->countInterval;
        $this->assertEquals(2, $result);
		
		
		$tes=[
		"u"=>50,
		"t"=>11
		];
		$p->accessAnalyze($tes);
		$result=$p->countInterval;
        $this->assertEquals(0, $result);
		
		
 		$tes=[
		"u"=>50,
		"t"=>9
		];
		$p->accessAnalyze($tes);
		$result=$p->countInterval;
        $this->assertEquals(1, $result); 
		
		$tes=[
		"u"=>99,
		"t"=>11
		];
		$p->accessAnalyze($tes);
		$result=$p->countInterval;
        $this->assertEquals(1, $result); 
    }
}