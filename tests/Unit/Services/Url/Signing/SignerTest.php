<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Url\Signing;

use App\Services\Url\Signing\Signer;
use App\Services\Url\Signing\Signable;
use Tests\TestCase;

class SignerTest extends TestCase
{
    private const DOMAIN = 'http://example.com';

    private const ALGORITHM = 'sha256';

    private const KEY = '8O6i8mok2AFsSr7wRlhuFUbcPyANC8HZfvBXIOSbvNPU8J1NAkAoF9nzkoBd6IWE';

    private const SEPARATOR = ':';

    public function testWithoutExpirationTime(): void
    {
        $signer = new Signer(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $signable = new Signable(self::DOMAIN);
        $signable->addParameter('param1', 'param1_value')
            ->addParameter('param2', 'param2_value')
            ->addParameter('param3', 'param3_value');
        $signedUrl = $signer->create($signable);
        $expected = self::DOMAIN . '?' . http_build_query([
                'param1' => 'param1_value',
                'param2' => 'param2_value',
                'param3' => 'param3_value',
                'signature' => 'f483b6e9b90667eb9378ce273f07732c37dad718d1df56561097270ac81745e7'
            ]);

        self::assertEquals($expected, $signedUrl);
    }

    public function testWithExpirationTime(): void
    {
        $signer = new Signer(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $signable = new Signable(self::DOMAIN);
        // Timestamp: 1524331140
        $expiredAt = new \DateTimeImmutable('21 april 2018 17:19');
        $signable->addParameter('param1', 'param1_value')
            ->addParameter('param2', 'param2_value')
            ->addParameter('param3', 'param3_value')
            ->expiredAt($expiredAt);
        $signedUrl = $signer->create($signable);
        $expected = self::DOMAIN . '?' . http_build_query([
                'param1' => 'param1_value',
                'param2' => 'param2_value',
                'param3' => 'param3_value',
                'expired' => $expiredAt->getTimestamp(),
                'signature' => '27083320a159a114dd58e44975f2fd6e460de263d13079724cf68c949e1bc044'
            ]);

        self::assertEquals($expected, $signedUrl);
    }

    public function testWithoutParametersAndWithoutExpirationTime(): void
    {
        $signer = new Signer(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $signable = new Signable(self::DOMAIN);
        $signedUrl = $signer->create($signable);
        $expected = self::DOMAIN . '?' . http_build_query([
                'signature' => 'b379e5049901385eb8458712c8506827c565f72746ed12f7b1887f7db8472704'
            ]);

        self::assertEquals($expected, $signedUrl);
    }

    public function testWithoutParametersAndWithExpirationTime(): void
    {
        $signer = new Signer(self::ALGORITHM, self::KEY, self::SEPARATOR);
        $signable = new Signable(self::DOMAIN);
        // Timestamp: 1524331140
        $expiredAt = new \DateTimeImmutable('21 april 2018 17:19');
        $signable->expiredAt($expiredAt);
        $signedUrl = $signer->create($signable);
        $expected = self::DOMAIN . '?' . http_build_query([
                'expired' => $expiredAt->getTimestamp(),
                'signature' => 'a690c326c22879ae92411d693fd661467c1fb19f119a7cc9d3f39fb015523326'
            ]);

        self::assertEquals($expected, $signedUrl);
    }
}
