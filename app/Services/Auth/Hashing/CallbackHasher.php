<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

/**
 * Class CallbackHasher
 * Delegates the purpose of creating the hash and its verification received when creating
 * a class instance functions.
 *
 * @example
 * <code>
 *  $make = function($plainPassword) {
 *      return crc32($plainPassword); // For example is simple crc32.
 *  }
 *
 *  $check = function($plainPassword, $hashedPassword) {
 *      return crc32($plainPassword) === $hashedPassword;
 *  }
 *
 *  $hasher = new CallbackHasher($make, $check);
 * </code>
 */
class CallbackHasher implements Hasher
{
    /**
     * @var \Closure
     */
    private $makeClosure;

    /**
     * @var \Closure
     */
    private $checkClosure;

    public function __construct(\Closure $makeClosure, \Closure $checkClosure)
    {
        $this->makeClosure = $makeClosure;
        $this->checkClosure = $checkClosure;
    }

    /**
     * @inheritDoc
     */
    public function make(string $plainPassword): string
    {
        return ($this->makeClosure)($plainPassword);
    }

    /**
     * @inheritDoc
     */
    public function check(string $plainPassword, string $hashedPassword): bool
    {
        return ($this->checkClosure)($plainPassword, $hashedPassword);
    }
}
