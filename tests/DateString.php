<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Formation;

/**
 * Tester la méthode getPublishedAtString
 *
 * @author Joachim
 */
class DateString extends TestCase{
    
    
    public function testGetDatecreationString(){
        $formation = new formation();
        $formation->setPublishedAt(new \DateTime("2020-03-12"));
        $this->assertEquals("2020-03-12", $formation->getPublishedAtString());
    
}
    
    
}
