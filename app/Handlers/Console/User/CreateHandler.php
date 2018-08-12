<?php
declare(strict_types = 1);

namespace App\Handlers\Consoe\User;

use App\Entity\User;
use App\Exceptions\InvalidArgumentException;
use App\Repository\User\UserRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Validation\Rule;
use App\Services\Validation\RulesBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

class CreateHandler
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var Repository
     */
    private $config;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $activate;

    public function __construct(Factory $factory, Repository $config, UserRepository $userRepository, Auth $auth)
    {
        $this->factory = $factory;
        $this->config = $config;
        $this->userRepository = $userRepository;
        $this->auth = $auth;
    }

    /**
     * Creates a new user
     *
     * @throws \Exception
     */
    public function handle(): void
    {
        $this->auth->register(new User($this->username, $this->email, $this->password), $this->activate);
    }

    /**
     * @param string $username
     *
     * @throws ValidationException
     * @throws UsernameAlreadyExistsException
     */
    public function setUsername(string $username): void
    {
        $this->factory->make(compact('username'), [
            'username' => (new RulesBuilder())
                ->addRule(new Rule('required'))
                ->addRule(new Rule('string'))
                ->addRule(new Rule('min', $this->config->get('auth.validation.username.min')))
                ->addRule(new Rule('max', $this->config->get('auth.validation.username.max')))
                ->addRule(new Rule($this->config->get('auth.validation.username.rule')))
                ->build()
        ])->validate();

        if ($this->userRepository->findByUsername($username) !== null) {
            throw new UsernameAlreadyExistsException($username);
        }

        $this->username = $username;
    }

    /**
     * @param string $email
     *
     * @throws ValidationException
     * @throws EmailAlreadyExistsException
     */
    public function setEmail(string $email): void
    {
        $this->factory->make(compact('email'), [
            'email' => 'required|email'
        ])->validate();

        if ($this->userRepository->findByEmail($email) !== null) {
            throw new EmailAlreadyExistsException($email);
        }

        $this->email = $email;
    }

    /**
     * @param string $password
     *
     * @throws ValidationException
     */
    public function setPassword(string $password): void
    {
        $this->factory->make(compact('password'), [
            'password' => (new RulesBuilder())
                ->addRule(new Rule('required'))
                ->addRule(new Rule('string'))
                ->addRule(new Rule('min', $this->config->get('auth.validation.password.min')))
                ->addRule(new Rule('max', $this->config->get('auth.validation.password.max')))
                ->build()
        ])->validate();

        $this->password = $password;
    }

    /**
     * @param string $passwordConfirmation
     *
     * @throws InvalidArgumentException
     */
    public function setPasswordConfirmation(string $passwordConfirmation): void
    {
        if ($passwordConfirmation !== $this->password) {
            throw new InvalidArgumentException('Passwords must be equivalent');
        }
    }

    public function setActivate(bool $activate): void
    {
        $this->activate = $activate;
    }
}
