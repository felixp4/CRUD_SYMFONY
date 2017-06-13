<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 12.06.17
 * Time: 9:58
 */

declare (strict_types=1);

namespace Tests\AppBundle\Util;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUsername()
    {
        $testUsername = 'User Name';
        $user = new User();
        $user->setUsername($testUsername);
        $this->assertEquals($testUsername, $user->getUsername());
    }

    public function testPassword()
    {
        $testPassword = 'Pass Word';
        $user = new User();
        $user->setPassword($testPassword);
        $this->assertEquals($testPassword, $user->getPassword());
    }

    public function testEmail()
    {
        $testEmail = 'admin@example.com';
        $user = new User();
        $user->setEmail($testEmail);
        $this->assertEquals($testEmail, $user->getEmail());
    }

    public function testIsActive()
    {
        $testIsActive = true;
        $user = new User();
        $user->setIsActive($testIsActive);
        $this->assertEquals($testIsActive, $user->getIsActive());
    }

    public function testId()
    {
        $user = new User();
        $this->assertEquals(null, $user->getId());
    }

    public function testRoles()
    {
        $user = new User();
        $this->assertInternalType('array',$user->getRoles());
    }
}