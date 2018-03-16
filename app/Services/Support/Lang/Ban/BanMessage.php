<?php
declare(strict_types = 1);

namespace App\Services\Support\Lang\Ban;

use App\Entity\Ban;
use App\Services\Auth\BanManager;
use App\Services\DateTime\Formatting\Formatter;

class BanMessage
{
    /**
     * @var BanManager
     */
    private $banManager;

    /**
     * @var Formatter
     */
    private $formatter;

    public function __construct(BanManager $banManager, Formatter $formatter)
    {
        $this->banManager = $banManager;
        $this->formatter = $formatter;
    }

    /**
     * @param Ban[] $bans
     *
     * @return DTO
     */
    public function buildMessageAuto(array $bans): DTO
    {
        if (count($bans) === 1) {
            /** @var Ban $ban */
            $ban = array_pop($bans);

            return new DTO($this->buildOne('common.banned.one', $ban));
        }

        $dto = new DTO(__('common.banned.many.title'));
        $messages = [];

        foreach ($bans as $ban) {
            $messages[] = $this->buildOne('common.banned.many', $ban);
        }

        return $dto->setMessages($messages);
    }

    private function buildOne(string $langKey, Ban $ban): string
    {
        if ($this->banManager->isPermanent($ban)) {
            if ($ban->getReason() === null) {
                return __("{$langKey}.permanently.without_reason");
            } else {
                return __("{$langKey}.permanently.with_reason", ['reason' => $ban->getReason()]);
            }
        } else {
            if ($ban->getReason() === null) {
                return __(
                    "{$langKey}.temporarily.without_reason",
                    [
                        'until' => $this->formatter->format($ban->getUntil())
                    ]
                );
            } else {
                return __(
                    "{$langKey}.temporarily.with_reason",
                    [
                        'until' => $this->formatter->format($ban->getUntil()),
                        'reason' => $ban->getReason()
                    ]);
            }
        }
    }
}
