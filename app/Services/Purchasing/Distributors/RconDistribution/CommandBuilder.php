<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

use App\Entity\EnchantmentItem;
use App\Entity\PurchaseItem;
use App\Exceptions\NotImplementedException;
use App\Services\DateTime\DateTimeUtil;
use App\Services\Item\Enchantment\Enchantment;
use App\Services\Item\Type;
use App\Services\Product\Stack;

class CommandBuilder
{
    /**
     * @var Commands
     */
    private $commands;

    /**
     * @var ExtraCommands
     */
    private $extraCommands;

    public function __construct(Commands $commands, ExtraCommands $extraCommands)
    {
        $this->commands = $commands;
        $this->extraCommands = $extraCommands;
    }

    /**
     * @param PurchaseItem $purchaseItem
     *
     * @return ExecutableCommands
     */
    public function build(PurchaseItem $purchaseItem): ExecutableCommands
    {
        $product = $purchaseItem->getProduct();
        $item = $product->getItem();
        $purchase = $purchaseItem->getPurchase();
        $player = $purchase->getUser() !== null ? $purchase->getUser()->getUsername() : $purchase->getPlayer();
        $executableCommands = new ExecutableCommands();

        $before = [];
        foreach ($this->extraCommands->getExtraBeforeCommands() as $extraBeforeCommand) {
            $after[] = $this->replace($extraBeforeCommand, [
                'player' => $player
            ]);
        }
        $after = [];
        foreach ($this->extraCommands->getExtraAfterCommands() as $extraAfterCommand) {
            $after[] = $this->replace($extraAfterCommand, [
                'player' => $player
            ]);
        }

        $executableCommands->setExtraBeforeCommands($before);
        $executableCommands->setExtraAfterCommands($after);
        $commands = [];

        if ($item->getType() === Type::ITEM) {
            if ($purchaseItem->getAmount() <= $product->getStack()) {
                // If the quantity of items in the purchase is less than or equal to the commodity rate,
                //then only 1 request is required.
                $commands[] = $this->processItem($purchaseItem, $purchaseItem->getAmount());
            } else {
                // But if the goods are more than 1 stack, then you need to execute several requests to
                // issue all the items. This is due to the fact that Minecraft does not allow giving
                // the player more than 1 stack of items for 1 rcon command.
                $count = (int)($purchaseItem->getAmount() / $product->getStack());
                for ($i = 0; $i < $count; $i++) {
                    $commands[] = $this->processItem($purchaseItem, $product->getStack());
                }
            }
        } elseif ($item->getType() === Type::PERMGROUP) {
            if (Stack::isForever($product)) {
                $commands[] = $this->replace($this->commands->getGiveNonExpiredPermgroupCommand(), [
                    'player' => $player,
                    'permgroup' => $item->getGameId()
                ]);
            } else {
                $commands[] = $this->replace($this->commands->getGiveNonExpiredPermgroupCommand(), [
                    'player' => $player,
                    'permgroup' => $item->getGameId(),
                    'lifetime' => DateTimeUtil::daysToSeconds(($purchaseItem->getAmount()))
                ]);
            }
        } else {
            throw new NotImplementedException(
                "Feature to handle this item type {$product->getItem()} not implemented"
            );
        }

        return $executableCommands->setMainCommands($commands);
    }

    private function processItem(PurchaseItem $purchaseItem, $amount): string
    {
        $product = $purchaseItem->getProduct();
        $item = $product->getItem();
        $purchase = $purchaseItem->getPurchase();
        $player = $purchase->getUser() !== null ? $purchase->getUser()->getUsername() : $purchase->getPlayer();

        if (Enchantment::isEnchanted($item)) {
            // Enchants of the object are transferred as an array of objects in NBT with the "ench"
            // key. If the item itself already contains any or NBT data, then you need to add
            // enchantments to them.

            $nbt = [];
            if (!empty($item->getExtra())) {
                // Read the existing NBT data.
                $nbt = json_decode($item->getExtra(), true);
            }

            /** @var EnchantmentItem $enchantmentItem */
            foreach ($item->getEnchantmentItems() as $enchantmentItem) {
                $nbt['ench'][] = [
                    // In-game enchantment identifier.
                    'id' => $enchantmentItem->getEnchantment()->getGameId(),
                    // Enchantment level.
                    'lvl' => $enchantmentItem->getLevel()
                ];
            }

            return $this->replace($this->commands->getGiveEnchantedItemCommand(), [
                'player' => $player,
                'item' => $item->getGameId(),
                'amount' => $amount,
                'nbt' => $this->encode($nbt)
            ]);
        } else {
            return $this->replace($this->commands->getGiveEnchantedItemCommand(), [
                'player' => $player,
                'item' => $item->getGameId(),
                'amount' => $amount,
                // If extra is empty, create an empty NBT object. If not, add them to the team.
                'nbt' => $item->getExtra() !== null ? $this->encode($item->getExtra()) : '{}'
            ]);
        }
    }

    /**
     * Converts data to json format.
     *
     * @param mixed $data
     *
     * @return string
     */
    private function encode($data): string
    {
        // JSON_UNESCAPED_UNICODE - is very important! Otherwise, it will not be possible
        // to use Unicode characters in NBT data.
        return json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    /**
     * Replace placeholders in string.
     * <p>For example:</p>
     * <code>
     *  $subject = "Hello, {player1}, {player2}";
     *  $result = $this->replace($subject, [
     *      'player1' => 'D3lph1',
     *      'player1' => 'admin'
     *  ]);
     *  // Result contains: "Hello, D3lph1, admin"
     * </code>
     *
     * @param string $subject
     * @param array  $replace
     *
     * @return string
     */
    private function replace(string $subject, array $replace): string
    {
        foreach ($replace as $search => $replacement) {
            $subject = str_replace('{' . $search . '}', $replacement, $subject);
        }

        return $subject;
    }
}
