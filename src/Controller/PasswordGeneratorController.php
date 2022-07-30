<?php

/**
 * Microservices for password generator
 * 
 * PHP version 8.1.6
 * 
 * @category Controller
 * @package  PasswordGenerator
 * @author   Kamil Jakubowicz <kjakubowicz98@interia.pl>
 * @license  GNU General Public License
 * @link     none
 * @return   JsonReposne
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class PasswordGeneratorController
 * 
 * PHP version 8.1.6
 * 
 * @category Controller
 * @package  PasswordGenerator
 * @author   Kamil Jakubowicz <kjakubowicz98@interia.pl>
 * @license  GNU General Public License
 * @link     none
 * @return   JsonReposne
 */

class PasswordGeneratorController extends AbstractController
{
    /**
     * Password properties
     * 
     * @var array $_aCharacters the array of characters
     * @var array $_aHeaders the array od properties from header
     */
    private array $_aCharacters = [];
    private array $_aHeaders    = [];

    /**
     * Constructor for Controller
     * 
     * @return void
     */
    public function __construct()
    {
        $this->_aCharacters = [
            'symbols'   => '~`!@#$%^&*()_-+={[}]|\:;"<,>.?/',
            'lowercase' => 'abcdefghijklmnoprstuwxyzq',
            'uppercase' => 'ABCDEFGHIJKLMNOPRSTUWXYZQ',
            'numbers'   => '1234567890',
        ];
        $this->_aHeaders = apache_request_headers();
    }

    /**
     * Intermediary between the result and the action
     * 
     * @return JsonReposne
     */
    #[Route('/api/v1/password_generator', name: 'app_password_generator')]
    public function mediate(): JsonResponse
    {
        $sPassword = $this->generatePassword();

        return $this->json([
            'data'    => $sPassword,
        ]);
    }

    /**
     * Method for generate the password
     * 
     * @return string
     */
    public function generatePassword(): string
    {
        $sCharacters = '';
        $sPassword   = '';

        foreach ($this->_aCharacters as $key => $value) {
            if ($this->_aHeaders[$key] == 1) {
                $sCharacters .= $value;
            }
        }
        
        for ($i=0; $i < $this->_aHeaders['length']; $i++) { 
            $n          = rand(0, strlen($sCharacters)-1);
            $sPassword .= $sCharacters[$n];
        }

        return $sPassword;
    }
    
}