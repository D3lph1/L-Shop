<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Url\Signing;

use App\Services\Url\Signing\Signed;
use App\Services\Url\Signing\Validator;
use Tests\TestCase;

class ValidatorTest extends TestCase
{
    private const ALGORITHM = 'sha256';

    private const KEY = '8O6i8mok2AFsSr7wRlhuFUbcPyANC8HZfvBXIOSbvNPU8J1NAkAoF9nzkoBd6IWE';

    private const SEPARATOR = ':';

    public function testWithoutExpirationTime(): void
    {
        $validator = new Validator(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $signed = new Signed('f483b6e9b90667eb9378ce273f07732c37dad718d1df56561097270ac81745e7', [
            'param1' => 'param1_value',
            'param2' => 'param2_value',
            'param3' => 'param3_value'
        ]);
        self::assertTrue($validator->validate($signed));
    }

    public function testWithExpirationTimeNotExpired(): void
    {
        $validator = new Validator(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $expiredAt = new \DateTimeImmutable('+ 3 days');
        $signature = hash(
            self::ALGORITHM,
            sprintf(
                "%s%s%s%s%s%s%s%s%s",
                'param1_value',
                self::SEPARATOR,
                'param2_value',
                self::SEPARATOR,
                'param3_value',
                self::SEPARATOR,
                $expiredAt->getTimestamp(),
                self::SEPARATOR,
                self::KEY
            )
        );
        $signed = (new Signed($signature, [
            'param1' => 'param1_value',
            'param2' => 'param2_value',
            'param3' => 'param3_value',
        ]))
            ->setExpiredAt($expiredAt);

        self::assertTrue($validator->validate($signed));
    }

    public function testWithExpirationTimeExpired(): void
    {
        $validator = new Validator(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $expiredAt = new \DateTimeImmutable('- 3 days');
        $signature = hash(
            self::ALGORITHM,
            sprintf(
                "%s%s%s%s%s%s%s%s%s",
                'param1_value',
                self::SEPARATOR,
                'param2_value',
                self::SEPARATOR,
                'param3_value',
                self::SEPARATOR,
                $expiredAt->getTimestamp(),
                self::SEPARATOR,
                self::KEY
            )
        );
        $signed = (new Signed($signature, [
            'param1' => 'param1_value',
            'param2' => 'param2_value',
            'param3' => 'param3_value',
        ]))
            ->setExpiredAt($expiredAt);

        self::assertFalse($validator->validate($signed));
    }

    public function testWithoutParametersAndWithoutExpirationTime(): void
    {
        $validator = new Validator(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $signed = new Signed('b379e5049901385eb8458712c8506827c565f72746ed12f7b1887f7db8472704');
        self::assertTrue($validator->validate($signed));
    }
}
